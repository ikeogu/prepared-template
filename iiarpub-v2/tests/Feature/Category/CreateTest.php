<?php

use App\Enums\HttpStatusCode;
use Illuminate\Http\File;
use Illuminate\Support\Arr;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('can category/ be created', function () {
    $user = actingAs();
    $data = [
        'name' => fake()->name(),
        'description' => fake()->text()
    ];

    $response = $this->post(route('category.store'), $data);

    $response->assertStatus(HttpStatusCode::SUCCESSFUL->value);

    assertDatabaseCount('categories', 1);
    assertDatabaseHas('categories', $data);
    expect($response['success'])->toBeTruthy();
    expect($response['message'])->toBe('category created successfully');

});