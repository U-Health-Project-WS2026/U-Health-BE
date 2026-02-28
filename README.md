# U-Health-Backend Overview

## Authors

The U-Health-Backend project was developed by the following contributors:

- **[Paul Lopatin](https://github.com/Paul-SE1)** – Backend Developer, responsible for system integration, Controllers, Request and Resource Classes.
- **[Sebastian Kohrell](https://github.com/xP3rsy)** – Backend Developer, responsible for database modeling and management, Models creation and connecting Project to DB.
- **[Muhammed Emir Akgül](https://github.com/29cmtruedamage)** – Backend Developer, responsible for architecture, RESTful API design, and authentication implementation with Laravel Sanctum.

These authors collaborated to ensure a secure, scalable, and maintainable backend system for the U-Health platform.

- **[Evin Yilmaz](https://github.com/eviin)** Lead Frontend Developer for the Admin-Frontend Page.
- **[Christpher Herlitz](https://github.com/Topher6401)** Lead Frontend Developer for the Users-Frontend Page.

## 1. Introduction

### 1.1 Purpose of the Project
The U-Health-Backend is a RESTful backend application developed using the Laravel framework. It serves as the central server component of the U-Health system and is responsible for managing business logic, authentication, data processing, and secure communication between clients and the database.

The backend provides a structured API that allows external client applications, such as web or mobile frontends, to interact with the system. All communication is performed using RESTful principles and JSON-formatted data. This ensures a standardized, lightweight, and platform-independent communication method.

A core feature of the system is secure user authentication and authorization, implemented using Laravel Sanctum. Sanctum provides token-based authentication, allowing authenticated users such as administrators and patients to securely access protected API endpoints.

The backend manages several key functional areas, including:
- User authentication and session management
- Patient data management
- Administrative system operations
- Secure database interaction
- Request validation and structured API responses

The project follows Laravel best practices and uses a modular architecture based on controllers, models, requests, resources, and middleware to ensure maintainability, scalability, and security.

### 1.2 Scope
This project is designed as a backend-only system. It does not include any frontend user interface. Instead, it exposes RESTful API endpoints that can be consumed by external client applications.

The backend is responsible for:
- Processing incoming API requests
- Validating and handling business logic
- Managing authentication and authorization
- Performing database operations
- Returning structured JSON responses

Client applications are responsible for presenting the data to users and interacting with the API.

### 1.3 Technology Stack
The U-Health-Backend is built using modern backend technologies and tools to ensure performance, security, and maintainability.

**Core Technologies**
- Programming Language: PHP 8.2
- Framework: Laravel 12.0
- Authentication: Laravel Sanctum (via Laravel Breeze)
- Database: MySQL
- Dependency Management: Composer 1.8.2
- Version Control: Git and GitHub
- API Architecture: RESTful API
- Data Format: JSON

**Laravel Components Used**
- Controllers – Handle API requests and business logic
- Models – Represent database entities
- Requests – Handle validation of incoming data
- Resources – Format API responses
- Middleware – Handle authentication and request filtering
- Migrations – Manage database structure

### 1.4 Project Repository
The source code of the U-Health-Backend project is maintained in a GitHub repository:

[U-Health-Backend Repository](https://github.com/U-Health-Project-WS2026/U-Health-BE)

The repository contains the complete backend source code, including configuration, database migrations, and API implementation.

### 1.5 API Communication Overview
The backend follows RESTful design principles and communicates exclusively using JSON.

**Request Structure**
- HTTP method (GET, POST, PUT, DELETE)
- Specific API endpoint
- Optional authentication token
- Optional JSON request body

**Response Structure**
- HTTP status code
- JSON formatted response body
- Requested or processed data
- Status and message information

This architecture ensures compatibility with various client platforms and provides a scalable and maintainable backend system.

### 1.6 Authentication Overview
Authentication is implemented using Laravel Sanctum, which provides secure token-based authentication for API access.

After successful login, users receive a personal access token. This token must be included in subsequent API requests to access protected endpoints.

Sanctum ensures:
- Secure authentication
- Stateless API communication
- Protection of restricted routes
- Controlled access to system resources

### 1.7 Expectations
The U-Health-Backend provides a secure, scalable, and structured RESTful backend for the U-Health system. It handles authentication, business logic, and database interaction while exposing standardized JSON-based API endpoints for client applications.

### 1.8 Installation

**Step 0: Prerequisites**
1. Install PHP and Composer via Herd: [Herd for Windows](https://herd.laravel.com/windows)
2. Verify installation in Terminal:
   ```bash
   php -v
   composer -V

### Step 3: Configure Mailtrap
1. Sign up at [Mailtrap](https://mailtrap.io/).
2. Click on your username (top right) and navigate to **Sandboxes → MySandbox**.
3. Copy the provided **Port, Host, Username, and Password** for later use.

### Step 4: Setup `.env` File
1. In your project directory, run:
   ```bash
   cp .env.example .env

Open the `.env` file and go to Line 51.

Update the mail configuration with the values from Mailtrap:
```bash
MAIL_MAILER=smtp
MAIL_HOST={mailtrap.host}
MAIL_PORT=2525
MAIL_USERNAME={mailtrap.username}
MAIL_PASSWORD={mailtrap.password}
Step 5: Configure Database
````
### Step 5:
Now in the `.env` file, go to Line 29.

Enter the MySQL password you set during installation:
```bash
DB_PASSWORD=your_mysql_password
````

### Step 6: Start the Server

Run the Laravel development server:
```bash
php artisan serve
````
To specify a custom port:
```bash
php artisan serve --port=xxxx
````
Finished!

The U-Health backend server is now running and ready to handle API requests.





<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## More About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
