# FlowTask CLI Installer

A command-line tool to install FlowTask with a single command. Automatically sets up Docker, clones the repository, and configures everything needed to run FlowTask.

## Installation

### Install globally via npm

```bash
npm install -g flowtask-app
```

### Install from source

```bash
cd cli-installer
npm install
npm link
```

## Usage

### Install FlowTask

```bash
flowtask-app install
```

This will:
- Check prerequisites (Node.js, Git, Docker, Docker Compose)
- Clone the FlowTask repository
- Set up environment configuration
- Build Docker containers
- Start the application
- Run database migrations and seeders
- Generate application key
- Clear cache

### Other commands

```bash
# Start FlowTask containers
flowtask-app start

# Stop FlowTask containers
flowtask-app stop

# View container logs
flowtask-app logs

# Update FlowTask to latest version
flowtask-app update
```

## Requirements

- Node.js >= 14.0.0
- Git
- Docker
- Docker Compose

## Default Credentials

After installation, you can access FlowTask with:

- **Superadmin**: superadmin@example.com / superadmin@123
- **Staff**: staff@example.com / staff@1234

## Access URLs

- Application: http://localhost:8080
- Admin Login: http://localhost:8080/admin/login
- Staff Login: http://localhost:8080/staff/login

## Development

To publish to npm:

1. Update version in package.json
2. Run `npm publish`

## License

MIT

## Author

Anas
