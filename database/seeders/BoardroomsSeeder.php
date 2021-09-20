<?php

namespace Database\Seeders;

use App\Models\Boardroom;
use Illuminate\Database\Seeder;

class BoardroomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Boardroom::factory(30)->create();
    }
}
