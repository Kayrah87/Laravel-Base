<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\LaravelSettings\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a basic settings class example
        if (!class_exists('App\Settings\GeneralSettings')) {
            $this->createGeneralSettingsClass();
        }

        // You can add specific settings here when you have Settings classes defined
        $this->command->info('Settings seeder completed. Create Settings classes to populate default values.');
        $this->command->comment('Example: php artisan make:setting GeneralSettings');
    }

    /**
     * Create an example settings class.
     */
    private function createGeneralSettingsClass(): void
    {
        $settingsPath = app_path('Settings');
        if (!is_dir($settingsPath)) {
            mkdir($settingsPath, 0755, true);
        }

        $settingsClass = <<<PHP
<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string \$site_name;
    public string \$site_description;
    public string \$admin_email;
    public bool \$maintenance_mode;
    public int \$items_per_page;

    public static function group(): string
    {
        return 'general';
    }

    public static function defaultValues(): array
    {
        return [
            'site_name' => 'Laravel Base',
            'site_description' => 'A Laravel base template with modern packages',
            'admin_email' => 'admin@example.com',
            'maintenance_mode' => false,
            'items_per_page' => 15,
        ];
    }
}
PHP;

        file_put_contents($settingsPath . '/GeneralSettings.php', $settingsClass);
        $this->command->info('Created example GeneralSettings class at app/Settings/GeneralSettings.php');
    }
}
