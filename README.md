# Lokiss Ticket System

## Table of Contents
- [Prerequisites](#prerequisites)
- [Clone the Project](#clone-the-project)
- [Install Dependencies](#install-dependencies)
- [Create Environment File](#create-environment-file)
- [Generate Application Key](#generate-application-key)
- [Create Database (if needed)](#create-database-if-needed)
- [Run Migrations](#run-migrations)
- [Seeder Data (Optional)](#seeder-data-optional)
- [Run the Project](#run-the-project)

## Prerequisites
Make sure you have the following installed on your system:
- MySQL
- Apache
- Git

## Clone the Project
Clone the project using the following command:
    ```bash
    git clone https://github.com/lokissdo/lokiss-ticket
    ```
## Install Dependencies
Navigate to the project's root directory:
    ```bash
    cd lokiss-ticket
    ```
## Install the required dependencies using Composer:

    ```bash
    composer install
    ```
## Create Environment File
Copy the `.env.example` file to a new file named `.env`:
    ```bash
    cp .env.example .env
    ```
Edit the .env file to configure your database credentials and other settings. Make sure to configure your API keys (Discord, Google, etc.) and mail sender credentials.

## Generate Application Key
Run the following command to create a unique application key:
    ```bash
    php artisan key:generate
    ```
## Create Database (if needed)
If the project requires a new database, create it in your MySQL server, for example, using phpMyAdmin. The default database name is ticketweb as specified in the configuration.

Run Migrations
Apply database migrations using the following command:
    ```bash
    php artisan migrate
    ```
## Seeder Data (Optional)
If needed, you can seed the database with sample data in a specific order. Run the following command:
    ```bash
    php artisan db:seed
    ```
The seeding order is as follows: Province, District, UserSeeder, ServiceProvider, Coach, Station, Schedule, ScheduleDetail, Trip, Ticket, Rating.

## Run the Project
Using Laravel's Built-in Server
Start a local development server with the following command:
    ```bash
    php artisan serve
    ```
Access the project in your browser at   `http://localhost:8000` or the specified address in the terminal.

Feel free to explore and use the Lokiss Ticket System!