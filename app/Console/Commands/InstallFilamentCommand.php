<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallFilamentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:filament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Filament v4 admin panel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎛️  Installing Filament v4...');

        // Check if already installed
        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'filament/filament')) {
            $this->warn('⚠️  Filament is already installed!');
            return 0;
        }

        $this->info('📦 Installing Filament Panel Builder via Composer...');
        $this->executeCommand(['composer', 'require', 'filament/filament', '--no-interaction']);

        $this->info('🎨 Installing Filament...');
        $this->call('filament:install', [
            '--panels' => true
        ]);

        $this->newLine();
        $this->info('✅ Filament v4 installed successfully!');
        
        $this->comment('📚 Next steps:');
        $this->line('• Create an admin user: php artisan make:filament-user');
        $this->line('• Create resources: php artisan make:filament-resource ModelName');
        $this->line('• Create pages: php artisan make:filament-page PageName');
        $this->line('• Create widgets: php artisan make:filament-widget WidgetName');
        $this->line('• Visit /admin to access the admin panel');
        
        $this->newLine();
        $this->comment('📖 Documentation: https://filamentphp.com/docs');

        return 0;
    }

    /**
     * Run a shell command.
     */
    protected function executeCommand(array $command): void
    {
        $process = new Process($command, base_path());
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('❌ Command failed: ' . implode(' ', $command));
            $this->line($process->getErrorOutput());
        }
    }
}
