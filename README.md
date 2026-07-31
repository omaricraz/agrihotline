# Complaint Management System

Ministry of Agriculture, Republic of Somaliland

## Setup

1. Copy `.env.example` to `.env` if needed and set MySQL credentials:
   - `DB_CONNECTION=mysql`
   - `DB_DATABASE=agrihotline`
   - `DB_USERNAME=root`
   - `DB_PASSWORD=`
2. Install dependencies: `composer install`
3. Generate key: `php artisan key:generate`
4. Run migrations & seed: `php artisan migrate --seed`
5. Serve: `php artisan serve`

## Default logins

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@agrihotline.so | password |
| Manager | manager@agrihotline.so | password |
| Call Center | callcenter@agrihotline.so | password |

## Stack

- Laravel + MySQL
- Blade + Bootstrap 5
- DomPDF for daily reports
- CSV export (no Excel package)
