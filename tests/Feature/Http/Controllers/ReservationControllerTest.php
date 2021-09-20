<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Boardroom;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_guest_reservation()
    {
        $this->get('reservations')->assertRedirect('login'); //index
        $this->get('reservations/1')->assertRedirect('login'); //show
        $this->put('reservations/1')->assertRedirect('login'); //update
        $this->delete('reservations/1')->assertRedirect('login'); //destroy
        $this->post('reservations', [])->assertRedirect('login'); //store
    }

    public function test_index_reservations_of_specified_boardroom()
    {
        $boardroom = Boardroom::factory()->create();
        Reservation::factory()->create(['boardroom_id' => $boardroom->id]);
        $user = User::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->get("reservations?boardroomId=$boardroom->id")
            ->assertJsonFragment(['count' => 1])
            ->assertStatus(200);
    }

    public function test_store_reservation()
    {
        $boardroom = Boardroom::factory()->create();
        $user = User::factory()->create();
        $data = [
            'boardroom_id' => $boardroom->id,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addHours(2)->format('Y-m-d H:i:s'),
        ];

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->post("reservations", $data)
            ->assertStatus(201);

        $this->assertDatabaseHas('reservations', $data);
    }

    public function test_validate_reservation()
    {
        $user = User::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->post("reservations", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['start_date', 'end_date', 'boardroom_id']);
    }

    public function test_cant_reserve_for_more_than_two_hours()
    {
        $boardroom = Boardroom::factory()->create();
        $user = User::factory()->create();
        $data = [
            'boardroom_id' => $boardroom->id,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addHours(3)->format('Y-m-d H:i:s'),
        ];

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->post("reservations", $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['end_date']);
    }

    public function test_cant_reserve_boardroom_twice_in_use()
    {
        $user = User::factory()->create();
        $boardroom = Boardroom::factory()->create();
        $data = [
            'boardroom_id' => $boardroom->id,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addHours(2)->format('Y-m-d H:i:s'),
        ];
        Reservation::factory()->create($data);

        $this->actingAs($user)
            ->post("reservations", $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['boardroom_id']);
    }

    public function test_show_reservation()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create();

        $this->withExceptionHandling();
        $response = $this->actingAs($user)
            ->get("reservations/$reservation->id")
            ->assertStatus(200)->getContent();

        $response = json_decode($response);

        $this->assertEquals($reservation->id, $response->id);
    }

    public function test_update_reservation()
    {
        $boardroom = Boardroom::factory()->create();
        $user = User::factory()->create();
        $data = [
            'boardroom_id' => $boardroom->id,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addHours(2)->format('Y-m-d H:i:s'),
        ];
        $reservation = Reservation::factory()->create(['boardroom_id' => $boardroom->id]);

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->put("reservations/$reservation->id", $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('reservations', $data);
    }

    public function test_destroy_reservation()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create();

        $this->withExceptionHandling();
        $this->actingAs($user)
            ->delete("reservations/$reservation->id")
            ->assertStatus(200);

        $this->assertSoftDeleted('reservations', [
           'id' => $reservation->id,
        ]);
    }
}
