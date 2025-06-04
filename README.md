# AlphaPit

AlphaPit is a tiny PHP framework that provides a minimal router and lightweight ORM. It is intended as a learning tool or starting point for small projects.

## Getting started

1. Clone the repository.
2. Configure your database credentials in `project/public/index.php`.
3. Point your web server document root to the `project/public` directory.
4. Open your browser and navigate to `/` to see the welcome page.

## Directory structure

- `framework/` - framework core classes
- `project/` - sample project using the framework
  - `public/` - entry point for all requests
  - `views/` - simple PHP templates

## Example routes

The `project/public/index.php` file registers two routes:

- `/` - renders the `project/views/home.php` template.
- `/users` - returns all records from the `users` table in JSON format.

## License

This project is released under the MIT License.
