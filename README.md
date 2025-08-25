# Laravel Base Template

A comprehensive Laravel starter template with modern packages, interactive console commands, and automated setup tools. Built with Laravel 11, this template provides everything you need to quickly bootstrap a modern web application.

## ✨ Features

### Core Packages (Included)
- **Laravel 11** - Latest stable Laravel framework
- **PEST** - Modern PHP testing framework
- **Laravel Sanctum** - API authentication system

### Available via Console Commands
- **Spatie Packages** (Settings, Permissions, Media Library, Activity Log)
- **Livewire 3 + VOLT** - Reactive components with single-file components
- **Tailwind CSS 4** - Modern utility-first CSS framework
- **Filament v4** - Beautiful admin panel
- **Laravel Blueprint** - Interactive model generator
- **Multi-tenancy, Socialite, Cashier, Telescope, Horizon, Octane** - And more!

## 🚀 Quick Start

### 1. Installation

```bash
# Clone the repository
git clone https://github.com/Kayrah87/Laravel-Base.git your-project
cd your-project

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database (SQLite by default)
touch database/database.sqlite

# Run migrations
php artisan migrate
```

### 2. Interactive Package Installation

Use the built-in console commands to install additional packages:

```bash
# Install Spatie packages (interactive)
php artisan install:spatie-packages

# Install Livewire with VOLT
php artisan install:livewire --volt

# Setup frontend with Tailwind CSS
php artisan install:frontend --tailwind4

# Interactive installer for optional packages
php artisan install:optional

# Generate test data
php artisan create:test-data --fresh
```

## 🛠️ Console Commands

### Core Package Installers

#### Spatie Packages
```bash
# Install all Spatie packages
php artisan install:spatie-packages --all

# Install specific packages
php artisan install:spatie-packages --settings --permissions --media --logs
```

#### Livewire & Frontend
```bash
# Install Livewire 3 with VOLT
php artisan install:livewire --volt

# Setup Tailwind CSS 4 and frontend assets
php artisan install:frontend --tailwind4
```

#### Optional Packages
```bash
# Interactive installer for optional packages
php artisan install:optional
```

Available optional packages:
- Spatie Multi Tenancy
- Filament Admin Panel
- Laravel Socialite
- Laravel Cashier (Stripe)
- Laravel Telescope
- Laravel Horizon
- Laravel Octane
- Laravel Blueprint

### Blueprint Model Generator

Interactive walkthrough for creating models with relationships, controllers, factories, and more:

```bash
php artisan blueprint:walkthrough
```

This command will:
- Guide you through model creation
- Generate fields and relationships
- Create controllers, factories, seeders
- Generate Livewire components
- Create Filament resources (if installed)

### Test Data Generation

Create comprehensive test data for your application:

```bash
# Create test data with default settings
php artisan create:test-data

# Fresh migration with custom user count
php artisan create:test-data --fresh --users=50
```

Generates:
- Admin user (`admin@example.com`, password: `password`)
- Manager users with appropriate roles
- Regular users with basic permissions
- Complete roles and permissions structure

## 📁 Project Structure

```
├── app/
│   ├── Console/Commands/     # Custom artisan commands
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── config/                   # Laravel configuration
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── css/                # Tailwind CSS assets
│   ├── js/                 # JavaScript assets
│   └── views/              # Blade templates
└── routes/                 # Application routes
```

## 🎨 Frontend Assets

The template includes a modern frontend setup:

### CSS (Tailwind CSS)
- Utility-first CSS framework
- Custom component classes
- Form styling utilities
- Responsive design ready

### JavaScript (Alpine.js)
- Lightweight reactivity
- No build step required for basic interactions
- Pairs perfectly with Livewire

### Build Tools (Vite)
```bash
# Development server
npm run dev

# Production build
npm run build
```

## 🔐 Authentication & Authorization

### Roles & Permissions
The template includes a complete roles and permissions system using Spatie Permission:

- **Admin**: Full system access
- **Manager**: User and content management
- **Editor**: Content management only
- **User**: Basic view permissions

### Default Users (after running `create:test-data`)
- Admin: `admin@example.com` / `password`
- Manager users with manager role
- Regular users with user role

## 🧪 Testing

The template includes PEST for modern PHP testing:

```bash
# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage
```

## 📝 Package Information

### Spatie Packages
- **Settings**: Store application settings in database
- **Permissions**: Associate users with roles and permissions
- **Media Library**: Attach files to Eloquent models
- **Activity Log**: Log user activities and changes

### Optional Packages
- **Multi Tenancy**: Build multi-tenant applications
- **Filament**: Admin panel with beautiful interface
- **Telescope**: Debug and monitor your application
- **Horizon**: Queue monitoring dashboard
- **Octane**: Supercharge application performance
- **Blueprint**: Generate code from YAML definitions

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel team for the amazing framework
- Spatie for their excellent packages
- Livewire team for reactive components
- All package maintainers and contributors

---

**Happy coding! 🚀**