# StockPilot

**StockPilot** is a web-based inventory management system designed to simplify stock monitoring, inventory tracking, and purchasing activities. It provides a centralized platform for managing product information, monitoring stock availability, identifying low-stock items, and generating inventory reports.

## Features

- **User Authentication** — Provides secure access to authorized users.
- **Inventory Management** — Organizes product records and tracks stock quantities.
- **Stock Monitoring** — Helps identify low-stock items and monitor inventory levels.
- **Expiration Tracking** — Records product expiration dates and helps identify items nearing expiration.
- **Purchasing Management** — Supports purchase requests and approval workflows.
- **Alerts and Notifications** — Highlights low-stock items and products approaching expiration.
- **Reports and Statistics** — Provides inventory summaries and useful information for stock management.

*Note: Features are under development and may change as the system evolves.*

## Technologies Used

- **Backend:** PHP and Laravel
- **Frontend:** Blade, HTML, CSS, and JavaScript
- **Database:** MySQL
- **Development Environment:** XAMPP
- **Dependency Management:** Composer and npm

## System Requirements

Before installing StockPilot, ensure that the following are available:

- PHP compatible with the Laravel version specified in `composer.json`
- Composer
- MySQL or MariaDB
- Git
- Node.js and npm, if required for frontend asset compilation
- A web browser

XAMPP may be used to provide PHP, Apache, and MySQL for local development.

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/justinecahimat/StockPilot.git
cd StockPilot
```

### 2. Install Dependencies

Install the PHP dependencies:

```bash
composer install
```

If the project uses frontend assets that require compilation, install the Node.js dependencies:

```bash
npm install
npm run build
```

### 3. Configure the Environment

Create a local environment file by copying `.env.example` to `.env`.

On Windows Command Prompt:

```cmd
copy .env.example .env
```

On macOS or Linux:

```bash
cp .env.example .env
```

Update the database settings in `.env` to match the local database configuration.

```env
DB_DATABASE=stockpilot
DB_USERNAME=root
DB_PASSWORD=
```

The values above are typical XAMPP defaults. Use the appropriate credentials for the local MySQL installation.

### 4. Create and Import the Database

1. Start MySQL through XAMPP or the installed database service.
2. Open `http://localhost/phpmyadmin`.
3. Create a database named `stockpilot`.
4. Select the database and import the SQL file provided in the project's `database` directory.

### 5. Generate the Application Key

Run the following command:

```bash
php artisan key:generate
```

### 6. Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

Open the local address displayed in the terminal, usually:

http://127.0.0.1:8000

## Usage

After installation, open StockPilot in a web browser and sign in using an authorized account. Available functions depend on the user's assigned permissions and the features implemented in the current version.

## Database Information

StockPilot uses MySQL to store application data. An SQL export is provided in the `database` directory to help initialize a local database.

For development, database migrations and seeders may also be used when supported by the current project configuration.

## Security Notes

- Never publish the `.env` file or database credentials.
- Use strong passwords for application accounts.
- Do not import untrusted SQL files into a production database.
- Configure appropriate access permissions before deploying the application.

## Project Status

**In Development**

StockPilot is actively being developed. Features, interfaces, and workflows may be updated in future versions.

## License

No license has been specified yet. All rights are reserved by the respective copyright holders unless a license is added to this repository.

---

**Repository:** https://github.com/justinecahimat/StockPilot
