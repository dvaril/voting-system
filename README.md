# visitor-voting-system

## Installation

### Initial Setup
If this is your first time working with Laravel and you don't have PHP and Composer installed on your local machine, the following commands will install PHP, Composer, and the Laravel installer
#### Windows
```bash
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```
#### Linux
```bash
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
```
> [!IMPORTANT]\
> These commands should be executed only on **initial setup** on your local machine. 
> Don't run them if you’ve already executed these commands before. 

### Setup

#### 1. Install Composer Dependencies
```bash
composer install
```

#### 2. Build Frontend Assets
```bash
npm run build
```

#### 3. Create Environment Configuration File
```bash
cp .env.example .env
```
This copies the example config to .env. Changes in .env directly **affect** the app’s behavior.

#### 4. Generate Application Key
```bash
php artisan key:generate
```

#### 5. Migrate & Seed Database
```bash
php artisan migrate --seed
```

#### 6. Start the Development Server
```bash
php artisan serve
```
**Your application will be accessible at http://localhost:8000**

## Troubleshooting

If you encounter any problems in development, be sure to run these command before complaining.
```bash
php artisan cache:clear
php artisan filament:clear-cached-components
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Optimization
If your local development environment suffers from speed issues, consider caching. 
```bash
php artisan cache
php artisan filament:cache-components
php artisan icons:cache # This really helps
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> [!IMPORTANT]\
> After making changes to configuration files, routes, views etc., you’ll need to re-cache for updates to take effect


## Testing
Before any new feature, be sure to create and run tests! 
```bash
php artisan test
```

## License

This project is licensed under the [MIT License](LICENSE).  
Feel free to use, modify, and distribute it as per the license terms.
