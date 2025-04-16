# NGO Management System

A comprehensive web application for managing NGO projects, trainings, and reports.

## Features

-   Project Management
-   Training Management
-   Report Management
-   Role-based Access Control (Admin, NGO, Authority)
-   User Management
-   File Upload and Download
-   Dashboard Analytics

## Prerequisites

-   PHP >= 8.1
-   Composer
-   MySQL >= 5.7
-   Node.js & NPM
-   XAMPP/WAMP/MAMP (for local development)

## Installation

1. Clone the repository

```bash
git clone <repository-url>
cd ngo-app
```

2. Install PHP dependencies

```bash
composer install
```

3. Install NPM dependencies

```bash
npm install
```

4. Create environment file

```bash
cp .env.example .env
```

5. Generate application key

```bash
php artisan key:generate
```

6. Configure your database in `.env` file

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations

```bash
php artisan migrate
```

8. Create storage link

```bash
php artisan storage:link
```

9. Compile assets

```bash
npm run dev
```

## Seeding Data

The application includes several seeders for testing and development purposes:

1. To seed all data (including dummy projects and trainings):

```bash
php artisan db:seed
```

2. To seed specific data:

-   For roles and permissions:

```bash
php artisan db:seed --class=RoleAndPermissionSeeder
```

-   For dummy projects:

```bash
php artisan db:seed --class=ProjectSeeder
```

-   For dummy trainings:

```bash
php artisan db:seed --class=TrainingSeeder
```

3. To refresh database and seed all data:

```bash
php artisan migrate:fresh --seed
```

## Default Users

After seeding, the following default users will be created:

1. Admin User:

    - Email: admin@example.com
    - Password: password

2. NGO User:

    - Email: ngo@example.com
    - Password: password

3. Authority User:
    - Email: authority@example.com
    - Password: password

## Running the Application

1. Start the development server

```bash
php artisan serve
```

2. In a separate terminal, run Vite for asset compilation

```bash
npm run dev
```

The application will be available at `http://localhost:8000`

## Testing

Run the test suite:

```bash
php artisan test
```

## License

[Your License]

## Support

For support, please contact [Your Contact Information]
