<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsAndRolesSeeder::class,
            SettingsSeeder::class,
            DemoContentSeeder::class,
        ]);

        $this->command->info('🌱 Database seeding completed successfully!');
        $this->command->info('🔑 You can now login with any of the demo users using password: password');
    }
}
