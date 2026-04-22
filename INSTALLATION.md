# FlowTask Installation Guide

FlowTask can be installed on any device using a simple terminal command. Choose one of the methods below:

## Method 1: Global Command (Recommended - Linux/Mac)

### Setup Global Command

```bash
curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/setup-global.sh | bash
```

### Install FlowTask

```bash
flowtask install --anas
```

This will:
- Check prerequisites (Docker, Docker Compose, Git)
- Clone the FlowTask repository
- Set up environment configuration
- Build and start Docker containers
- Run database migrations and seeders
- Generate application key
- Clear cache

## Method 2: Shell Script Installation (Linux/Mac)

### Quick Install

```bash
curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/install.sh | bash
```

Or using wget:

```bash
wget -qO- https://raw.githubusercontent.com/anass755/flowtask/main/install.sh | bash
```

### What it does:
- Checks for Docker and Docker Compose
- Installs Docker if not present (Linux only)
- Clones the FlowTask repository
- Sets up environment configuration
- Builds and starts Docker containers
- Runs database migrations and seeders
- Generates application key
- Clears cache

### Manual Install

```bash
# Download the script
curl -O https://raw.githubusercontent.com/anass755/flowtask/main/install.sh

# Make it executable
chmod +x install.sh

# Run it
./install.sh
```

## Method 2: NPM Package Installation (Cross-Platform)

### Install globally

```bash
npm install -g flowtask-app
```

### Install FlowTask

```bash
flowtask-app install
```

### Other commands

```bash
# Start containers
flowtask-app start

# Stop containers
flowtask-app stop

# View logs
flowtask-app logs

# Update to latest version
flowtask-app update
```

## Method 3: Manual Installation

### Prerequisites

- Docker
- Docker Compose
- Git
- Node.js (for development)

### Steps

```bash
# Clone the repository
git clone https://github.com/anass755/flowtask.git flowtask-app
cd flowtask-app

# Copy environment file
cp .env.example .env

# Build and start containers
docker-compose build
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate --force

# Run seeders
docker-compose exec app php artisan db:seed --force

# Generate application key
docker-compose exec app php artisan key:generate

# Clear cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

## Access FlowTask

After installation, access FlowTask at:

- **Application**: http://localhost:8080
- **Admin Login**: http://localhost:8080/admin/login
- **Staff Login**: http://localhost:8080/staff/login

## Default Credentials

- **Superadmin**: superadmin@example.com / superadmin@123
- **Staff**: staff@example.com / staff@1234

## Useful Commands

```bash
# Stop containers
docker-compose down

# Start containers
docker-compose up -d

# View logs
docker-compose logs -f

# Run migrations
docker-compose exec app php artisan migrate

# Access application container
docker-compose exec app bash

# Access database container
docker-compose exec mysql bash
```

## Troubleshooting

### Docker not running

```bash
# Start Docker daemon
sudo systemctl start docker  # Linux
# Or start Docker Desktop (Mac/Windows)
```

### Port already in use

Edit `.env` file and change `APP_PORT` to a different port.

### Permission denied

```bash
# Add user to docker group (Linux)
sudo usermod -aG docker $USER
# Log out and log back in
```

### Containers not starting

```bash
# Check logs
docker-compose logs

# Rebuild containers
docker-compose down
docker-compose build
docker-compose up -d
```

## Support

For issues and questions, please visit:
- GitHub: https://github.com/anass755/flowtask/issues
- Documentation: https://github.com/anass755/flowtask/wiki

## License

MIT License - see LICENSE file for details
