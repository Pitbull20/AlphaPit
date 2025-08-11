# AlphaPit Documentation

This document explains how to run the sample project and how the framework pieces fit together.

## Requirements
- PHP 8.1 or higher with PDO extension
- MySQL database server
- Composer is not required; all classes use a simple autoloader

## Quick start
1. **Clone the repository**
   ```bash
   git clone https://example.com/AlphaPit.git
   cd AlphaPit
   ```
2. **Configure the database**
   Edit `project/public/index.php` and adjust the `$config` array with your MySQL credentials.
3. **Launch the development server**
   ```bash
   php alpha.php serve
   ```
   This starts PHP's built-in server at `http://localhost:8000` serving the `project/public` directory.
4. **Open the app**
   Visit `http://localhost:8000` in your browser. The `/users` endpoint returns JSON data from the database.

## Directory structure
```
framework/   # Core framework classes
project/     # Example application using the framework
  public/    # Entry point for web requests
  src/       # Application modules, controllers, services and entities
  views/     # PHP templates used by controllers
alpha.php    # CLI tool for running the server and generating code
```

## How it works
1. `project/public/index.php` bootstraps the framework. It sets up the service container, registers modules and hands control to the router.
2. Modules extend `AlphaPit\Module` and can import other modules. Controllers inside a module use PHP 8 attributes `#[Route]` to define routes.
3. The `Router` matches incoming requests, instantiates the controller and executes the action. Route parameters are not yet supported.
4. Entities extend `AlphaPit\Entity` and use PDO for database access. Services encapsulate business logic and are automatically injected into controllers.

## CLI usage
The `alpha.php` script provides helper commands:
- `php alpha.php serve [host:port]` – run the development server.
- `php alpha.php g module <Name>` – generate a module skeleton.
- `php alpha.php g controller <Module> <Name>` – generate a controller inside a module.
- `php alpha.php g service <Module> <Name>` – generate a service class.
- `php alpha.php g entity <Module> <Name>` – generate an entity class linked to a database table.

## Next steps
- Add more routes and templates inside `project` to build your application.
- Extend the framework with middleware, parameterized routes or different database backends as needed.
