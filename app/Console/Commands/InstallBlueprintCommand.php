<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallBlueprintCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:blueprint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Laravel-shift Blueprint for rapid development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📐 Installing Laravel-shift Blueprint...');

        // Check if already installed
        $composerFile = file_get_contents(base_path('composer.json'));
        if (str_contains($composerFile, 'laravel-shift/blueprint')) {
            $this->warn('⚠️  Blueprint is already installed!');
            return 0;
        }

        $this->info('📦 Installing Blueprint via Composer...');
        $this->executeCommand(['composer', 'require', '--dev', 'laravel-shift/blueprint']);

        $this->info('📋 Publishing Blueprint stubs...');
        $this->call('vendor:publish', [
            '--tag' => 'blueprint-stubs'
        ]);

        $this->info('📋 Publishing Blueprint configuration...');
        $this->call('vendor:publish', [
            '--tag' => 'blueprint-config'
        ]);

        // Create example draft file
        $this->info('📝 Creating example draft file...');
        $exampleDraft = <<<YAML
models:
  Post:
    title: string:400
    content: longtext
    published_at: nullable timestamp
    relationships:
      belongsTo: User
    
  Comment:
    content: text
    relationships:
      belongsTo: Post, User

controllers:
  Post:
    index:
      query: all
      render: post.index with:posts
    show:
      render: post.show with:post
    store:
      validate: title, content
      save: post
      redirect: post.index

seeders: Post, Comment
YAML;

        if (!file_exists(base_path('draft.yaml'))) {
            file_put_contents(base_path('draft.yaml'), $exampleDraft);
        }

        $this->newLine();
        $this->info('✅ Blueprint installed successfully!');
        
        $this->comment('📚 Next steps:');
        $this->line('• Create or edit draft.yaml to define your models');
        $this->line('• Run php artisan blueprint:build to generate code');
        $this->line('• Use php artisan blueprint:interactive for guided creation');
        $this->line('• Check out the example draft.yaml file created');
        
        $this->newLine();
        $this->comment('📖 Documentation: https://blueprint.laravelshift.com');

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
