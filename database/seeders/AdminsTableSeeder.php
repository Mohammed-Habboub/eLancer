<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Mohammed Habboub',
            'email' => 'm@habboub.com',
            'password' => Hash::make('password'),
            'super_admin' => 1,
            'status' => 'active',

        ]);
    }
}
