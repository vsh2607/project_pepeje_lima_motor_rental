<?php

namespace Database\Seeders;

use App\Models\MasterUserType;
use Illuminate\Database\Seeder;

class MasterUserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterUserType::create([
            'name' => 'ADMIN'
        ]);

        MasterUserType::create([
            'name' => 'USER'
        ]);


    }
}
