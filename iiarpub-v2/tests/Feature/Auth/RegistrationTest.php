<?php

use App\Enums\HttpStatusCode;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    Notification::fake();
});

it('register successfully', function () {
    $data = [
        'first_name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => fake()->unique()->safeEmail(),
        'phone' => fake()->phoneNumber(),
        'password' => 'Password1!'
    ];

    $response = $this->post(route('register'), $data);

    $response->assertStatus(HttpStatusCode::SUCCESSFUL->value);

    assertDatabaseCount('users', 1);
    assertDatabaseHas('users', Arr::except($data, ['password']));
    assertDatabaseCount('email_verifications', 1);
});

it('cannot register if validation error', function () {
    $data = [
        'first_name' => 'Ibrahim',
        'last_name' => 'Lasisi',
        'email' => 'invalid email',
        'password' => 'invalid password'
    ];

    $response = $this->post(route('register'), $data);

    $response->assertStatus(HttpStatusCode::VALIDATION_ERROR->value);

    assertDatabaseCount('users', 1);
    assertDatabaseMissing('users', Arr::except($data, ['password']));
});
