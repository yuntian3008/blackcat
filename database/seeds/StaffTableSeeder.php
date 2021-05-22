<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Staff;
use App\Role;
class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $saRole = Role::firstWhere("code","superadmin");
        $adminRole = Role::firstWhere("code","admin");
        $productRole = Role::firstWhere("code","productmanager");
        $orderRole = Role::firstWhere("code","ordermanager");
        $shipperRole = Role::firstWhere("code","shipper");

        $sa = new Staff();
        $sa->first_name =  'admin';
        $sa->last_name = 'super';
        $sa->username ='superadmin';
        $sa->password = Hash::make('00000000');
        $sa->save();
        $sa->generateToken();
        $sa->roles()->attach($saRole);

        $admin = new Staff();
        $admin->first_name =  'admin';
        $admin->last_name = '';
        $admin->username ='admin';
        $admin->password = Hash::make('00000000');
        $admin->save();
        $admin->generateToken();
        $admin->roles()->attach($adminRole);

        $product = new Staff();
        $product->first_name =  'product';
        $product->last_name = 'manager';
        $product->username ='product';
        $product->password = Hash::make('00000000');
        $product->save();
        $product->generateToken();
        $product->roles()->attach($productRole);

        $order = new Staff();
        $order->first_name =  'order';
        $order->last_name = 'manager';
        $order->username ='order';
        $order->password = Hash::make('00000000');
        $order->save();
        $order->generateToken();
        $order->roles()->attach($orderRole);

        $shipper = new Staff();
        $shipper->first_name =  'shipper';
        $shipper->last_name = 'staff';
        $shipper->username ='shipper';
        $shipper->password = Hash::make('00000000');
        $shipper->save();
        $shipper->generateToken();
        $shipper->roles()->attach($shipperRole);

    }
}
