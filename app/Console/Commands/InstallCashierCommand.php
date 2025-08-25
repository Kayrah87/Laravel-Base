<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallCashierCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:cashier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Laravel Cashier for subscription billing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('💳 Installing Laravel Cashier...');

        // Check if already installed
        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'laravel/cashier')) {
            $this->warn('⚠️  Laravel Cashier is already installed!');
            return 0;
        }

        $this->info('📦 Installing Cashier via Composer...');
        $this->executeCommand(['composer', 'require', 'laravel/cashier', '--no-interaction']);

        $this->info('📋 Publishing Cashier migrations...');
        $this->call('vendor:publish', [
            '--tag' => 'cashier-migrations'
        ]);

        $this->info('📋 Publishing Cashier configuration...');
        $this->call('vendor:publish', [
            '--tag' => 'cashier-config'
        ]);

        $this->newLine();
        $this->info('✅ Laravel Cashier installed successfully!');
        
        $this->comment('📚 Next steps:');
        $this->line('• Add STRIPE_KEY and STRIPE_SECRET to your .env file');
        $this->line('• Run php artisan migrate to create subscription tables');
        $this->line('• Add Billable trait to your User model');
        $this->line('• Configure webhooks in your Stripe dashboard');
        $this->line('• Review config/cashier.php for customization');
        
        $this->newLine();
        $this->comment('📖 Documentation: https://laravel.com/docs/billing');

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
