# Blogging Application

## Description

A simple blogging application built with Laravel, Vue.js, inertia, HTML, CSS, JavaScript.

## Features

- User registration and authentication
- Create, edit blog posts
- View and comment on blog posts
- User profiles
- Filtering functionality

## Technologies Used

- Laravel 10
- Vue 3
- HTML
- CSS
- JavaScript
- MySQL
- Inertia

## Prerequisites

- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [MySQL](https://dev.mysql.com/downloads/)
- [PHP](https://www.php.net/)
- [Laravel CLI](https://laravel.com/docs/10.x/installation)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/sounakm177/blog-app.git

2. **Change to the project directory:**

   ```bash
   cd blog-app

3. **Install PHP dependencies:**
   ```bash
   composer install

4. **Install JavaScript dependencies:**
   ```bash
   npm install

5. **Create a copy of the .env.example file as .env and configure your database settings:**
   ```bash
   cp .env.example .env

6. **Create a mysql database and enter database credentials in your .env file:**
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=blog-app
   DB_USERNAME=root
   DB_PASSWORD=

7. **Generate an application key:**
   ```bash
   php artisan key:generate

8. **Run database migrations (Make sure you have set up your database configuration in the `.env` file.):**
   ```bash
   php artisan migrate:fresh --seed
   
9. **Create a symbolic link for storage:**
   ```bash
   php artisan storage:link

1. **Start the development server:**
   ```bash
   php artisan serve
   
2. **Run the dev script in another terminal:**
   ```bash
   npm run dev

## User Credentials

You can use the following user credentials to log in as test users:

- User 1:
  - Email: Sounak@gmail.com
  - Password: password

- User 2:
  - Email: Sourav@gmail.com
  - Password: password

## Screenshots

Include project screenshots here:

![Screenshot 1](https://github.com/sounakm177/blog-app/assets/64001743/2017eee4-86b8-4c6a-be8f-ddfe6a6873dd)

![Screenshot 2](https://github.com/sounakm177/blog-app/assets/64001743/6d48b131-3bc6-4479-b59a-bb8371519669)

![Screenshot 3](https://github.com/sounakm177/blog-app/assets/64001743/10fc20bd-426e-4f42-9a9a-a2a821ed75ed)


