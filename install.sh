#!/bin/bash

# FlowTask Auto-Installer
# Usage: curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/install.sh | bash
# Or: wget -qO- https://raw.githubusercontent.com/anass755/flowtask/main/install.sh | bash

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Project configuration
PROJECT_NAME="flowtask-app"
REPO_URL="https://github.com/anass755/flowtask.git"
INSTALL_DIR="$HOME/flowtask-app"

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  FlowTask Auto-Installer${NC}"
echo -e "${BLUE}  by Anas${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Function to print colored output
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# Check if running as root
if [ "$EUID" -eq 0 ]; then 
    print_warning "Running as root. This is not recommended."
fi

# Detect OS
OS="$(uname -s)"
case "${OS}" in
    Linux*)     MACHINE=Linux;;
    Darwin*)    MACHINE=Mac;;
    CYGWIN*)    MACHINE=Cygwin;;
    MINGW*)     MACHINE=MinGw;;
    *)          MACHINE="UNKNOWN:${OS}"
esac

print_info "Detected OS: $MACHINE"

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    print_warning "Docker is not installed. Installing Docker..."
    
    if [ "$MACHINE" = "Linux" ]; then
        # Install Docker on Linux
        curl -fsSL https://get.docker.com -o get-docker.sh
        sudo sh get-docker.sh
        rm get-docker.sh
        sudo usermod -aG docker $USER
        print_success "Docker installed successfully"
        print_warning "Please log out and log back in to use Docker without sudo"
    elif [ "$MACHINE" = "Mac" ]; then
        # Install Docker Desktop on Mac
        print_info "Please install Docker Desktop for Mac from: https://www.docker.com/products/docker-desktop"
        print_info "After installation, run this script again."
        exit 1
    else
        print_error "Unsupported OS for automatic Docker installation"
        exit 1
    fi
else
    print_success "Docker is already installed"
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    print_warning "Docker Compose is not installed. Installing Docker Compose..."
    
    if [ "$MACHINE" = "Linux" ]; then
        sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
        sudo chmod +x /usr/local/bin/docker-compose
        print_success "Docker Compose installed successfully"
    elif [ "$MACHINE" = "Mac" ]; then
        print_info "Docker Compose should be included with Docker Desktop for Mac"
    fi
else
    print_success "Docker Compose is already installed"
fi

# Check if Git is installed
if ! command -v git &> /dev/null; then
    print_warning "Git is not installed. Installing Git..."
    
    if [ "$MACHINE" = "Linux" ]; then
        sudo apt-get update
        sudo apt-get install -y git
    elif [ "$MACHINE" = "Mac" ]; then
        if command -v brew &> /dev/null; then
            brew install git
        else
            print_info "Please install Git from: https://git-scm.com/downloads"
            exit 1
        fi
    fi
    print_success "Git installed successfully"
else
    print_success "Git is already installed"
fi

# Check if project directory already exists
if [ -d "$INSTALL_DIR" ]; then
    print_warning "Project directory already exists at $INSTALL_DIR"
    read -p "Do you want to remove it and reinstall? (y/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        rm -rf "$INSTALL_DIR"
        print_info "Removed existing directory"
    else
        print_error "Installation cancelled"
        exit 1
    fi
fi

# Clone the repository
print_info "Cloning FlowTask repository..."
git clone "$REPO_URL" "$INSTALL_DIR"
cd "$INSTALL_DIR"
print_success "Repository cloned successfully"

# Copy environment file
if [ -f ".env.example" ]; then
    cp .env.example .env
    print_success "Environment file created"
fi

# Build and start Docker containers
print_info "Building Docker containers..."
docker-compose build
print_success "Docker containers built successfully"

print_info "Starting Docker containers..."
docker-compose up -d
print_success "Docker containers started successfully"

# Wait for containers to be ready
print_info "Waiting for containers to be ready..."
sleep 10

# Run migrations
print_info "Running database migrations..."
docker-compose exec app php artisan migrate --force
print_success "Migrations completed successfully"

# Run seeders
print_info "Running database seeders..."
docker-compose exec app php artisan db:seed --force
print_success "Seeders completed successfully"

# Generate application key if not set
print_info "Setting up application key..."
docker-compose exec app php artisan key:generate
print_success "Application key generated"

# Clear cache
print_info "Clearing application cache..."
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
print_success "Cache cleared successfully"

# Get container information
APP_PORT=$(grep -E "^APP_PORT=" .env | cut -d '=' -f2)
if [ -z "$APP_PORT" ]; then
    APP_PORT=8080
fi

# Print installation summary
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Installation Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
print_info "FlowTask has been successfully installed!"
echo ""
echo -e "${BLUE}Access URLs:${NC}"
echo -e "  Application: ${GREEN}http://localhost:$APP_PORT${NC}"
echo -e "  Admin Login:  ${GREEN}http://localhost:$APP_PORT/admin/login${NC}"
echo -e "  Staff Login:  ${GREEN}http://localhost:$APP_PORT/staff/login${NC}"
echo ""
echo -e "${BLUE}Default Credentials:${NC}"
echo -e "  Superadmin: ${YELLOW}superadmin@example.com${NC} / ${YELLOW}superadmin@123${NC}"
echo -e "  Staff:      ${YELLOW}staff@example.com${NC} / ${YELLOW}staff@1234${NC}"
echo ""
echo -e "${BLUE}Useful Commands:${NC}"
echo -e "  Stop containers:    ${YELLOW}cd $INSTALL_DIR && docker-compose down${NC}"
echo -e "  Start containers:   ${YELLOW}cd $INSTALL_DIR && docker-compose up -d${NC}"
echo -e "  View logs:          ${YELLOW}cd $INSTALL_DIR && docker-compose logs -f${NC}"
echo -e "  Run migrations:     ${YELLOW}cd $INSTALL_DIR && docker-compose exec app php artisan migrate${NC}"
echo ""
print_success "Installation completed successfully!"
echo ""
