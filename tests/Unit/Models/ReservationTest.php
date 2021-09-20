<?php

namespace Tests\Unit\Models;

use App\Models\Boardroom;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_boardroom()
    {
        $reservation = Reservation::factory()->create();

        $this->assertInstanceOf(Boardroom::class, $reservation->boardroom);
    }
}
