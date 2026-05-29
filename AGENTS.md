# CalendarStorm — Agent Guidance

## Repository structure
- **Backend**: Laravel 11 (PHP 8.1+) at root, vendor deps for frameworks
- **Frontend**: TypeScript + Alpine.js via Vite; entrypoints are `resources/sass/app.scss` and `resources/ts/app.ts`
- **App code**: `app/` (PSR-4 autoloaded)
- **Tests**: `tests/Unit/` and `tests/Feature/`

## Commands
| Goal | Command |
|------|---------|
| Start dev server | `composer run dev` |
| Build assets | `composer run build` |
| Run all tests | `php vendor/bin/phpunit` |
| Run a single test | `php vendor/bin/phpunit tests/Path/To/Test.php --filter=methodName` |
| Generate helpers | `php artisan ide-helper:generate` |

## Environment setup
1. `composer install`
2. Copy env: `cp .env.example .env || ([ -f .env ] || cp .env.example .env)`
3. Generate key: `php artisan key:generate`
4. Publish assets: `php artisan vendor:publish --tag=laravel-assets`
5. Run migrations: `php artisan migrate --env=testing` (for test env)

## Testing gotchas
- `phpunit.xml` sets `APP_ENV=testing`, `CACHE_DRIVER=array`, `SESSION_DRIVER=array`, `QUEUE_CONNECTION=sync`
- Disable Telescope in tests: it is excluded via `extra.dont-discover` in composer.json
- Use `--env=testing` for migrations to create the testing database

## Frontend workflow
Vite builds both SASS and TS; ensure `resources/ts/**/*.ts` and `resources/ts/app.ts` are the compiled sources. Tailwind config is at `tailwind.config.js`.

## Laravel-specific
- Use `/api` for API routes (defined in `routes/api/web.php`)
- Use `/` (public/index.php) for web routes (`routes/web.php`)
- Broadcasting uses Laravel Reverb (config in `config/broadcasting.php`)
