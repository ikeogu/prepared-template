<?php

use App\Enums\HttpStatusCode;
use App\Models\Category;

it('has category/update page', function () {
    $user = actingAs();
    $category = Category::factory()->create();

    $data = [
        'name' => fake()->name(),
        'description' => fake()->text()
    ];

    $response = $this->put(route('category.update', ['category' => $category->id]), $data)
        ->assertStatus(HttpStatusCode::SUCCESSFUL->value);

    expect($response['success'])->toBeTruthy();
    expect($response['message'])->toBe('category updated successfully');
});