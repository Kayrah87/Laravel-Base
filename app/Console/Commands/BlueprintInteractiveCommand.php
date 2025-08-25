<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BlueprintInteractiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blueprint:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactive Blueprint model and resource generation wizard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎯 Blueprint Interactive Wizard');
        $this->info('This wizard will help you create models, controllers, and resources quickly.');
        $this->newLine();

        // Check if Blueprint is installed
        $composerFile = file_get_contents(base_path('composer.json'));
        if (!str_contains($composerFile, 'laravel-shift/blueprint')) {
            $this->error('❌ Blueprint is not installed! Run: php artisan install:blueprint');
            return 1;
        }

        $models = [];
        $createMore = true;

        while ($createMore) {
            $modelName = $this->ask('📝 Enter model name (e.g., Post, Comment, Category)');
            
            if (empty($modelName)) {
                $this->error('Model name cannot be empty!');
                continue;
            }

            $modelName = Str::studly($modelName);
            
            $this->info("🔧 Configuring model: {$modelName}");
            
            $fields = $this->collectFields();
            $relationships = $this->collectRelationships();
            $generateOptions = $this->collectGenerationOptions();

            $models[$modelName] = [
                'fields' => $fields,
                'relationships' => $relationships,
                'options' => $generateOptions
            ];

            $this->info("✅ Model {$modelName} configured successfully!");
            $this->newLine();

            $createMore = $this->confirm('➕ Do you want to add another model?', false);
        }

        // Generate Blueprint YAML
        $this->info('📄 Generating Blueprint configuration...');
        $yaml = $this->generateBlueprintYaml($models);
        
        // Save to draft.yaml
        file_put_contents(base_path('draft.yaml'), $yaml);
        $this->info('💾 Blueprint configuration saved to draft.yaml');

        // Ask if user wants to generate now
        if ($this->confirm('🚀 Do you want to generate the code now?', true)) {
            $this->call('blueprint:build');
        }

        $this->newLine();
        $this->info('✨ Blueprint Interactive Wizard completed!');
        $this->comment('📝 You can edit draft.yaml and run "php artisan blueprint:build" to regenerate.');

        return 0;
    }

    /**
     * Collect fields for the model.
     */
    protected function collectFields(): array
    {
        $fields = [];
        $this->info('📋 Add fields to your model (press enter with empty field name to finish):');

        while (true) {
            $fieldName = $this->ask('Field name');
            
            if (empty($fieldName)) {
                break;
            }

            $fieldType = $this->choice(
                'Field type',
                [
                    'string',
                    'text',
                    'longtext',
                    'integer',
                    'bigInteger',
                    'boolean',
                    'date',
                    'datetime',
                    'timestamp',
                    'decimal',
                    'json',
                    'enum'
                ],
                0
            );

            $nullable = $this->confirm('Make field nullable?', false);
            $unique = $this->confirm('Make field unique?', false);

            $fieldDefinition = $fieldType;
            
            if ($fieldType === 'string') {
                $length = $this->ask('String length (default: 255)', '255');
                if ($length !== '255') {
                    $fieldDefinition .= ':' . $length;
                }
            }
            
            if ($fieldType === 'decimal') {
                $precision = $this->ask('Precision (default: 8,2)', '8,2');
                if ($precision !== '8,2') {
                    $fieldDefinition .= ':' . $precision;
                }
            }

            if ($fieldType === 'enum') {
                $values = $this->ask('Enum values (comma separated)', 'active,inactive');
                $fieldDefinition .= ':' . $values;
            }

            if ($nullable) {
                $fieldDefinition = 'nullable ' . $fieldDefinition;
            }

            if ($unique) {
                $fieldDefinition = 'unique ' . $fieldDefinition;
            }

            $fields[$fieldName] = $fieldDefinition;
        }

        return $fields;
    }

    /**
     * Collect relationships for the model.
     */
    protected function collectRelationships(): array
    {
        $relationships = [];
        
        if (!$this->confirm('➡️  Do you want to add relationships?', false)) {
            return $relationships;
        }

        $this->info('🔗 Add relationships (press enter with empty model name to finish):');

        while (true) {
            $relationType = $this->choice(
                'Relationship type',
                ['belongsTo', 'hasMany', 'hasOne', 'belongsToMany', 'skip'],
                0
            );

            if ($relationType === 'skip') {
                break;
            }

            $relatedModel = $this->ask('Related model name');
            
            if (empty($relatedModel)) {
                break;
            }

            if (!isset($relationships[$relationType])) {
                $relationships[$relationType] = [];
            }

            $relationships[$relationType][] = $relatedModel;
        }

        return $relationships;
    }

    /**
     * Collect generation options.
     */
    protected function collectGenerationOptions(): array
    {
        $options = [];

        $this->info('🛠️  What do you want to generate for this model?');

        if ($this->confirm('Generate controller?', true)) {
            $options['controller'] = true;
            
            if ($this->confirm('Generate controller with CRUD methods?', true)) {
                $options['controller_crud'] = true;
            }
        }

        if ($this->confirm('Generate factory?', true)) {
            $options['factory'] = true;
        }

        if ($this->confirm('Generate seeder?', true)) {
            $options['seeder'] = true;
        }

        if ($this->confirm('Generate Livewire component?', false)) {
            $options['livewire'] = true;
        }

        if ($this->confirm('Generate Filament resource?', false)) {
            $options['filament'] = true;
        }

        return $options;
    }

    /**
     * Generate Blueprint YAML configuration.
     */
    protected function generateBlueprintYaml(array $models): string
    {
        $yaml = "# Generated by Blueprint Interactive Wizard\n\n";

        // Models section
        $yaml .= "models:\n";
        foreach ($models as $modelName => $config) {
            $yaml .= "  {$modelName}:\n";
            
            // Fields
            foreach ($config['fields'] as $fieldName => $fieldType) {
                $yaml .= "    {$fieldName}: {$fieldType}\n";
            }
            
            // Relationships
            if (!empty($config['relationships'])) {
                $yaml .= "    relationships:\n";
                foreach ($config['relationships'] as $type => $relations) {
                    $yaml .= "      {$type}: " . implode(', ', $relations) . "\n";
                }
            }
            
            $yaml .= "\n";
        }

        // Controllers section
        $controllersToGenerate = array_filter($models, fn($config) => $config['options']['controller'] ?? false);
        if (!empty($controllersToGenerate)) {
            $yaml .= "controllers:\n";
            foreach ($controllersToGenerate as $modelName => $config) {
                if ($config['options']['controller_crud'] ?? false) {
                    $yaml .= "  {$modelName}:\n";
                    $yaml .= "    index:\n";
                    $yaml .= "      query: all\n";
                    $yaml .= "      render: " . strtolower($modelName) . ".index with:" . strtolower($modelName) . "s\n";
                    $yaml .= "    show:\n";
                    $yaml .= "      render: " . strtolower($modelName) . ".show with:" . strtolower($modelName) . "\n";
                    $yaml .= "    store:\n";
                    $yaml .= "      save: " . strtolower($modelName) . "\n";
                    $yaml .= "      redirect: " . strtolower($modelName) . ".index\n\n";
                }
            }
        }

        // Seeders section
        $seedersToGenerate = array_filter($models, fn($config) => $config['options']['seeder'] ?? false);
        if (!empty($seedersToGenerate)) {
            $yaml .= "seeders: " . implode(', ', array_keys($seedersToGenerate)) . "\n";
        }

        return $yaml;
    }
}
