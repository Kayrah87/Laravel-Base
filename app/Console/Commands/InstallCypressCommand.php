<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallCypressCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:cypress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Cypress testing framework';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Installing Cypress Testing Framework...');

        // Check if already installed
        $packageFile = file_get_contents(base_path('package.json'));
        if (str_contains($packageFile, 'cypress')) {
            $this->warn('⚠️  Cypress is already installed!');
            return 0;
        }

        $this->info('📦 Installing Cypress via NPM...');
        $this->executeCommand(['npm', 'install', '--save-dev', 'cypress', '@cypress/laravel']);

        $this->info('⚙️  Initializing Cypress...');
        $this->executeCommand(['npx', 'cypress', 'install']);

        // Create cypress.config.js
        $this->info('📋 Creating Cypress configuration...');
        $cypressConfig = <<<JS
const { defineConfig } = require('cypress')

module.exports = defineConfig({
  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
    baseUrl: 'http://localhost:8000',
    specPattern: 'cypress/e2e/**/*.cy.{js,jsx,ts,tsx}',
    supportFile: 'cypress/support/e2e.js'
  },
  component: {
    devServer: {
      framework: 'vue',
      bundler: 'vite',
    },
  },
})
JS;

        file_put_contents(base_path('cypress.config.js'), $cypressConfig);

        // Update package.json scripts
        $this->info('📝 Updating package.json scripts...');
        $packageJson = json_decode(file_get_contents(base_path('package.json')), true);
        $packageJson['scripts']['cypress:open'] = 'cypress open';
        $packageJson['scripts']['cypress:run'] = 'cypress run';
        file_put_contents(base_path('package.json'), json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->newLine();
        $this->info('✅ Cypress installed successfully!');
        
        $this->comment('📚 Next steps:');
        $this->line('• Run npm run cypress:open to open Cypress Test Runner');
        $this->line('• Run npm run cypress:run to run tests headlessly');
        $this->line('• Create tests in cypress/e2e/ directory');
        $this->line('• Start your Laravel server: php artisan serve');
        
        $this->newLine();
        $this->comment('📖 Documentation: https://docs.cypress.io');

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
