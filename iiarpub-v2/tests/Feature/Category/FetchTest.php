<?php

use App\Enums\HttpStatusCode;
use App\Models\Category;
use function Pest\Laravel\assertDatabaseCount;

it('has category/fetch all', function () {
    $user = actingAs();
    $category = Category::factory(10)->create();

    $response = $this->get(route('category.index'))
        ->assertStatus(HttpStatusCode::SUCCESSFUL->value);
    assertDatabaseCount('categories', 10);
    expect($response['success'])->toBeTruthy();
    expect($response['message'])->toBe('categories fetched successfully');
});

it('has category/fetch one', function () {
    $user = actingAs();
    $category = Category::factory()->create();

    $response = $this->get(route('category.show', ['category' => $category->id]))
        ->assertStatus(HttpStatusCode::SUCCESSFUL->value);
    assertDatabaseCount('categories', 11);
    expect($response['success'])->toBeTruthy();
    expect($response['message'])->toBe('category fetched successfully');
});