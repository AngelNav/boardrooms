<?php

namespace Database\Factories;

use App\Models\Boardroom;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'boardroom_id' => Boardroom::factory(),
            'start_date' => $this->faker->dateTimeBetween('now', '+2 hours'),
            'end_date' => $this->faker->dateTimeBetween('now', '+2 hours'),
        ];
    }
}
