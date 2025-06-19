<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class LibrarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user254 = User::create([
            'name'          => 'Madam Sarah Tetteh',
            'email'         => 'sarahtetteh123@demo.com',
            'password'      => bcrypt('qwertyuiop123'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user254->assignRole('Librarian'); 
    }
}
