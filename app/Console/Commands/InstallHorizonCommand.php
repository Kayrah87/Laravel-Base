<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallHorizonCommand extends Command
{
    protected $signature = 'install:horizon';
    protected $description = 'Install and configure Laravel Horizon for queue monitoring';

    public function handle()
    {
        $this->info('⚡ Installing Laravel Horizon...');

        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'laravel/horizon')) {
            $this->warn('⚠️  Laravel Horizon is already installed!');
            return 0;
        }

        $this->executeCommand(['composer', 'require', 'laravel/horizon', '--no-interaction']);
        $this->call('horizon:install');
        
        $this->info('✅ Horizon installed! Configure Redis and visit /horizon.');
        
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
