<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallMultiTenancyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:multi-tenancy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Spatie Laravel Multi Tenancy package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏠 Installing Spatie Laravel Multi Tenancy...');

        // Check if already installed
        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'spatie/laravel-multitenancy')) {
            $this->warn('⚠️  Spatie Multi Tenancy is already installed!');
            return 0;
        }

        $this->info('📦 Installing package via Composer...');
        $this->executeCommand(['composer', 'require', 'spatie/laravel-multitenancy', '--no-interaction']);

        $this->info('📋 Publishing configuration...');
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\Multitenancy\MultitenancyServiceProvider',
            '--tag' => 'multitenancy-config'
        ]);

        $this->info('📋 Publishing migrations...');
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\Multitenancy\MultitenancyServiceProvider',
            '--tag' => 'multitenancy-migrations'
        ]);

        $this->newLine();
        $this->info('✅ Spatie Laravel Multi Tenancy installed successfully!');
        
        $this->comment('📚 Next steps:');
        $this->line('• Review and customize config/multitenancy.php');
        $this->line('• Run php artisan migrate to create tenant tables');
        $this->line('• Create your first tenant using the Tenant model');
        $this->line('• Configure your tenant-aware models');
        
        $this->newLine();
        $this->comment('📖 Documentation: https://spatie.be/docs/laravel-multitenancy');

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
