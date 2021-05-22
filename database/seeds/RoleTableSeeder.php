<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sa = Role::create([
        'name' => 'Super admin',
        'code' => 'superadmin',
        'desc' => 'Full access',
        ]);

        $admin = Role::create([
        'name' => 'Admin',
        'code' => 'admin',
        'desc' => 'Manage customer, staff, role of staff',
        ]);

        $productmanager = Role::create([
        'name' => 'Product manager',
        'code' => 'productmanager',
        'desc' => 'Manage categories, products, properties of products',
        ]);

        $ordermanager = Role::create([
        'name' => 'Order manager',
        'code' => 'ordermanager',
        'desc' => 'Receive orders and process orders',
        ]);

        $shipper = Role::create([
        'name' => 'Shipper',
        'code' => 'shipper',
        'desc' => 'Deliver and done',
        ]);
        
    }
}
