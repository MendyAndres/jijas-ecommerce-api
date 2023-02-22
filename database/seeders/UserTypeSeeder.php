<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            [
                'cod'         => 'ADMIN',
                'title'       => 'Administrador',
                'description' => 'User with root access'
            ],
            [
                'cod'         => 'SALES',
                'title'       => 'Ventas',
                'description' => 'User with sales access'
            ],
        ]
        );
    }
}
