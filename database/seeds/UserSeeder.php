<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user99 = User::create([
            'name'          => 'Christabel Sowah',
            'email'         => 'christabelsowah@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user99->assignRole('frontdesk');

        $user100 = User::create([
<<<<<<< HEAD
=======

>>>>>>> fff5d2927a52c929df191b0689df7dd6280844bf
            'name'          => 'Cindy Amartei',
            'email'         => 'cindyamartei@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user100->assignRole('frontdesk');
    }
}
