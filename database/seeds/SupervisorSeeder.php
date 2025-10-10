<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\User;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user2446 = User::create([
            'name'          => 'Mr. Komla',
            'email'         => 'mrkomala123@demo.com',
            'password'      => bcrypt('qwertyuiop123'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user2446->assignRole('Supervisor'); 
    }
}
