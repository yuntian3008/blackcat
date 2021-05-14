<?php

use Illuminate\Database\Seeder;
use App\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Plant::class, 100)->create();
    }
}
