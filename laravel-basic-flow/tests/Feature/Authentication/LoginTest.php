<?php
use App\Models\User;

it('user can login', function () {

    $user = User::factory()->create([
        'password' => "R@ssw0rd!"
    ]);
    $data = [

        'email' => $user->email,
        'password' => "R@ssw0rd!",
    ];

    $reponse = $this->postJson(route('login', $data));
    $reponse->assertStatus(200);

    $this->assertDatabaseCount('users', 1);
    expect($reponse['status'])->toBeTruthy();
    expect($reponse['message'])->toBe('User Login successfully');

});