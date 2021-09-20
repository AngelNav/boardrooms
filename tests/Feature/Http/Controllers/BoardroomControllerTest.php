<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Boardroom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoardroomControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_guest_boardroom()
    {
        $this->get('boardrooms')->assertRedirect('login'); //index
        $this->get('boardrooms/1')->assertRedirect('login'); //show
        $this->put('boardrooms/1')->assertRedirect('login'); //update
        $this->delete('boardrooms/1')->assertRedirect('login'); //destroy
        $this->post('boardrooms', [])->assertRedirect('login'); //store
    }

    public function test_index_boardroom()
    {
        $user = User::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->get('boardrooms')
            ->assertStatus(200);
    }

    public function test_store_boardroom()
    {
        $data = [
            'name' => $this->faker->text(10)
        ];
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('boardrooms', $data)
            ->assertStatus(201);

        $this->assertDatabaseHas('boardrooms', $data);
    }

    public function test_validate_store_boardroom()
    {
        $user = User::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->post("boardrooms", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function test_show_boardroom()
    {
        $user = User::factory()->create();
        $boardroom = Boardroom::factory()->create();

        $this->withExceptionHandling();
        $response = $this->actingAs($user)
            ->get("boardrooms/$boardroom->id")
            ->assertStatus(200)->getContent();

        $response= json_decode($response);

        $this->assertEquals($boardroom->id, $response->id);
    }

    public function test_update_boardroom()
    {
        $data = [
            'name' => $this->faker->text(10)
        ];
        $user = User::factory()->create();
        $boardroom = Boardroom::factory()->create();

        $this->actingAs($user)
            ->put("boardrooms/$boardroom->id", $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('boardrooms', $data);
    }

    public function test_validate_update_boardroom()
    {
        $user = User::factory()->create();
        $boardroom = Boardroom::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->put("boardrooms/$boardroom->id", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function test_destroy_boardroom()
    {
        $user = User::factory()->create();
        $boardroom = Boardroom::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->delete("boardrooms/$boardroom->id")
            ->assertStatus(200);

        $this->assertSoftDeleted('boardrooms', [
            'id' => $boardroom->id,
            'name' => $boardroom->name,
        ]);
    }
}
