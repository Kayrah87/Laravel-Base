<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallOctaneCommand extends Command
{
    protected $signature = 'install:octane';
    protected $description = 'Install and configure Laravel Octane for high performance';

    public function handle()
    {
        $this->info('🚀 Installing Laravel Octane...');

        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'laravel/octane')) {
            $this->warn('⚠️  Laravel Octane is already installed!');
            return 0;
        }

        $this->executeCommand(['composer', 'require', 'laravel/octane', '--no-interaction']);
        $this->call('octane:install');
        
        $this->info('✅ Octane installed! Use php artisan octane:start to run.');
        
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
