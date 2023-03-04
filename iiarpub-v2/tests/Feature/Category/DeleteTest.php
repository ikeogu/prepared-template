<?php

use App\Enums\HttpStatusCode;
use App\Models\Category;

it('has category/delete', function () {
    $user = actingAs();
    $category = Category::factory()->create();

    $response = $this->delete(route('category.destroy', ['category' => $category->id]))
        ->assertStatus(HttpStatusCode::SUCCESSFUL->value);

    expect($response['success'])->toBeTruthy();
    expect($response['message'])->toBe('category deleted successfully');

});