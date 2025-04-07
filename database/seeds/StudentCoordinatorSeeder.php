<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class StudentCoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user102 = User::create([
            'name'          => 'Madam Yvonne Van-Djik',
            'email'         => 'yvonne-vandjik@demo.com',
            'password'      => bcrypt('qwertyuiop123'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user102->assignRole('StudCoordinator');
    }
}
