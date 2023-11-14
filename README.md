# Laravel Invoice_API

This is a simple Laravel-based Invoice API that allows users to manage customers, items, and invoices.
## Features

- **Customer Management**: Add, view, update, and delete customer information.
- **Item Management**: Add, view, update, and delete item information.
- **Invoice Management**: Create, view, update, and delete invoices. The system automatically updates item quantities and amounts upon invoice creation or modification.
- **User Authentication**: Register new users and authenticate them for secure access to the system.

- NB: All inputs are validated as well

## Getting Started

### Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) installed on your local machine.
- [Laravel](https://laravel.com/) installed on your local machine.
- [Composer](https://getcomposer.org/) installed on your local machine.

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/yourusername/Invoice_API.git
    ```

2. Navigate to the project directory:

    ```bash
    cd Invoice_API
    ```

3. Install dependencies:

    ```bash
    composer install
    ```

4. Copy the `.env.example` file to create a `.env` file:

    ```bash
    cp .env.example .env
    ```

5. Generate an application key:

    ```bash
    php artisan key:generate
    ```

6. Set up your database configuration in the `.env` file.

7. Run migrations to create the necessary database tables:

    ```bash
    php artisan migrate
    ```

8. Start the development server:

    ```bash
    php artisan serve
    ```

9. Access the application in your web browser at `http://localhost:8000`.

## API Endpoints

### Customers

- `GET /api/customers`: Retrieve all customers.
- `POST /api/customers`: Create a new customer.
- `GET /api/customers/{id}`: Retrieve a specific customer.
- `PUT /api/customers/{id}`: Update a customer.
- `DELETE /api/customers/{id}`: Delete a customer.

### Items

- `GET /api/items`: Retrieve all items.
- `POST /api/items`: Create a new item.
- `GET /api/items/{id}`: Retrieve a specific item.
- `PUT /api/items/{id}`: Update an item.
- `DELETE /api/items/{id}`: Delete an item.

### Invoices

- `GET /api/invoices`: Retrieve all invoices.
- `POST /api/invoices`: Create a new invoice.
- `GET /api/invoices/{id}`: Retrieve a specific invoice.
- `PUT /api/invoices/{id}`: Update an invoice.
- `DELETE /api/invoices/{id}`: Delete an invoice.

## User Authentication

- `POST /api/register`: Register a new user.
  - Request body:
    ```json
    {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "password123"
    }
    ```

- `POST /api/login`: Authenticate a user.
  - Request body:
    ```json
    {
      "email": "john@example.com",
      "password": "password123"
    }
    ```

## Testing

The project can be tested using [Postman](https://www.postman.com/) or Laravel's built-in PHPUnit. Examples and test scripts can be found in the `tests` directory.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
