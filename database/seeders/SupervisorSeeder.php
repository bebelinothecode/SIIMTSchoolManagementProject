<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user2446 = User::firstOrCreate([
             'email'         => 'mrkomala123@demo.com'
         ], [
             'name'          => 'Mr. Komla',
             'password'      => bcrypt('qwertyuiop123'),
             'created_at'    => date("Y-m-d H:i:s")
         ]);
         if (!$user2446->hasRole('Supervisor')) {
             $user2446->assignRole('Supervisor');
         }
    }
}
