#!/usr/bin/env node

const { program } = require('commander');
const chalk = require('chalk');
const ora = require('ora');
const inquirer = require('inquirer');
const shell = require('shelljs');
const axios = require('axios');
const path = require('path');
const fs = require('fs');

// Configuration
const PROJECT_NAME = 'flowtask-app';
const REPO_URL = 'https://github.com/anass755/flowtask.git';
const INSTALL_DIR = path.join(process.env.HOME || process.env.USERPROFILE, PROJECT_NAME);

// Helper functions
const log = {
  success: (msg) => console.log(chalk.green('✓'), msg),
  error: (msg) => console.log(chalk.red('✗'), msg),
  info: (msg) => console.log(chalk.blue('ℹ'), msg),
  warning: (msg) => console.log(chalk.yellow('⚠'), msg),
};

const exec = (command, options = {}) => {
  return new Promise((resolve, reject) => {
    shell.exec(command, { ...options, silent: true }, (code, stdout, stderr) => {
      if (code !== 0) {
        reject({ code, stdout, stderr });
      } else {
        resolve({ stdout, stderr });
      }
    });
  });
};

const checkCommand = async (command) => {
  try {
    await exec(`which ${command}`);
    return true;
  } catch {
    return false;
  }
};

const detectOS = () => {
  const platform = process.platform;
  if (platform === 'darwin') return 'Mac';
  if (platform === 'linux') return 'Linux';
  if (platform === 'win32') return 'Windows';
  return 'Unknown';
};

// Installation steps
const checkPrerequisites = async () => {
  const spinner = ora('Checking prerequisites...').start();
  
  const os = detectOS();
  spinner.info(`Detected OS: ${os}`);
  
  // Check Node.js
  const hasNode = await checkCommand('node');
  if (!hasNode) {
    spinner.fail('Node.js is not installed');
    log.info('Please install Node.js from: https://nodejs.org/');
    process.exit(1);
  }
  spinner.succeed('Node.js is installed');
  
  // Check Git
  const hasGit = await checkCommand('git');
  if (!hasGit) {
    spinner.fail('Git is not installed');
    log.info('Please install Git from: https://git-scm.com/');
    process.exit(1);
  }
  spinner.succeed('Git is installed');
  
  // Check Docker
  const hasDocker = await checkCommand('docker');
  if (!hasDocker) {
    spinner.fail('Docker is not installed');
    log.info('Please install Docker from: https://www.docker.com/get-started');
    process.exit(1);
  }
  spinner.succeed('Docker is installed');
  
  // Check Docker Compose
  const hasDockerCompose = await checkCommand('docker-compose');
  if (!hasDockerCompose) {
    spinner.fail('Docker Compose is not installed');
    log.info('Please install Docker Compose from: https://docs.docker.com/compose/install/');
    process.exit(1);
  }
  spinner.succeed('Docker Compose is installed');
  
  spinner.succeed('All prerequisites met');
};

const cloneRepository = async () => {
  const spinner = ora('Cloning FlowTask repository...').start();
  
  // Check if directory exists
  if (fs.existsSync(INSTALL_DIR)) {
    spinner.warn('Project directory already exists');
    const answers = await inquirer.prompt([
      {
        type: 'confirm',
        name: 'remove',
        message: 'Do you want to remove it and reinstall?',
        default: false,
      },
    ]);
    
    if (answers.remove) {
      shell.rm('-rf', INSTALL_DIR);
      spinner.info('Removed existing directory');
    } else {
      spinner.fail('Installation cancelled');
      process.exit(1);
    }
  }
  
  try {
    await exec(`git clone ${REPO_URL} ${INSTALL_DIR}`);
    spinner.succeed('Repository cloned successfully');
  } catch (error) {
    spinner.fail('Failed to clone repository');
    log.error(error.stderr);
    process.exit(1);
  }
};

const setupEnvironment = async () => {
  const spinner = ora('Setting up environment...').start();
  
  const envExample = path.join(INSTALL_DIR, '.env.example');
  const envFile = path.join(INSTALL_DIR, '.env');
  
  if (fs.existsSync(envExample)) {
    shell.cp(envExample, envFile);
    spinner.succeed('Environment file created');
  } else {
    spinner.warn('No .env.example found, creating default .env');
    const defaultEnv = `
APP_NAME=FlowTask
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=flowtask
DB_USERNAME=root
DB_PASSWORD=root

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
`;
    fs.writeFileSync(envFile, defaultEnv.trim());
    spinner.succeed('Environment file created');
  }
  
  // Ask for custom port
  const answers = await inquirer.prompt([
    {
      type: 'input',
      name: 'port',
      message: 'Enter the port you want to use (default: 8080):',
      default: '8080',
      validate: (input) => {
        const port = parseInt(input);
        if (isNaN(port) || port < 1 || port > 65535) {
          return 'Please enter a valid port number (1-65535)';
        }
        return true;
      },
    },
  ]);
  
  // Update port in .env file
  let envContent = fs.readFileSync(envFile, 'utf8');
  envContent = envContent.replace(/APP_PORT=.*/g, `APP_PORT=${answers.port}`);
  envContent = envContent.replace(/APP_URL=.*/g, `APP_URL=http://localhost:${answers.port}`);
  fs.writeFileSync(envFile, envContent);
  
  spinner.succeed(`Environment configured with port ${answers.port}`);
  return answers.port;
};

const buildDocker = async () => {
  const spinner = ora('Building Docker containers...').start();
  
  try {
    shell.cd(INSTALL_DIR);
    await exec('docker-compose build');
    spinner.succeed('Docker containers built successfully');
  } catch (error) {
    spinner.fail('Failed to build Docker containers');
    log.error(error.stderr);
    process.exit(1);
  }
};

const startDocker = async () => {
  const spinner = ora('Starting Docker containers...').start();
  
  try {
    shell.cd(INSTALL_DIR);
    await exec('docker-compose up -d');
    spinner.succeed('Docker containers started successfully');
  } catch (error) {
    spinner.fail('Failed to start Docker containers');
    log.error(error.stderr);
    process.exit(1);
  }
};

const waitForContainers = async () => {
  const spinner = ora('Waiting for containers to be ready...').start();
  
  // Wait for 10 seconds
  await new Promise(resolve => setTimeout(resolve, 10000));
  
  spinner.succeed('Containers are ready');
};

const runMigrations = async () => {
  const spinner = ora('Running database migrations...').start();
  
  try {
    shell.cd(INSTALL_DIR);
    await exec('docker-compose exec -T app php artisan migrate --force');
    spinner.succeed('Migrations completed successfully');
  } catch (error) {
    spinner.fail('Failed to run migrations');
    log.error(error.stderr);
    process.exit(1);
  }
};

const runSeeders = async () => {
  const spinner = ora('Running database seeders...').start();
  
  try {
    shell.cd(INSTALL_DIR);
    await exec('docker-compose exec -T app php artisan db:seed --force');
    spinner.succeed('Seeders completed successfully');
  } catch (error) {
    spinner.fail('Failed to run seeders');
    log.error(error.stderr);
    process.exit(1);
  }
};

const generateAppKey = async () => {
  const spinner = ora('Generating application key...').start();
  
  try {
    shell.cd(INSTALL_DIR);
    await exec('docker-compose exec -T app php artisan key:generate');
    spinner.succeed('Application key generated');
  } catch (error) {
    spinner.fail('Failed to generate application key');
    log.error(error.stderr);
    process.exit(1);
  }
};

const clearCache = async () => {
  const spinner = ora('Clearing application cache...').start();
  
  try {
    shell.cd(INSTALL_DIR);
    await exec('docker-compose exec -T app php artisan cache:clear');
    await exec('docker-compose exec -T app php artisan config:clear');
    await exec('docker-compose exec -T app php artisan route:clear');
    spinner.succeed('Cache cleared successfully');
  } catch (error) {
    spinner.fail('Failed to clear cache');
    log.error(error.stderr);
    process.exit(1);
  }
};

const printSummary = (port) => {
  console.log('');
  console.log(chalk.green('========================================'));
  console.log(chalk.green('  Installation Complete!'));
  console.log(chalk.green('========================================'));
  console.log('');
  log.info('FlowTask has been successfully installed!');
  console.log('');
  console.log(chalk.blue('Access URLs:'));
  console.log(`  Application: ${chalk.green(`http://localhost:${port}`)}`);
  console.log(`  Admin Login:  ${chalk.green(`http://localhost:${port}/admin/login`)}`);
  console.log(`  Staff Login:  ${chalk.green(`http://localhost:${port}/staff/login`)}`);
  console.log('');
  console.log(chalk.blue('Default Credentials:'));
  console.log(`  Superadmin: ${chalk.yellow('superadmin@example.com')} / ${chalk.yellow('superadmin@123')}`);
  console.log(`  Staff:      ${chalk.yellow('staff@example.com')} / ${chalk.yellow('staff@1234')}`);
  console.log('');
  console.log(chalk.blue('Useful Commands:'));
  console.log(`  Stop containers:    ${chalk.yellow(`cd ${INSTALL_DIR} && docker-compose down`)}`);
  console.log(`  Start containers:   ${chalk.yellow(`cd ${INSTALL_DIR} && docker-compose up -d`)}`);
  console.log(`  View logs:          ${chalk.yellow(`cd ${INSTALL_DIR} && docker-compose logs -f`)}`);
  console.log(`  Run migrations:     ${chalk.yellow(`cd ${INSTALL_DIR} && docker-compose exec app php artisan migrate`)}`);
  console.log('');
  log.success('Installation completed successfully!');
  console.log('');
};

// Main installation function
const install = async () => {
  console.log('');
  console.log(chalk.blue('========================================'));
  console.log(chalk.blue('  FlowTask Auto-Installer'));
  console.log(chalk.blue('  by Anas'));
  console.log(chalk.blue('========================================'));
  console.log('');
  
  try {
    await checkPrerequisites();
    await cloneRepository();
    const port = await setupEnvironment();
    await buildDocker();
    await startDocker();
    await waitForContainers();
    await runMigrations();
    await runSeeders();
    await generateAppKey();
    await clearCache();
    printSummary(port);
  } catch (error) {
    log.error('Installation failed:', error.message);
    process.exit(1);
  }
};

// CLI program
program
  .name('flowtask-app')
  .description('FlowTask Auto-Installer by Anas - One-command installation for FlowTask with Docker')
  .version('1.0.0');

program
  .command('install')
  .description('Install FlowTask with Docker setup')
  .action(install);

program
  .command('start')
  .description('Start FlowTask containers')
  .action(async () => {
    const spinner = ora('Starting FlowTask containers...').start();
    try {
      shell.cd(INSTALL_DIR);
      await exec('docker-compose up -d');
      spinner.succeed('FlowTask containers started');
    } catch (error) {
      spinner.fail('Failed to start containers');
      log.error(error.stderr);
      process.exit(1);
    }
  });

program
  .command('stop')
  .description('Stop FlowTask containers')
  .action(async () => {
    const spinner = ora('Stopping FlowTask containers...').start();
    try {
      shell.cd(INSTALL_DIR);
      await exec('docker-compose down');
      spinner.succeed('FlowTask containers stopped');
    } catch (error) {
      spinner.fail('Failed to stop containers');
      log.error(error.stderr);
      process.exit(1);
    }
  });

program
  .command('logs')
  .description('View FlowTask container logs')
  .action(() => {
    shell.cd(INSTALL_DIR);
    shell.exec('docker-compose logs -f');
  });

program
  .command('update')
  .description('Update FlowTask to latest version')
  .action(async () => {
    const spinner = ora('Updating FlowTask...').start();
    try {
      shell.cd(INSTALL_DIR);
      await exec('git pull origin main');
      await exec('docker-compose build');
      await exec('docker-compose up -d');
      spinner.succeed('FlowTask updated successfully');
    } catch (error) {
      spinner.fail('Failed to update FlowTask');
      log.error(error.stderr);
      process.exit(1);
    }
  });

// Default to install if no command provided
if (!process.argv.slice(2).length) {
  program.parse(process.argv);
  if (program.args.length === 0) {
    install();
  }
} else {
  program.parse(process.argv);
}
