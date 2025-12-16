<?php

namespace App\Console\Commands;

use App\Staff;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRolesToStaff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-roles-to-staff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to existing staff based on their position';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $staffMembers = Staff::with('user')->get();

        foreach ($staffMembers as $staff) {
            $roleName = $staff->position;
            if (Role::where('name', $roleName)->exists() && $staff->user->roles->isEmpty()) {
                $staff->user->assignRole($roleName);
                $this->info("Assigned role '{$roleName}' to user {$staff->user->name}");
            }
        }

        $this->info('Role assignment completed.');
    }
}
