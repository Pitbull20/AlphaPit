# AlphaPit

AlphaPit is a tiny PHP framework that provides a minimal router and lightweight ORM. It is intended as a learning tool or starting point for small projects.

## Getting started

1. Clone the repository.
2. Configure your database credentials in `public/index.php`.
3. Point your web server document root to the `public` directory.
4. Open your browser and navigate to `/` to see the welcome page.

## Directory structure

- `public/` - entry point for all requests
- `src/` - framework core classes
- `views/` - simple PHP templates

## Example routes

The `public/index.php` file registers two routes:

- `/` - renders the `views/home.php` template.
- `/users` - returns all records from the `users` table in JSON format.

## License

This project is released under the MIT License.
