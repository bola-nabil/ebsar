# Ebsar (Book Management System) 🌐 [Live Demo](https://ebsar-production.up.railway.app/)

## 📖 Description
Ebsar is a library management system that enables administrators to manage books, publishers, authors, and assign categories to each book. The system is connected to a mobile application specifically designed for users with special needs, allowing them to listen to books in a simple and accessible way.

## 🛠️ Built With
- PHP
- Laravel
- MySQL
- RESTful API
- JWT (JSON Web Token)
- Laravel Middleware
- Authentication & Security
- Railway (Deployment Server)

## 🚀 Getting Started (Local Development)

### 1. Install Composer (if not already installed)
Follow the official guide: [Composer Installation](https://getcomposer.org/download/)

### 2. Install Laravel Installer
```bash
composer global require laravel/installer
```

### 3. Clone the Project & Navigate to It
```bash
git clone https://github.com/bola-nabil/ebsar.git
cd ebsar
```

### 4. Install Dependencies
```bash
composer install
```

### 5. Copy & Configure Environment File
```bash
cp .env.example .env
```
Then edit the `.env` file and set your local database credentials and other environment settings.

### 6. Generate Application Key
```bash
php artisan key:generate
php artisan jwt:secret
```

### 7. Run Migrations
```bash
php artisan migrate
```

### 8. Set Frontend App URL for CORS
Update the `config/cors.php` file or `.env` file:
```php
'allowed_origins' => ['http://localhost:3000'],
```

### 9. Start the Development Server
```bash
php artisan serve
```

Your application will now be running at:  
**http://localhost:8000**


## 📢 Live Project
👉 [Visit Ebsar Online](https://ebsar-production.up.railway.app/)
