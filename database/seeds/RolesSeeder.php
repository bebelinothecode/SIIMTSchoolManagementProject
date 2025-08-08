<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Permission::create(['name' => 'edit articles']);

        $role = Role::firstOrCreate(['name' => 'Admin']);
        $role = Role::firstOrCreate(['name' => 'Teacher']);
        $role = Role::firstOrCreate(['name' => 'Parent']);
        $role = Role::firstOrCreate(['name' => 'Student']);
        $role = Role::firstOrCreate(['name' => 'AsstAccount']);
        $role = Role::firstOrCreate(['name' => 'StudCoordinator']);
        $role = Role::firstOrCreate(['name' => 'frontdesk']);
        $role = Role::firstOrCreate(['name' => 'rector']);
        $role = Role::firstOrCreate(['name' => 'HR']);
        $role = Role::firstOrCreate(['name' => 'registrar']);
        $role = Role::firstOrCreate(['name'=>'Librarian']);
    }
}
