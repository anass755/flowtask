# Flowtask Laravel Application with Docker

This is a Laravel 12 application configured to run with Docker, including PHP, Nginx, MySQL, and phpMyAdmin.

## Services

- **PHP 8.3-FPM**: Application server
- **Nginx**: Web server (Port 8080)
- **MySQL 8.0**: Database server (Port 3306)
- **phpMyAdmin**: Database management interface (Port 8081)

## Quick Start

1. **Build and start the containers:**
   ```bash
   docker-compose up -d --build
   ```

2. **Install Laravel dependencies:**
   ```bash
   docker-compose exec app composer install
   ```

3. **Generate application key:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

4. **Run database migrations:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

5. **Clear caches:**
   ```bash
   docker-compose exec app php artisan cache:clear
   docker-compose exec app php artisan config:clear
   docker-compose exec app php artisan route:clear
   ```

## Access Points

- **Laravel Application**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
  - Server: mysql
  - Username: root
  - Password: root

## Database Configuration

The application is configured to use MySQL with these credentials:
- Database: `flowtask`
- Host: `mysql`
- Port: `3306`
- Username: `flowtask_user`
- Password: `password`

## Useful Commands

### Docker Compose
```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up -d --build
```

### Laravel Artisan
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Create new controller
docker-compose exec app php artisan make:controller YourController

# Install new package
docker-compose exec app composer require package-name

# Run tests
docker-compose exec app php artisan test
```

### Composer
```bash
# Install dependencies
docker-compose exec app composer install

# Update dependencies
docker-compose exec app composer update

# Add new package
docker-compose exec app composer require package-name
```

### NPM (if needed)
```bash
# Install node modules
docker-compose exec app npm install

# Run build
docker-compose exec app npm run build

# Run dev
docker-compose exec app npm run dev
```

## File Permissions

If you encounter permission issues, run:
```bash
sudo chown -R $USER:$USER storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## Development Workflow

1. Make changes to your code
2. The changes are automatically reflected in the container due to volume mounting
3. If you change composer dependencies, run `docker-compose exec app composer install`
4. If you change configuration, clear caches with the commands above

## Troubleshooting

### Container won't start
- Check if ports 8080, 8081, and 3306 are available
- Run `docker-compose logs` to see error messages

### Database connection issues
- Ensure MySQL container is running: `docker-compose ps`
- Check database credentials in `.env` file
- Try restarting the containers: `docker-compose restart`

### Permission issues
- Ensure storage and bootstrap/cache directories are writable
- Run the file permissions command above
