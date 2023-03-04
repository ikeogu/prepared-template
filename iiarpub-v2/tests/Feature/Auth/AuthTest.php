<?php


use App\Models\User;

it('can login', function () {
    $user = User::factory()->create(
        [
            'password' => bcrypt($password = 'Password1!'),
        ]
    );

    $res = $this->post(route('login'), [
        'email' => $user->email,
        'password' => $password,
    ]);

    $res->assertOk();
    expect($res['data']['user'])->toBeArray();
    expect($res['data']['token'])->toBeString();
});

it('can not login with invalid password', function () {
    $user = User::factory()->create(
        [
            'password' => bcrypt($password = 'Password1!'),
        ]
    );

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'Wrong-password2',
    ]);

    expect($response['message'])->toBe('Password mismatched');
    $response->assertStatus(422);
    $this->assertGuest();
});

/* it('can view user details', function () {
    actingAs();

    $response = $this->get(route('user-details'));

    $response->assertOk();

    expect($response)->toBeObject();
}); */

/* it('can not access protected route', function () {
    $response = $this->get(route('user-details'), ['HTTP_Accept' => 'application/json']);

    $response->assertStatus(401);
});
 */
it('can logout', function () {
    actingAs();

    $response = $this->delete(route('logout'), ['HTTP_Accept' => 'application/json']);

    $response->assertOk();
    expect($response['message'])->toBeString()->toBe('Logged out successfully');
});