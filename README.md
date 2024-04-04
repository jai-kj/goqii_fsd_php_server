# PHP Server Setup Guide

This guide will walk you through setting up and running a PHP server for your project.

## Prerequisites

Before getting started, ensure that you have the following prerequisites installed on your system:

- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/)

## Installation

1. Install the required PHP dependencies using Composer:
   ```bash
   composer require vlucas/phpdotenv
   ```
2. Create a `.env` file from the provided `.env.example`:

   ```bash
   cp .env.example .env
   ```

3. Configure your `.env` file with the appropriate database credentials. Make sure to create a MySQL database with the name specified in the `.env` file.

4. Navigate to the PHP server directory in your terminal.

5. Run the following command to create the necessary database tables:
   ```bash
   php seeder/db_tables.php create-tables
   ```
6. After creating the tables, load data into the user table by running:

   ```bash
   php seeder/db_tables.php load-data
   ```

7. Finally, start the PHP server by running the following command:
   ```bash
   php -S localhost:8000 -t public
   ```
8. Accessing the Server

   Once the PHP server is running, you can access your application by opening a web browser and navigating to
   `http://localhost:8000`

   ###

   Ensure that your MySQL server is running to enable database interactions.
   The php server is connected to the database successfully and is running on port 8000

### Testing with cURL:

You can also test the server by using cURL. Open your terminal and execute the following command:

```bash
curl http://localhost:8000
```

This setup guide ensures that your PHP server is correctly configured and running. If you encounter any issues or need further assistance, feel free to ask!
