# Fitlife (Laravel + Flutter Backend)

Repository ini berisi source code backend untuk aplikasi Fitlife, dibangun menggunakan Laravel, Vite, dan Tailwind CSS.

## 📋 Prasyarat (Requirements)

Pastikan di komputer Anda sudah terinstall:

- PHP >= 8.3
- Composer
- Node.js & NPM (untuk Vite & Tailwind)
- Database (MySQL / Oracle / PostgreSQL)

## 🚀 Panduan Instalasi (Getting Started)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda.

### 1. Clone Repository & Install Dependencies Backend

Masuk ke terminal dan jalankan perintah berikut:

```bash
# Clone repo (jika belum)
git clone https://github.com/madSobirin/proyek_2.git
cd fitlife

# Install paket PHP (Laravel)
composer install

pnpm install

# instal node js
pnpm run dev / pnpm dev

cp .env.example .env

php artisan key:generate

php artisan storage:link / php artisan link:generate

```
