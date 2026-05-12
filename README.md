# Pooling Fund - KSO Laravel

Versi Laravel Blade dari aplikasi Next.js `1.Sarsa-Nextjs`.

## Jalankan Lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Deploy cPanel

1. Upload isi folder ini ke hosting, misalnya `~/cea-laravel`.
2. Arahkan document root domain ke folder `~/cea-laravel/public`.
3. Jalankan:

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan config:cache
php artisan route:cache
```

4. Pastikan folder `storage` dan `bootstrap/cache` writable.

Konten menu dan blog ada di `config/cea.php`.
