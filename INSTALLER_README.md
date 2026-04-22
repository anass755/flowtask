# FlowTask Auto-Installer by Anas

A comprehensive installation system that allows users to install FlowTask on any device with a single terminal command.

## 🚀 Quick Start

### Option 1: Shell Script (Linux/Mac)

```bash
curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/install.sh | bash
```

### Option 2: NPM Package (Cross-Platform)

```bash
npm install -g flowtask-app
flowtask-app install
```

## 📦 What Gets Installed

The installer automatically sets up:

- ✅ Docker & Docker Compose (if not present)
- ✅ Git (if not present)
- ✅ FlowTask application
- ✅ MySQL database
- ✅ Redis cache
- ✅ All dependencies via Docker
- ✅ Database migrations
- ✅ Database seeders
- ✅ Environment configuration
- ✅ Application key

## 🎯 Features

- **One-command installation** - No manual setup required
- **Cross-platform support** - Works on Linux, Mac, and Windows
- **Automatic dependency installation** - Installs Docker, Git if needed
- **Interactive configuration** - Choose your port and settings
- **Progress indicators** - See what's happening during installation
- **Error handling** - Clear error messages and troubleshooting tips
- **Docker-based** - Clean, isolated environment
- **Production-ready** - Optimized configuration out of the box

## 📋 Prerequisites

The installer will check for:
- Node.js >= 14.0.0 (for NPM method)
- Git
- Docker
- Docker Compose

If any are missing, the installer will guide you through installation.

## 🔧 Installation Methods

### Method 1: Shell Script (Recommended for Linux/Mac)

**Quick Install:**
```bash
curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/install.sh | bash
```

**Manual Download:**
```bash
curl -O https://raw.githubusercontent.com/anass755/flowtask/main/install.sh
chmod +x install.sh
./install.sh
```

### Method 2: NPM Package (Cross-Platform)

**Install globally:**
```bash
npm install -g flowtask-app
```

**Install FlowTask:**
```bash
flowtask-app install
```

**Additional commands:**
```bash
flowtask-app start    # Start containers
flowtask-app stop     # Stop containers
flowtask-app logs     # View logs
flowtask-app update   # Update to latest version
```

### Method 3: Manual Installation

See [INSTALLATION.md](INSTALLATION.md) for detailed manual installation steps.

## 🌐 Access After Installation

- **Application**: http://localhost:8080
- **Admin Login**: http://localhost:8080/admin/login
- **Staff Login**: http://localhost:8080/staff/login

## 🔑 Default Credentials

- **Superadmin**: superadmin@example.com / superadmin@123
- **Staff**: staff@example.com / staff@1234

## 📁 Installation Directory

By default, FlowTask is installed in:
- **Linux/Mac**: `~/flowtask-app`
- **Windows**: `C:\Users\YourUsername\flowtask-app`

## 🛠️ Post-Installation Commands

```bash
# Navigate to installation directory
cd ~/flowtask-app

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

# Restart containers
docker-compose restart
```

## 🔍 Troubleshooting

### Docker not running
```bash
# Linux
sudo systemctl start docker

# Mac/Windows
# Start Docker Desktop
```

### Port already in use
Edit `.env` file and change `APP_PORT` to a different port.

### Permission denied (Linux)
```bash
sudo usermod -aG docker $USER
# Log out and log back in
```

### Containers not starting
```bash
docker-compose logs
docker-compose down
docker-compose build
docker-compose up -d
```

## 📚 Documentation

- [Installation Guide](INSTALLATION.md) - Detailed installation instructions
- [CLI Installer README](cli-installer/README.md) - NPM package documentation
- [Main Project README](README.md) - FlowTask features and usage

## 🤝 Contributing

To contribute to the installer:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📝 Publishing the NPM Package

To publish the CLI installer to npm:

```bash
cd cli-installer
npm login
npm publish
```

## 📄 License

MIT License - see LICENSE file for details

## 👨‍💻 Author

**Anas**

## 🙏 Acknowledgments

- Docker for containerization
- Laravel for the framework
- The open-source community

## 📞 Support

For issues and questions:
- GitHub Issues: https://github.com/anass755/flowtask/issues
- Documentation: https://github.com/anass755/flowtask/wiki
