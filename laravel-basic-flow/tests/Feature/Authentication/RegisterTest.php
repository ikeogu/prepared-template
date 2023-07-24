<?php

use Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('user register', function () {

    $data = [
        'name'=> fake()->name(),
        'email' => fake()->email(),
        'password' => "R@ssw0rd!",
        'password_confirmation' => "R@ssw0rd!",
        "is_subscribed" => 1

    ];

    $reponse = $this->postJson(route('register', $data));
    $reponse->assertStatus(200);

    $this->assertDatabaseCount('users', 1);
    expect($reponse['status'])->toBeTruthy();
    expect($reponse['message'])->toBe('User created successfully');

});
