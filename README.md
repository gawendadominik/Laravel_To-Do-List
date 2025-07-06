# Laravel To-Do List Project Setup

This guide provides step-by-step instructions to set up the Laravel To-Do List project locally.

## Prerequisites

Before starting, ensure you have the following installed on your system:

-   [Docker](https://www.docker.com/)
-   [Composer](https://getcomposer.org/)
-   [Node.js](https://nodejs.org/)

## Environment Setup

### Step 1: Clone the Repository

Clone the project repository to your local machine:

```bash
git clone https://github.com/gawendadominik/Laravel_To-Do-List.git
cd Laravel_To-Do-List
```

### Step 2: Install PHP Dependencies

Install PHP dependencies using Composer:

```bash
composer install
```

### Step 3: Install Node.js Dependencies

Install JavaScript dependencies using npm:

```bash
npm install
```

### Step 4: Build Frontend Assets

Compile the frontend assets for development:

```bash
npm run dev
```

This command will build and watch your frontend assets for changes.

### Step 5: Configure Environment Variables

Copy the `.env.example` file to `.env` and update the necessary environment variables:

```bash
cp .env.example .env
```

Ensure the database credentials match the Docker MySQL service configuration.

### Step 6: Create Sail Alias

To simplify the usage of Laravel Sail, create an alias for the `./vendor/bin/sail` command:

```bash
alias sail='bash ./vendor/bin/sail'
```

Add this alias to your shell configuration file (e.g., `.bashrc`, `.zshrc`) to make it persistent.

### Step 7: Start Docker Services

Start the Docker environment using the Sail alias:

```bash
sail up
```

At this point, the Docker environment is running, and the following services are active:

-   **laravel.test**: The Laravel application.
-   **mysql**: MySQL database server.

### Step 8: Run Migrations

Run database migrations to set up the schema:

```bash
sail artisan migrate
```

This step ensures the database is ready for use with the application.

### Step 9: Run Scheduler and Queue Workers

To enable task scheduling and queue workers, use the following commands:

#### Start the Scheduler

Run the Laravel scheduler in the background:

```bash
sail artisan schedule:work
```

#### Start the Queue Worker

Run the queue worker to process jobs:

```bash
sail artisan queue:work
```

Ensure these commands are running in separate terminal windows or use a process manager to keep them active.
