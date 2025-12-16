<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(RolesAndPermissionsSeeder::class);

        $user1 = User::create([
            'name'          => 'Admin',
            'email'         => 'admin@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user1->assignRole('Admin');

        $user9 = User::create([
            'name'          => 'Assistant-Accountant',
            'email'         => 'asstaccount@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user9->assignRole('AsstAccount');

        $user10 = User::create([
            'name'          => 'Student-Coordinator',
            'email'         => 'studcoordinator@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user10->assignRole('StudCoordinator');

        $user11 = User::create([
            'name'          => 'Front-desk',
            'email'         => 'frontdesk@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user11->assignRole('frontdesk');

        $user6 = User::create([
            'name'          => 'Rector',
            'email'         => 'rector@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user6->assignRole('rector');

        // DB::table('rector')->insert([
        //     [
        //         'user_id'           => $user6->id,
        //         'phone_number'      => '0123456789',
        //         'created_at'        => date("Y-m-d H:i:s")
        //     ]
        // ]);

        $user7 = User::create([
            'name'          => 'HR',
            'email'         => 'hr@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user7->assignRole('HR');

        $user8 = User::create([
            'name'          => 'Registrar',
            'email'         => 'registrar@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user8->assignRole('registrar');

        // Create Supervisor role
        Role::firstOrCreate(['name' => 'Supervisor']);

        $user2 = User::create([
            'name'          => 'Teacher',
            'email'         => 'teacher@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user2->assignRole('Teacher');

        $user3 = User::create([
            'name'          => 'Parent',
            'email'         => 'parent@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user3->assignRole('Parent');

        $user4 = User::create([
            'name'          => 'Student',
            'email'         => 'student@demo.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user4->assignRole('Student');


        DB::table('teachers')->insert([
            [
                'user_id'           => $user2->id,
                'gender'            => 'male',
                'phone'             => '0123456789',
                'dateofbirth'       => '1993-04-11',
                'current_address'   => 'Dhaka-1215',
                'permanent_address' => 'Dhaka-1215',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

        DB::table('parents')->insert([
            [
                'user_id'           => $user3->id,
                'gender'            => 'male',
                'phone'             => '0123456789',
                'current_address'   => 'Dhaka-1215',
                'permanent_address' => 'Dhaka-1215',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

        // DB::table('grades')->insert([
        //     // 'teacher_id'        => 1,
        //     'class_numeric'     => 1,
        //     'class_name'        => 'One',
        //     'class_description' => 'class one'
        // ]);

        DB::table('students')->insert([
            [
                'user_id'           => $user4->id,
                'parent_id'         => 1,
                // 'class_id'          => 1,
                // 'roll_number'       => 1,
                'gender'            => 'male',
                'phone'             => '0123456789',
                'dateofbirth'       => '1993-04-11',
                'current_address'   => 'Dhaka-1215',
                // 'permanent_address' => 'Dhaka-1215',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

    }
}
