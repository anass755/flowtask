#!/bin/bash

# FlowTask Global Command Setup
# This script installs the 'flowtask' command globally on your system

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
echo -e "${BLUE}  FlowTask Global Command Setup${NC}"
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

# Determine bin directory
if [ "$MACHINE" = "Linux" ] || [ "$MACHINE" = "Mac" ]; then
    # Use /usr/local/bin or ~/.local/bin
    if [ -w "/usr/local/bin" ]; then
        BIN_DIR="/usr/local/bin"
    else
        BIN_DIR="$HOME/.local/bin"
        mkdir -p "$BIN_DIR"
        # Add to PATH if not already there
        if [[ ":$PATH:" != *":$HOME/.local/bin:"* ]]; then
            echo 'export PATH="$HOME/.local/bin:$PATH"' >> "$HOME/.bashrc"
            echo 'export PATH="$HOME/.local/bin:$PATH"' >> "$HOME/.zshrc"
            print_info "Added $BIN_DIR to PATH in .bashrc and .zshrc"
            print_warning "Please run: source ~/.bashrc or source ~/.zshrc"
        fi
    fi
else
    print_error "Unsupported OS for automatic setup"
    print_info "Please manually copy the 'flowtask' script to a directory in your PATH"
    exit 1
fi

print_info "Installing to: $BIN_DIR"

# Download the flowtask script
print_info "Downloading flowtask script..."
curl -sSL https://raw.githubusercontent.com/anass755/flowtask/main/flowtask -o "$BIN_DIR/flowtask"
chmod +x "$BIN_DIR/flowtask"
print_success "flowtask command installed to $BIN_DIR/flowtask"

echo ""
print_success "FlowTask global command installed successfully!"
echo ""
echo -e "${BLUE}Usage:${NC}"
echo -e "  ${YELLOW}flowtask install --anas${NC}    Install FlowTask application"
echo -e "  ${YELLOW}flowtask help${NC}              Show help message"
echo ""
print_info "You can now run 'flowtask install --anas' from anywhere!"
echo ""
