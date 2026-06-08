# Barbershop API

RESTful API for managing a barbershop system, built with Laravel 12.

The project provides authentication, administrator management, client management, scheduling management, conflict validation, and administrator notifications when a new scheduling is created.

## Technologies

* PHP 8.3+
* Laravel 12
* MySQL
* Laravel Sanctum
* Composer

## Features

* Token-based authentication with Laravel Sanctum
* Public client registration
* Administrator-only access control with middleware
* CRUD operations for administrators
* CRUD operations for clients
* CRUD operations for schedulings
* UUIDs for main entities
* Pagination for administrator, client, and scheduling listings
* Scheduling conflict validation
* Form Requests for data validation
* Service Classes for business logic
* E-mail notification for administrators when a scheduling is created

## Requirements

Before running the project, make sure you have installed:

* PHP 8.3 or higher
* Composer
* MySQL
* Git

## Installation

Clone the repository:

```bash
git clone https://github.com/Andrerrb/barbershop-api-laravel.git
```

Enter the project directory:

```bash
cd barbershop-api-laravel
```

Install dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Create a MySQL database named:

```text
barbearia
```

Check the database settings in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barbearia
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seeders:

```bash
php artisan migrate:fresh --seed
```

Start the local server:

```bash
php artisan serve
```

The API will be available at:

```text
http://127.0.0.1:8000
```

## Initial Administrator

The seeders create an initial administrator account for local testing:

```text
E-mail: admin@barbearia.com
Password: password123
```

These credentials are intended only for development and testing.

## Authentication

The API uses Laravel Sanctum.

After login, use the returned token in protected endpoints:

```text
Authorization: Bearer YOUR_TOKEN
```

## API Endpoints

### Authentication

| Method | Endpoint      | Description                          | Authentication |
| ------ | ------------- | ------------------------------------ | -------------- |
| POST   | `/api/login`  | Authenticate user and generate token | Public         |
| POST   | `/api/logout` | Revoke current token                 | Required       |
| GET    | `/api/user`   | Return authenticated user            | Required       |

### Clients

| Method | Endpoint                | Description           | Authentication |
| ------ | ----------------------- | --------------------- | -------------- |
| POST   | `/api/clients/register` | Register a new client | Public         |
| GET    | `/api/clients`          | List clients          | Admin          |
| GET    | `/api/clients/{client}` | Show a client         | Admin          |
| PATCH  | `/api/clients/{client}` | Update a client       | Admin          |
| DELETE | `/api/clients/{client}` | Delete a client       | Admin          |

### Administrators

| Method | Endpoint              | Description             | Authentication |
| ------ | --------------------- | ----------------------- | -------------- |
| POST   | `/api/admins`         | Create an administrator | Admin          |
| GET    | `/api/admins`         | List administrators     | Admin          |
| GET    | `/api/admins/{admin}` | Show an administrator   | Admin          |
| PATCH  | `/api/admins/{admin}` | Update an administrator | Admin          |
| DELETE | `/api/admins/{admin}` | Delete an administrator | Admin          |

### Schedulings

| Method | Endpoint                        | Description                                      | Authentication |
| ------ | ------------------------------- | ------------------------------------------------ | -------------- |
| POST   | `/api/schedulings`              | Create a scheduling for the authenticated client | Required       |
| GET    | `/api/schedulings`              | List schedulings                                 | Admin          |
| GET    | `/api/schedulings/{scheduling}` | Show a scheduling                                | Admin          |
| PATCH  | `/api/schedulings/{scheduling}` | Update a scheduling                              | Admin          |
| DELETE | `/api/schedulings/{scheduling}` | Delete a scheduling                              | Admin          |

## Scheduling Validation

A scheduling request must include:

```json
{
  "start_date": "2026-06-11 14:00:00",
  "end_date": "2026-06-11 15:00:00"
}
```

The API validates that:

* the end date is after the start date;
* the authenticated user has a client profile;
* the selected time does not overlap an existing scheduling.

Example of conflicting intervals:

```text
Existing scheduling: 14:00 - 15:00
New scheduling:      14:30 - 15:30
Result:              422 Unprocessable Entity
```

## E-mail Notifications

When a new scheduling is created, administrators receive an e-mail notification containing:

* client name;
* scheduling date;
* start time;
* end time.

For local development, the default configuration uses:

```env
MAIL_MAILER=log
```

Generated e-mails are recorded in:

```text
storage/logs/laravel.log
```

To send real e-mails, replace the mail settings in `.env` with SMTP credentials.

## Testing with Apidog

The endpoints can be tested using Apidog, Postman, Insomnia, or another HTTP client.

Recommended folder structure:

```text
Auth
├── Login
├── Logout
└── Get Authenticated User

Clients
├── Register Client
├── List Clients
├── Show Client
├── Update Client
└── Delete Client

Admins
├── Create Admin
├── List Admins
├── Show Admin
├── Update Admin
└── Delete Admin

Schedulings
├── Create Scheduling
├── List Schedulings
├── Show Scheduling
├── Update Scheduling
└── Delete Scheduling
```

## Important Notes

* Main entities use UUIDs.
* Client data is stored across `users` and `clients`.
* Administrators are stored in `users` and linked to the `admin` user type.
* Scheduling conflicts are checked before insertions and updates.
* Protected administrator endpoints use both Sanctum authentication and an administrator middleware.

## License

This project was developed as a technical challenge.
