# Laravel-Base
Laravel 12 Template Repository for Quick Initialization

This repository provides a comprehensive Laravel 12 base template with modern packages and tooling pre-configured for rapid application development.

## Included Packages

### Core Packages
- Laravel 12 Framework
- Spatie Settings
- Spatie Permissions  
- Spatie Media Library
- Spatie User Logs
- Livewire 3 with VOLT
- Fluxui 2
- Tailwind 4
- PEST Testing Framework

### Optional Packages (via Console Commands)
- Spatie Multi Tenancy
- Filament v4
- Cypress Testing
- Laravel-shift Blueprint
- Socialite
- Cashier
- Stripe
- Telescope
- Horizon
- Octane

## Installation

1. Clone this repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your environment
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan db:seed` to populate test data

## Optional Package Installation

Use the following artisan commands to install additional packages:

```bash
php artisan install:multi-tenancy
php artisan install:filament
php artisan install:cypress
php artisan install:blueprint
php artisan install:socialite
php artisan install:cashier
php artisan install:stripe
php artisan install:telescope
php artisan install:horizon
php artisan install:octane
```

## Blueprint Integration

Use the interactive Blueprint script to generate models, controllers, and resources:

```bash
php artisan blueprint:interactive
```

This will walk you through creating models with relationships, controllers, factories, Livewire components, and Filament resources.

## Test Data

The repository includes comprehensive seeders for all base models. Run:

```bash
php artisan db:seed
```

To populate your database with test data for development.
