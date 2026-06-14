# Sistem Informasi Reservasi Kamar Rusunawa (SIRKA)

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Status](https://img.shields.io/badge/Status-Development-success?style=for-the-badge)

## 📖 Tentang Sistem

**SIRKA (Sistem Informasi Reservasi Kamar Rusunawa)** merupakan aplikasi berbasis web yang dikembangkan untuk mendukung proses reservasi hunian mahasiswa pada Rusunawa Universitas Diponegoro secara digital, terintegrasi, dan transparan.

Sistem ini dirancang untuk menggantikan proses pendaftaran manual yang sebelumnya dilakukan melalui formulir dan verifikasi berkas secara konvensional. Dengan adanya SIRKA, mahasiswa dapat melakukan reservasi kamar, mengunggah dokumen persyaratan, memantau status pengajuan, hingga melakukan pembayaran secara lebih efektif dan efisien.

## 🚀 Instalasi

### Clone Repository

```bash
git clone https://github.com/username/sirka-rusunawa-undip.git
cd sirka-rusunawa-undip
```

### Install Dependency

```bash
composer install
npm install
```

### Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### Konfigurasi Database

Edit file `.env`

### Migrasi dan Seeder

```bash
php artisan migrate --seed
```

### Menjalankan Aplikasi

```bash
php artisan serve
npm run dev
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```
