# Agents

## Cursor Cloud specific instructions

### Overview

Bison is a Laravel 12 + Filament v4 admin panel starter framework. It uses MySQL 8.0, PHP 8.3, Node.js 22, and Tailwind CSS v3 (via Vite).

### Services

| Service | How to start | Port |
|---------|-------------|------|
| Laravel dev server | `php artisan serve --host=0.0.0.0 --port=8000` | 8000 |
| MySQL | `sudo mysqld_safe &` (wait ~5s for socket) | 3306 |

### Running the application

The `composer run dev` script starts the server, queue worker, log tail, and Vite concurrently. For cloud agents, it is simpler to start only what is needed:

```bash
# Start MySQL (if not already running)
sudo mysqld_safe &
sleep 3

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=8000
```

### Database

- MySQL 8.0 with database `laravel`, user `laravel`, password `laravel` on `127.0.0.1:3306`.
- `.env` must have `DB_HOST=127.0.0.1` (not `database`, which is the Lando container hostname).
- Session, cache, and queue all use the `database` driver by default.

### Linting

- `vendor/bin/pint --dirty` — Laravel Pint (code style)
- `vendor/bin/duster lint` — Duster (TLint + PHP_CodeSniffer + PHP CS Fixer + Pint)

### Testing

- `php artisan test` — Runs the Pest test suite against the configured MySQL database.
- Tests use `CACHE_STORE=array`, `SESSION_DRIVER=array`, `QUEUE_CONNECTION=sync`, and `MAIL_MAILER=array` (set in `phpunit.xml`).

### Creating a user

```bash
php artisan make:filament-user --name="Admin User" --email="admin@example.com" --password="password123" --no-interaction
```

### Gotchas

- The `.env.example` has `DB_HOST=database` (Lando hostname). For direct/cloud use, change to `127.0.0.1`.
- The `.env.example` uses `MAIL_MAILER=mailgun`. For local dev without Mailgun credentials, set to `log`.
- `npm run build` must be run before serving if Vite dev server is not active, otherwise a ViteException occurs.
- MySQL needs `sudo mysqld_safe &` with ~3s wait before it's ready (no systemd in this environment).
