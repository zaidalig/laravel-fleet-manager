# laravel-mysql-fleet-manager

Laravel MySQL fleet management system with vehicles, drivers, trips, fuel logs, maintenance, users, roles, dashboard, and activity logs.

## Tech Stack

- PHP 8.5
- Laravel 13
- MySQL / MariaDB
- Blade + Bootstrap 5 + Font Awesome

## Features

- Dashboard with vehicle counts, available fleet, active trips, monthly fuel cost, and maintenance due this month
- Vehicle registry with plate, type, status, and odometer
- Driver profiles with license details and linked user accounts
- Trip planning and status workflow (planned → in progress → completed/cancelled) with vehicle status updates
- Fuel logs with optional trip linkage and date-range filters
- Maintenance records with overdue next-service highlighting
- Role-based access: owner, manager, driver, viewer
- Search and filter controls with Clear on every list page
- Activity logs

## Roles

| Role | Access |
|------|--------|
| owner | Everything |
| manager | Vehicles, drivers, fuel, maintenance, trips |
| driver | Trips only (plus dashboard / activity) |
| viewer | Dashboard and activity logs only |

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create database:

```sql
CREATE DATABASE fleet_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Set `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fleet_manager
DB_USERNAME=root
DB_PASSWORD=
```

Run:

```bash
php artisan migrate --seed
php artisan serve
php artisan test
```

## Demo Login

| Email | Role | Password |
|-------|------|----------|
| owner@example.com | Owner | password |
| manager@example.com | Manager | password |
| driver@example.com | Driver | password |
| viewer@example.com | Viewer (inactive) | password |
