<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoardroomControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_guest()
    {
        $this->get('boardrooms')->assertRedirect('login'); //index
        $this->get('boardrooms/1')->assertRedirect('login'); //show
        $this->put('boardrooms/1')->assertRedirect('login'); //update
        $this->delete('boardrooms/1')->assertRedirect('login'); //destroy
        $this->post('boardrooms', [])->assertRedirect('login'); //store
    }

    public function test_index()
    {
        $user = User::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->get('boardrooms')
            ->assertStatus(200);
    }

    public function test_store()
    {
        $data = [
            'name' => $this->faker->word
        ];
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('boardrooms', $data)
            ->assertStatus(201);

        $this->assertDatabaseHas('boardrooms', $data);
    }

    public function test_validation_store()
    {
        $user = User::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->post("boardrooms", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }
}
