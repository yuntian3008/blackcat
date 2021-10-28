<?php

use Illuminate\Database\Seeder;
use App\Setting;
class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
        'option' => 'order_processing_warning_time',
        'value' => '2',
        ]);

        Setting::create([
        'option' => 'order_processing_late_time',
        'value' => '3',
        ]);

        Setting::create([
        'option' => 'order_shipping_warning_time',
        'value' => '2',
        ]);

        Setting::create([
        'option' => 'order_shipping_late_time',
        'value' => '3',
        ]);
        
    }
}
