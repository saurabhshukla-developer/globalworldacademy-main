# Global World Academy (Laravel) — Go-Live / Production Deployment Guide

This project is a **Laravel 13** app (PHP **8.3+**) with a **Vite** build for frontend assets. It uses database-backed **sessions/cache/queue** by default (see `.env.example`).

---

## 1) Server requirements

- **PHP**: 8.3+
  - Extensions typically required: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`
- **Composer**: latest v2
- **Node.js**: 18+ (recommended 20 LTS) + npm
- **Database**: MySQL/MariaDB (recommended) or SQLite
- **Web server**: Nginx or Apache

---

## 2) Project install (first-time)

From your server, in your web root (or deploy directory):

```bash
git clone <your-repo-url> globalworldacademy
cd globalworldacademy
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

Copy environment file and generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

---

## 3) Configure `.env` for production

Open `.env` and set at minimum:

- **App**
  - `APP_NAME="Global World Academy"`
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL=https://your-domain.com`
  - `APP_LOCALE=en` (Hindi is supported via `?lang=hi`)

- **Database**
  - If using MySQL:
    - `DB_CONNECTION=mysql`
    - `DB_HOST=127.0.0.1`
    - `DB_PORT=3306`
    - `DB_DATABASE=...`
    - `DB_USERNAME=...`
    - `DB_PASSWORD=...`

- **Storage (course images)**
  - Course images are stored on the **public** disk and served via `/storage/...`
  - Ensure `APP_URL` is correct, because `public` disk URLs use it (`config/filesystems.php`)

- **Sessions/Cache/Queue**
  - Default `.env.example` uses:
    - `SESSION_DRIVER=database`
    - `CACHE_STORE=database`
    - `QUEUE_CONNECTION=database`
  - That’s fine for production, but make sure your database is configured and migrations run.

---

## 4) File permissions

Laravel must be able to write to:

- `storage/`
- `bootstrap/cache/`

Common Linux example:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## 5) Database migrations + seeders (IMPORTANT)

Run migrations:

```bash
php artisan migrate --force
```

Seed the core site/admin content:

```bash
php artisan db:seed --force
```

Also seed **Quiz Categories & Topics** (this seeder is not part of `DatabaseSeeder` in this repo):

```bash
php artisan db:seed --class=QuizCategoryTopicSeeder --force
```

### What gets created by seeders

- **Admin user** (from `database/seeders/AdminUserSeeder.php`)
  - Email: `admin@globalworldacademy.com`
  - Password: `Admin@12345`
- **Site settings** (`SiteSettingSeeder`)
- **Quiz questions** (`QuizQuestionSeeder`)
- **Courses** (`CourseSeeder`)
- **Study materials** (`MaterialSeeder`)
- **Quiz categories & topics + backfill** (`QuizCategoryTopicSeeder`)

> If you want one single seeding command in production, you can later add `QuizCategoryTopicSeeder::class` into `DatabaseSeeder` and just run `php artisan db:seed --force`.

---

## 6) Storage symlink (for uploaded course images)

Create the public storage symlink:

```bash
php artisan storage:link
```

This creates:

- `public/storage` → `storage/app/public`

Uploaded course images will appear at:

- `https://your-domain.com/storage/courses/<filename>`

---

## 7) Optimize caches for production

After `.env` is final and migrations are done:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If anything looks “stuck” after updates, you can clear caches:

```bash
php artisan optimize:clear
```

---

## 8) Queue worker (if using database queue)

Because `.env.example` sets `QUEUE_CONNECTION=database`, run a queue worker in production using Supervisor / systemd:

Basic test run (not recommended for long-term):

```bash
php artisan queue:work --tries=3
```

If you are **not using queues**, you can set:

```env
QUEUE_CONNECTION=sync
```

---

## 9) Web server configuration

### Nginx (recommended)

- Set the document root to the **`public/`** folder.
- Ensure PHP-FPM is configured.

Example (simplified):

```nginx
server {
    server_name your-domain.com;
    root /var/www/globalworldacademy/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }

    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|webp)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }
}
```

### Apache

Ensure the vhost points to `public/` and `mod_rewrite` is enabled.

---

## 10) Smoke test checklist (after go-live)

- Public pages
  - Home: `GET /`
  - Quiz: `GET /quiz`
  - Switch language:
    - `/?lang=hi` (Hindi)
    - `/?lang=en` (English)

- Admin
  - Login: `GET /admin/login`
  - Dashboard: `GET /admin`
  - Manage:
    - Quiz Categories: `/admin/quiz-categories`
    - Quiz Topics: `/admin/quiz-topics`
    - Quiz Questions: `/admin/quiz`
    - Courses (image upload): `/admin/courses`

- Upload test
  - Upload a course image in admin
  - Confirm it renders on the homepage course cards
  - Confirm the URL works under `/storage/courses/...`

---

## 11) Common deployment commands (updates)

When you pull new code:

```bash
git pull
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan optimize
```

If you changed translations or Blade templates:

```bash
php artisan view:cache
```

