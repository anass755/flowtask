#!/bin/bash

# FlowTask Quick Installer
# One-command installation: curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/quick-install.sh | bash
# This script sets up the global command and installs FlowTask in one go

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

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

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  FlowTask Quick Installer${NC}"
echo -e "${BLUE}  by Anas${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

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

# Check prerequisites
print_info "Checking prerequisites..."

if ! command -v docker &> /dev/null; then
    print_error "Docker is not installed"
    print_info "Please install Docker from: https://www.docker.com/get-started"
    exit 1
fi
print_success "Docker is installed"

if ! command -v docker-compose &> /dev/null; then
    print_error "Docker Compose is not installed"
    print_info "Please install Docker Compose from: https://docs.docker.com/compose/install/"
    exit 1
fi
print_success "Docker Compose is installed"

if ! command -v git &> /dev/null; then
    print_error "Git is not installed"
    print_info "Please install Git from: https://git-scm.com/"
    exit 1
fi
print_success "Git is installed"

# Determine bin directory
if [ "$MACHINE" = "Linux" ] || [ "$MACHINE" = "Mac" ]; then
    if [ -w "/usr/local/bin" ]; then
        BIN_DIR="/usr/local/bin"
    else
        BIN_DIR="$HOME/.local/bin"
        mkdir -p "$BIN_DIR"
        # Add to PATH for this session
        export PATH="$HOME/.local/bin:$PATH"
        # Add to PATH permanently if not already there
        if [[ ":$PATH:" != *":$HOME/.local/bin:"* ]]; then
            echo 'export PATH="$HOME/.local/bin:$PATH"' >> "$HOME/.bashrc"
            echo 'export PATH="$HOME/.local/bin:$PATH"' >> "$HOME/.zshrc"
            print_info "Added $BIN_DIR to PATH in .bashrc and .zshrc"
        fi
    fi
else
    print_error "Unsupported OS"
    exit 1
fi

print_info "Installing flowtask command to: $BIN_DIR"

# Download the flowtask script
print_info "Downloading flowtask script..."
curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/flowtask -o "$BIN_DIR/flowtask"
chmod +x "$BIN_DIR/flowtask"
print_success "flowtask command installed"

# Now run the installation
echo ""
print_info "Installing FlowTask..."
echo ""

# Call the flowtask install command
"$BIN_DIR/flowtask" install --anas

echo ""
print_success "FlowTask installation complete!"
echo ""
print_info "You can now use the 'flowtask' command from anywhere:"
echo -e "  ${YELLOW}flowtask install --anas${NC}    Install FlowTask"
echo -e "  ${YELLOW}flowtask help${NC}              Show help"
echo ""
