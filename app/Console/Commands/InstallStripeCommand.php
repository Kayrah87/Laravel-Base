<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallStripeCommand extends Command
{
    protected $signature = 'install:stripe';
    protected $description = 'Install and configure Stripe SDK';

    public function handle()
    {
        $this->info('💰 Installing Stripe SDK...');

        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'stripe/stripe-php')) {
            $this->warn('⚠️  Stripe SDK is already installed!');
            return 0;
        }

        $this->executeCommand(['composer', 'require', 'stripe/stripe-php', '--no-interaction']);

        $this->info('✅ Stripe SDK installed successfully!');
        $this->comment('📚 Add STRIPE_KEY and STRIPE_SECRET to your .env file');
        
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
