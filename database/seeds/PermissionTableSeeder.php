<?php

use Illuminate\Database\Seeder;
use App\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Permission();
        $role_admin->name = 'superadmin';
        $role_admin->display_name = 'Super admin';
        $role_admin->desc = 'Full access';
        $role_admin->save();
        
    }
}
