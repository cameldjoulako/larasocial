<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin();
        $admin->name = "Adnan";
        $admin->email = "adnan@gmail.com";
        $admin->password = Hash::make("adnan");
        $admin->role = "super_admin";
        $admin->save();
    }
}
