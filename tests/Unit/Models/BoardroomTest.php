<?php

namespace Tests\Unit\Models;

use App\Models\Boardroom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardroomTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_many_reservations()
    {
        $boardroom = new Boardroom;
        $this->assertInstanceOf(Collection::class, $boardroom->reservations);
    }

}
