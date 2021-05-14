<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Permission;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_superadmin  = Permission::where('name', 'superadmin')->first();
 
        $admin = new User();
        $admin->fname = 'Super';
        $admin->lname = 'Admin';
        $admin->gender = 'male';
        $admin->email = 'sa@admin.com';
        $admin->api_token = Str::random(60);
        $admin->isAdmin = true;
        $admin->password = Hash::make("123456");
        $admin->save();
        $admin->permissions()->attach($permission_superadmin);

        $admin = new User();
        $admin->fname = 'Thien';
        $admin->lname = 'Nguyen';
        $admin->gender = 'male';
        $admin->email = 'admin@admin.com';
        $admin->api_token = Str::random(60);
        $admin->isAdmin = true;
        $admin->password = Hash::make("123456");
        $admin->save();
 
    }
}
