# Roadsurfer Food API

## Overview

Roadsurfer Food API is a RESTful web service built using Symfony that allows users to manage a collection of food items. The API provides functionalities to create, retrieve, update, delete, and search for food items. Additionally, it allows users to query food data with different unit types (grams or kilograms).

The application follows clean and modular coding practices, separating concerns between controllers, services, repositories, and data transformation (DTO).

## Features

- Built with Symfony 7.1 and PHP 8.2.
- RESTful API endpoints for managing food items.
- Create, update, retrieve, and delete food items.
- Search for food items based on multiple criteria (name, type, quantity, etc.).
- Option to return food quantities in grams or kilograms.
- Full validation of incoming data and error handling.
- ✨Magic from Mahmoud .. Tada! ✨

## Technologies Used

## Tech

Used open source projects:

- **[PHP]** - PHP >= 8.2
- **[Symfony]** - An awesome PHP framework for building web applications.
- **[FOS/Rest Bundle]** - A symfony bundle to handle the API calls.
- **Doctrine ORM**: Used for database interaction and entity management.
- **JMS Serializer**: For handling JSON serialization and deserialization.
- **MySQL/PostgreSQL**: (Or any preferred database supported by Doctrine ORM).

## Installation

### Prerequisites

Ensure that you have the following installed on your machine:
- PHP 8.2 or later
- Composer
- A web server (e.g., Apache or Nginx)
- A database (e.g., MySQL or PostgreSQL)

### Setup Instructions

1. Clone the repository:

   ```bash
   git clone https://github.com/php-ini/roadsurfer.git
   cd roadsurfer
   ```
2. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```
3. Create a `.env` file in the project root and configure your database connection:

   ```bash
   cp .env.example .env
   ```
   Update the .env file to match your database configuration:

   ```bash
   DATABASE_URL="mysql://username:password@127.0.0.1:3306/your_database_name"
    ```
4. Create the database schema:

   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:schema:create
   ```
   Run database migrations to set up the tables:

   ```bash
   php bin/console doctrine:migrations:migrate
   ```
5. Start the Symfony server:

   ```bash
    symfony server:start
    ```
   Alternatively, use the PHP built-in server:

   ```bash
   php -S 127.0.0.1:8000 -t public/
   ```
6. Access the application at http://localhost:8000.

---

## Usage (API Endpoints)


### Base URL
    http://localhost:8000/api/v1

### The json import command:
    php bin/console app:import-foods

### Endpoints

#### 1. Get All Foods
    GET /api/v1/foods

Retrieve a list of all food items. You can also specify the unit type (grams or kilograms) as a query parameter.

- **Optional Query Parameters**:
    - `unit` (values: `g` or `kg`)

Example:
    `GET /api/v1/foods?unit=kg`

#### 2. Get Food by ID
    GET /api/v1/foods/{id}
Retrieve a specific food item by its ID.

- **Path Parameters**:
    - `id` (integer) - ID of the food item

#### 3. Create Food
    POST /api/v1/foods

Create a new food item.

- **Request Body** (JSON):

```json
{
  "name": "Apple",
  "type": "fruit",
  "quantity": 500,
  "unit": "g"
}
```

#### 4. Update Food by ID
    PUT /api/v1/foods/{id}
Update an existing food item by its ID.

- **Path Parameters**: 
    - `id` (integer) - ID of the food item

Request Body (JSON):
    
```json
{
"name": "Apple",
"type": "fruit",
"quantity": 1000,
"unit": "g"
}
```
#### 5. Delete Food by ID
    DELETE /api/v1/foods/{id}
Delete a specific food item by its ID.

- **Path Parameters**:
    - `id` (integer) - ID of the food item

#### 6. Search for Foods
    GET /api/v1/foods/search
Search for food items based on query parameters.

- **Optional Query Parameters:**:
    - `name` (string) - Search for food by name
    - `type` (string) - Filter by food type (e.g., fruit or vegetable)
    - `unit` (string) - Filter by unit (e.g., g or kg)
    - `min_quantity` (integer) - Filter by minimum quantity
    - `max_quantity` (integer) - Filter by maximum quantity 

Example:
    `/api/v1/foods/search?name=Apple&type=fruit&unit=g&min_quantity=500`

- Note: You can combine multiple query parameters to narrow down your search results.

### Validation and Error Handling
The API provides proper validation for incoming requests. If validation fails, the API returns a 422 Unprocessable Entity response with detailed error messages.

Example error response:
    
```json
{
  "message": "Validation Failed",
  "errors": {
    "name": ["This value should not be blank."],
    "type": ["This value should not be blank."],
    "quantity": ["This value should be greater than 0."],
    "unit": ["This value should be either 'g' or 'kg'."]
  }
}
```

### Testing
To run tests, ensure that PHPUnit is installed and run:

```bash
php bin/phpunit
```

### License
This project is open-source and available under the [MIT License](LICENSE).

**Copy rights reserved to [Mahmoud Abdelsattar]!**

[PHP]: <https://www.php.net>
[FOS/Rest Bundle]: <https://fosrestbundle.readthedocs.io/en/3.x/>
[symfony]: <https://symfony.com>
[git-repo-url]: <https://github.com/php-ini/roadsurfer.git>
[Mahmoud Abdelsattar]: <http://mahmoudabdelsattar.com>
