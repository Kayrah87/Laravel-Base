<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Base</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style>
            /* Basic styling for now */
            body { font-family: 'Figtree', sans-serif; margin: 0; padding: 0; background: #f9fafb; }
            .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
            .header { text-align: center; margin-bottom: 3rem; }
            .title { font-size: 3rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem; }
            .subtitle { font-size: 1.25rem; color: #6b7280; }
            .card { background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem; margin-bottom: 2rem; }
            .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
            .feature { padding: 1rem; border-left: 4px solid #3b82f6; }
            .feature h3 { color: #1f2937; margin: 0 0 0.5rem 0; }
            .feature p { color: #6b7280; margin: 0; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">Laravel Base Template</h1>
                <p class="subtitle">A comprehensive Laravel starter template with modern packages and console commands</p>
            </div>

            <div class="card">
                <h2>🎉 Installation Successful!</h2>
                <p>Your Laravel Base template has been successfully set up with the following core components:</p>
                
                <div class="feature-grid">
                    <div class="feature">
                        <h3>Laravel 11</h3>
                        <p>Latest stable Laravel framework with all modern features</p>
                    </div>
                    <div class="feature">
                        <h3>PEST Testing</h3>
                        <p>Modern PHP testing framework included and configured</p>
                    </div>
                    <div class="feature">
                        <h3>Laravel Sanctum</h3>
                        <p>API authentication system ready to use</p>
                    </div>
                    <div class="feature">
                        <h3>Console Commands</h3>
                        <p>Custom artisan commands for package installation and setup</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>🚀 Next Steps</h2>
                <p>Use the following artisan commands to install additional packages:</p>
                <ul>
                    <li><code>php artisan install:spatie-packages</code> - Install all Spatie packages</li>
                    <li><code>php artisan install:livewire</code> - Install Livewire 3 with VOLT</li>
                    <li><code>php artisan install:frontend</code> - Install Tailwind 4 and frontend assets</li>
                    <li><code>php artisan install:optional</code> - Interactive installer for optional packages</li>
                    <li><code>php artisan blueprint:walkthrough</code> - Interactive model generator</li>
                </ul>
            </div>
        </div>
    </body>
</html>