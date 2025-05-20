# Blog with Dark Mode Toggle

A Laravel blog app with Bootstrap 5 UI and a dark mode toggle.

## Requirements
- PHP >= 8.0
- Composer
- MySQL or compatible DB
- Node.js & npm

## Installation

Follow these steps to install and run the Laravel project locally:

1. Clone the repository and navigate into it:
   git clone https://github.com/balaji-11-udayasuriyan/blog
   cd blog

2. Install PHP dependencies using Composer:
   composer install

3. Setup environment configuration:
   cp .env.example .env
   Then open the .env file and update your database credentials and other settings as needed.

4. Generate application key:
   php artisan key:generate

5. Run database migrations:
   php artisan migrate

6. Start the development server:
   php artisan serve

7. Access the app:
   Open your browser and visit http://localhost:8000

