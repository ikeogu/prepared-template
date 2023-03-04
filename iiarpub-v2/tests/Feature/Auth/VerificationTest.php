<?php

use App\Enums\HttpStatusCode;
use App\Models\EmailVerification;
use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('can verify otp', function () {
    $user = actingAs();

    $otpModel = EmailVerification::factory()->create(['email' => $user->email, 'otp' => 1234]);

    $response = $this->post(route('verify-otp'), ['otp' => $otpModel->otp]);

    $response->assertStatus(HttpStatusCode::SUCCESSFUL->value);

    assertDatabaseCount('email_verifications', 0);
    assertDatabaseMissing('email_verifications', ['otp' => $otpModel]);
});

it('can verify if not logged in otp', function () {
    $user = User::factory()->create();
    $otpModel = EmailVerification::factory()->create(['email' => $user->email, 'otp' => 1234]);

    $response = $this->post(route('verify-otp'), ['otp' => $otpModel->otp]);

    $response->assertStatus(302);

    assertDatabaseCount('email_verifications', 1);
    assertDatabaseHas('email_verifications', ['otp' => $otpModel->otp]);
});

it('cannot verify otp if  validation error', function () {
    $user = actingAs();
    $otpModel = EmailVerification::factory()->create(['email' => $user->email, 'otp' => 1234]);

    $response = $this->post(route('verify-otp'), ['otp' => 2345]);

    $response->assertStatus(HttpStatusCode::VALIDATION_ERROR->value);

    assertDatabaseCount('email_verifications', 2);
    assertDatabaseHas('email_verifications', ['otp' => $otpModel->otp]);
});

it('cannot verify otp if otp supplied has expired', function () {
    $user = actingAs();
    $otpModel = EmailVerification::factory()->create([
        'email' => $user->email,
        'otp' => 1234,
        'expired_at' => now()->subMinutes(10)
    ]);

    $response = $this->post(route('verify-otp'), ['otp' => 1234]);

    $response->assertStatus(HttpStatusCode::BAD_REQUEST->value);

    assertDatabaseCount('email_verifications', 3);
    assertDatabaseHas('email_verifications', ['otp' => $otpModel->otp]);

    expect(json_decode($response->getContent(), true))->toMatchArray([
        'success' => false,
        'message' => 'OTP expired'
    ]);
});

it('can resend otp', function () {
    actingAs();

    $response = $this->post(route('resend-otp'));

    $response->assertStatus(HttpStatusCode::SUCCESSFUL->value);

    assertDatabaseCount('email_verifications', 4);

    expect(json_decode($response->getContent(), true))->toMatchArray([
        'success' => true,
        'message' => 'OTP resent successfully',
        'data' => []
    ]);
});