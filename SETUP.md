## Prerequisites

Pastikan sudah terinstal:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **MySQL** >= 8.x (bisa menggunakan MySQL bawaan Herd, XAMPP, Laragon, atau standalone)
- **Node.js** >= 18.x & **NPM** (opsional, jika ingin compile assets)
- **Laravel Herd** (recommended) atau `php artisan serve`


## Langkah Instalasi

# 1. Clone Repository

```bash
git clone <repository-url> financial-management
cd financial-management
```

# 2. Install Dependencies (Composer)

```bash
composer install
```

# 3. Setup Environment File

```bash
cp .env.example .env
php artisan key:generate
```

# 4. Konfigurasi Database

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=financial_management
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:**
- Jika menggunakan **Herd** dengan MySQL bawaan, port default biasanya `3307`
- Jika menggunakan **XAMPP/Laragon**, port default biasanya `3306`
- Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan kredensial MySQL Anda

# 5. Buat Database

Buat database `financial_management` melalui MySQL client:

**Via Terminal:**
```bash
mysql -u root -p -e "CREATE DATABASE financial_management;"
```

**Via TablePlus/phpMyAdmin:**
Buat database baru dengan nama `financial_management`, charset `utf8mb4`.

# 6. Jalankan Migration

```bash
php artisan migrate
```

# 7. Jalankan Seeder

```bash
php artisan db:seed
```

Atau migration + seeder sekaligus:
```bash
php artisan migrate:fresh --seed
```

**Catatan:**
- Seeder akan mengisi tabel `categories` dengan data kategori default (Gaji, Makanan, Transportasi, dll).

# 8. Dump Autoload (jika diperlukan)

```bash
composer dump-autoload
```

## Menjalankan Aplikasi

# Opsi A: Menggunakan Laravel Herd (Recommended)

1. Pastikan **Herd** sudah running
2. Buka folder project di Herd Sites (default: `~/Herd/`)
3. Akses di browser: **http://financial-management.test**


# Opsi B: Menggunakan Artisan Serve

```bash
php artisan serve
```

Akses di browser: **http://localhost:8000**

---

## Struktur Utama Project

```
app/
├── Helpers/              # Global helper functions
├── Http/
│   ├── Controllers/      # Controller
│   └── Requests/         # Form Request validation
├── Models/               # Eloquent models + traits
├── Repositories/         # Database access layer
├── Services/             # Business logic
└── Traits/               # ResultService, ExceptionCustom, Response

public/
├── js/
│   ├── common.js         # Global JS utilities
│   └── transactions/
│       └── index.js      # Transaction page JS

resources/views/
├── layouts/app.blade.php # Main layout
└── transactions/
    └── index.blade.php   # Transaction page

routes/web.php            # Route definitions
```

## Tech Stack

| Teknologi | Versi/Detail |
|-----------|-------------|
| PHP | >= 8.2 |
| Laravel | 12.x |
| MySQL | 8.x |
| Bootstrap | 5.3 (CDN) |
| jQuery | 3.7 (CDN) |
| DataTables | Yajra (server-side) |
| SweetAlert2 | CDN |


## Troubleshooting

# Migration gagal: "SQLSTATE[HY000] [2002] Connection refused"
- Pastikan MySQL sudah running
- Cek port di `.env` sesuai dengan MySQL Anda (`3306` atau `3307`)

# "Class not found" error
```bash
composer dump-autoload
```

# Halaman blank / 500 error
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

# DataTable tidak muncul / error
- Pastikan sudah menjalankan `composer install` (Yajra DataTables terinstal via Composer)
- Cek Console browser untuk error JavaScript

Jika ada kendala teknis saat setup, hubungi tim yang memberikan test ini.
