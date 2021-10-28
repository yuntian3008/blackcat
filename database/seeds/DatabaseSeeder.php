<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(PlantSeeder::class);
        //$this->call(RoleTableSeeder::class);  
        $this->call(SettingTableSeeder::class);
    }
}
