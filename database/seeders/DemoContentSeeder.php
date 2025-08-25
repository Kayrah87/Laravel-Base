<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class DemoContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional demo users
        $users = User::factory(10)->create();

        $this->command->info('Created 10 additional demo users');

        // Create some activity log entries for demo
        $adminUser = User::where('email', 'admin@example.com')->first();
        
        if ($adminUser) {
            activity()
                ->performedOn($adminUser)
                ->causedBy($adminUser)
                ->withProperties(['action' => 'profile_updated'])
                ->log('Updated profile information');

            activity()
                ->causedBy($adminUser)
                ->withProperties(['action' => 'login'])
                ->log('Logged into the system');
        }

        // Log activities for some other users
        foreach ($users->take(3) as $user) {
            activity()
                ->causedBy($user)
                ->withProperties(['action' => 'registration'])
                ->log('User registered');

            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->withProperties(['action' => 'profile_created'])
                ->log('Created user profile');
        }

        $this->command->info('Created demo activity log entries');
        $this->command->info('Demo content seeding completed successfully!');
        
        $this->command->newLine();
        $this->command->comment('Demo Users Created:');
        $this->command->line('• superadmin@example.com (Super Admin)');
        $this->command->line('• admin@example.com (Admin)');
        $this->command->line('• moderator@example.com (Moderator)');
        $this->command->line('• user@example.com (Regular User)');
        $this->command->line('• Plus 10 additional demo users');
        $this->command->line('Default password for all users: password');
    }
}
