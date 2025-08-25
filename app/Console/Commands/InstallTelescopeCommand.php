<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallTelescopeCommand extends Command
{
    protected $signature = 'install:telescope';
    protected $description = 'Install and configure Laravel Telescope for debugging';

    public function handle()
    {
        $this->info('🔭 Installing Laravel Telescope...');

        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'laravel/telescope')) {
            $this->warn('⚠️  Laravel Telescope is already installed!');
            return 0;
        }

        $this->executeCommand(['composer', 'require', 'laravel/telescope', '--no-interaction']);
        $this->call('telescope:install');
        
        $this->info('✅ Telescope installed! Visit /telescope to debug your app.');
        
        return 0;
    }

    protected function executeCommand(array $command): void
    {
        $process = new Process($command, base_path());
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('❌ Command failed: ' . implode(' ', $command));
        }
    }
}
