<?php

namespace Database\Seeders;

use App\Models\MasterUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterUser::create([
            'name' => 'Admin',
            'username' => 'admin',
            'user_type' => 'ADMIN',
            'password' => Hash::make('123')
        ]);
    }
}
