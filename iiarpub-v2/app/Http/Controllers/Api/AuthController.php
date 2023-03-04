<?php

namespace App\Http\Controllers\Api;

use App\Enums\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmEmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Resources\UserResource;
use App\Models\EmailVerification;
use App\Models\User;
use App\Services\VerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;
use DB;

class AuthController extends Controller
{
    //
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password mismatched'],
            ]);
        }

        $token = $user->createToken("$user->first_name $user->last_name token")->accessToken;

        return $this->success(
            message: 'Login suceessful',
            data: [
                'user' => new UserResource($user),
                'token' => $token,
            ]
        );
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::create($request->validated());

        $user->assignRole('creator administrator');

        $token = $user->createToken("$user->first_name $user->last_name token")->accessToken;

        VerificationService::generateAndSendOtp($user);

        return $this->success(
            message: 'Registration successful',
            data: ['token' => $token]
        );
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        /** @var User */
        $loggedUser = auth()->user();

        /** @var EmailVerification */
        $isValidOtp = EmailVerification::firstWhere(['email' => $loggedUser->email, 'otp' => $request->otp]);

        if (now()->greaterThan($isValidOtp->expired_at)) {
            return $this->failure(
                message: 'OTP expired',
                status: HttpStatusCode::BAD_REQUEST->value
            );
        }

        return DB::transaction(function () use ($loggedUser, $isValidOtp) {
            $loggedUser->update(['email_verified_at' => now()]);

            $isValidOtp->delete();

            return $this->success(
                message: 'OTP verified successfully'
            );
        });
    }

    public function resendOtp(): JsonResponse
    {
        /** @var User */
        $loggedUser = auth()->user();

        VerificationService::generateAndSendOtp($loggedUser);

        return $this->success(
            message: 'OTP resent successfully'
        );
    }

    public function confirmEmail(ConfirmEmailRequest $request): JsonResponse
    {
        /** @var User */
        $user = User::where('email', $request->email)->first();
        VerificationService::generateAndSendOtp($user);

        return $this->success(message: 'A token has be sent to your mail');
    }

    public function verifyForgetonPasswordOtp(VerifyOtpRequest $request): JsonResponse
    {
        /** @var EmailVerification */
        $isValidOtp = EmailVerification::firstWhere(['otp' => $request->otp]);

        if (now()->greaterThan($isValidOtp->expired_at)) {
            return $this->failure(
                message: 'OTP expired',
                status: HttpStatusCode::BAD_REQUEST->value
            );
        }
        $isValidOtp->delete();

        return $this->success(
            message: 'OTP verified successfully'
        );
    }

    public function resetPasword(PasswordResetRequest $request): JsonResponse
    {
        /** @var User @user */
        $user = User::where('email', $request->email)->first();
        // @phpstan-ignore-next-line
        if (empty($user)) {
            return $this->failure(
                message: 'This user do not exist',
                status: HttpStatusCode::BAD_REQUEST->value
            );
        }
        $user->fill(['password' => Hash::make($request->password)]);
        $user->save();

        return $this->success(
            message: 'Password  reset successfully',
            data: ['user' => $user]
        );
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Token $token */
        $token = $user->token();

        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($token->id);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);

        return response()->json(['message' => 'Logged out successfully']);
    }
}