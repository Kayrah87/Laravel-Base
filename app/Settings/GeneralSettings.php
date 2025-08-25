<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public string $site_description;
    public string $admin_email;
    public bool $maintenance_mode;
    public int $items_per_page;

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