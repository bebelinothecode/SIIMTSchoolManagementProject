<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class HRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user101 = User::create([
            'name'          => 'Mr.Chai',
            'email'         => 'chaihr@demo.com',
            'password'      => bcrypt('qwertyuiop123'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user101->assignRole('HR');
        //
    }
}
