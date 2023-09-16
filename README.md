<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# PHP Web Crawler Developed with Laravel Framework

This is a simple web crawler demonstration project developed using the Laravel framework. It can be used to fetch the content of a specified URL and save metadata about the web page, such as title, description, and body.

## Features

- Input a URL to crawl
- Crawl a screenshot of the web page
- Extract web page title, description, and body
- View a history of crawled records
- Search and filter by title, description, or creation date

## System Requirements

- PHP >= 7.4
- Composer
- MariaSQL Database
- Node.js and NPM (for the frontend part)

## Installation Steps

1. Clone the project repository to your local machine:

   ```bash
   git clone https://github.com/JerryR7/Crawler-Laravel.git
   ```

2. Navigate to the project directory:

   ```bash
   cd Crawler
   ```

3. Install PHP dependencies:

   ```bash
   composer install
   ```

4. Copy the `.env.example` file and rename it to `.env`, then configure the database connection and other environment variables:

   ```bash
   cp .env.example .env
   ```

   Modify the following section in the `.env` file to configure the database connection:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Run database migrations:

   ```bash
   php artisan migrate
   ```

7. Install frontend dependencies (if not already installed):

   ```bash
   npm install
   ```

8. Create the symbolic link:

   ```bash
   php artisan storage:link
   ```

9. Start the local development server:

   ```bash
   php artisan serve
   ```

10. Access `http://localhost:8000/crawler` to view the project.

## Usage Example

1. Open the application, and you will see an input box where you can enter the URL to crawl.
2. Enter a URL and click the "Crawl" button to initiate crawling and save web page information.
3. You can view previous crawl records on the "Crawled Records" page.
4. On the "Crawled Records" page, you can also use the search and filter functionality to find records with specific titles, descriptions, or creation dates.

## Contributing

If you'd like to contribute to this project, please feel free to submit issues, suggestions, or pull requests. Please follow our [contribution guidelines](CONTRIBUTING.md).

## License

This project is licensed under the MIT License. For details, please refer to the [LICENSE](LICENSE) file.

