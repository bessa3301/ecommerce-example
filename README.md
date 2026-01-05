# E-commerce Demo Application

A simple e-commerce demo application built to showcase development skills. This project is designed as a portfolio piece for recruiters and is intentionally kept basic and straightforward.

## ⚠️ Important Note

This is a **demo application** and is **not intended to be a complete or complex solution**. The focus is on demonstrating clean code, modern development practices, and a working prototype rather than production-ready features.

The user interface has been designed with functionality and usability as primary considerations, prioritizing practical implementation over aesthetic refinement. As such, there is considerable potential for visual and interactive enhancements.

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Vue.js + TailwindCSS
- **Architecture**: Simple and straightforward

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- Docker (optional, if using the provided docker-compose setup)
- Kool CLI (visit https://kool.dev for more details)

### Installation

1. Clone the repository
2. Install PHP dependencies:
   ```bash
   kool run composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   kool run npm install
   ```

4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   kool run artisan key:generate
   ```

6. Run database migrations:
   ```bash
   kool run artisan migrate
   ```

7. Build frontend assets:
   ```bash
   kool run npm run build
   ```

8. Start the development server:
   ```bash
   kool start
   ```

### Using Docker

If you prefer using Docker, you can use the provided `docker-compose.yml` and `kool.yml` configuration files.

## Development

- Backend API: Laravel 12
- Frontend: Vue.js with TailwindCSS for styling
- Frontend dev server: `npm run dev`

## CI/CD

The continuous integration pipeline has been intentionally streamlined to utilize PHPStan for static analysis. While this approach maintains simplicity and focus, alternative tooling options are available, such as those demonstrated in the [phpqa](https://github.com/jakzal/phpqa) public repository, which could be integrated for more comprehensive code quality assurance.

## Media Assets

The video assets incorporated into this project were sourced from non-commercial free stock footage and subsequently converted to the WebP format to optimize performance and ensure efficient delivery.

## License

This is a demo project for portfolio purposes.

