<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Permission;
use App\User;
class AttachSuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::where('email', 'sa@admin.com')->first();

        $permission_superadmin  = Permission::where('name', 'superadmin')->first();
 
        $superadmin->permissions()->attach($permission_superadmin);

 
    }
}
