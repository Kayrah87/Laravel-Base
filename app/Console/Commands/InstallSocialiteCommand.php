<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallSocialiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:socialite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Laravel Socialite for social authentication';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔐 Installing Laravel Socialite...');

        // Check if already installed
        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'laravel/socialite')) {
            $this->warn('⚠️  Laravel Socialite is already installed!');
            return 0;
        }

        $this->info('📦 Installing Socialite via Composer...');
        $this->executeCommand(['composer', 'require', 'laravel/socialite', '--no-interaction']);

        // Update services config
        $this->info('⚙️  Updating services configuration...');
        $servicesConfig = base_path('config/services.php');
        $services = file_get_contents($servicesConfig);
        
        if (!str_contains($services, 'github')) {
            $socialiteServices = "
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URL'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URL'),
    ],
";
            $services = str_replace("'ses' => [", $socialiteServices . "    'ses' => [", $services);
            file_put_contents($servicesConfig, $services);
        }

        $this->newLine();
        $this->info('✅ Laravel Socialite installed successfully!');
        
        $this->comment('📚 Next steps:');
        $this->line('• Add social provider credentials to your .env file');
        $this->line('• Create routes for social authentication');
        $this->line('• Add social login buttons to your views');
        $this->line('• Update User model if needed for social login');
        
        $this->newLine();
        $this->comment('📖 Documentation: https://laravel.com/docs/socialite');

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
