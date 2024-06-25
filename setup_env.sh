#!/bin/bash

# Ensure .env file exists
if [ ! -f .env ]; then
    if [ ! -f .env.example ]; then
        echo ".env.example file not found. Please create it before running the setup script."
        exit 1
    fi
    cp .env.example .env
    echo ".env file created."
else
    echo ".env file already exists."
fi

# Generate Laravel app key
if [ ! -f artisan ]; then
    echo "artisan file not found. Make sure you're in the Laravel project root directory."
    exit 1
fi
php artisan key:generate
echo "Laravel app key generated."

# Ensure the database directory and file exist
if [ ! -d database ]; then
    mkdir database
    echo "Database directory created."
fi

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "SQLite database created."
else
    echo "SQLite database already exists."
fi

# Migrate the database
php artisan migrate
echo "Database migrated."

# Composer update
composer update
echo "composer dependencies updated."

# Compser install dependencies
composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
echo "composer dependencies installed"

# Run npm commands
npm install
echo "npm packages installed."

npm run build
echo "npm run build executed."

# Create the virtual environment for Python scripts
if [ ! -d storage/app/scripts ]; then
    mkdir -p storage/app/scripts
    echo "Scripts directory created."
fi

cd storage/app/scripts

if [ ! -d "venv" ]; then
    python3 -m venv venv
    echo "Virtual environment created."

    # Activate the virtual environment
    source venv/bin/activate

    # Install the required dependency
    pip install pgpy
    echo "pgpy installed."

    # Deactivate the virtual environment
    deactivate
else
    echo "Virtual environment already exists."
fi

# Go back to project root and start Laravel development server
cd ../../../
