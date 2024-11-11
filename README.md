<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

<p align="center"><img width="371" height="58" src="https://github.com/laravel/jetstream/blob/5.x/art/logo.svg" alt="Logo Laravel Jetstream"></p>

<p align="center">
    <a href="https://github.com/laravel/jetstream/actions"><img src="https://github.com/laravel/jetstream/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/jetstream"><img src="https://img.shields.io/packagist/dt/laravel/jetstream" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/jetstream"><img src="https://img.shields.io/packagist/v/laravel/jetstream" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/jetstream"><img src="https://img.shields.io/packagist/l/laravel/jetstream" alt="License"></a>
</p>

---

<p align="center">
  <a href="https://tailwindcss.com" target="_blank">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/tailwindlabs/tailwindcss/HEAD/.github/logo-dark.svg">
      <source media="(prefers-color-scheme: light)" srcset="https://raw.githubusercontent.com/tailwindlabs/tailwindcss/HEAD/.github/logo-light.svg">
      <img alt="Tailwind CSS" src="https://raw.githubusercontent.com/tailwindlabs/tailwindcss/HEAD/.github/logo-light.svg" width="350" height="70" style="max-width: 100%;">
    </picture>
  </a>
</p>

<p align="center">
  A utility-first CSS framework for rapidly building custom user interfaces.
</p>

<p align="center">
    <a href="https://github.com/tailwindlabs/tailwindcss/actions"><img src="https://img.shields.io/github/actions/workflow/status/tailwindlabs/tailwindcss/ci.yml?branch=next" alt="Build Status"></a>
    <a href="https://www.npmjs.com/package/tailwindcss"><img src="https://img.shields.io/npm/dt/tailwindcss.svg" alt="Total Downloads"></a>
    <a href="https://github.com/tailwindcss/tailwindcss/releases"><img src="https://img.shields.io/npm/v/tailwindcss.svg" alt="Latest Release"></a>
    <a href="https://github.com/tailwindcss/tailwindcss/blob/master/LICENSE"><img src="https://img.shields.io/npm/l/tailwindcss.svg" alt="License"></a>
</p>

---

## About Apps

Aplikasi ini adalah sistem manajemen transaksi yang membantu pengguna untuk mencatat dan mengelola transaksi keuangan mereka dengan lebih efisien. Aplikasi ini dilengkapi dengan fitur-fitur berikut:

- Pencatatan Transaksi: Memungkinkan pengguna untuk mencatat transaksi dengan detail seperti kode, deskripsi, nilai tukar mata uang, dan tanggal pembayaran.
- Manajemen Kategori: Mendukung pengelompokan transaksi berdasarkan kategori, sehingga memudahkan pelacakan dan analisis keuangan.
- Penghitungan Total Otomatis: Menampilkan jumlah total dari nominal transaksi yang tercatat.
- Validasi Data Otomatis: Menjamin data yang dimasukkan pengguna lengkap dan valid sebelum disimpan.
- Recap Transaksi: Memungkinkan pengguna untuk merekap transaksi berdasarkan tanggal transaksi.

---

## Persyaratan

- PHP (Min PHP 8.2.12)
- Database MySQL
- Composer version 2.7.9
- Node.js (v20.15.0) dan npm (v10.9.0)
- Web server (misalnya, Apache atau Nginx)

## Instruksi Instalasi
1. Clone Repository
```bash
$ git clone https://github.com/RohmaRifqiPamungkas/Test_Tonjoo
```

2. Install Dependencies
```bash
$ composer install
$ npm install
$ npm run dev
```

3. Konfigurasi Aplikasi Salin file .env.example menjadi .env
```bash
$ cp .env.example .env
```

4. Atur variabel di file .env, terutama untuk koneksi database
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

5. Import file database (tonjoo.sql) ke http://localhost/phpmyadmin
```bash
http://localhost/phpmyadmin
```

6. Generate Application Key
```bash
$ php artisan key:generate
```

7. Jalankan Migrasi Laravel
```bash
$ php artisan migrate
$ php artisan migrate:fresh --seed --seeder=DatabaseSeeder 
```

8. Jalankan Server
```bash
$ php artisan serve
$ npm run dev
```

9. Akses Aplikasi
```bash
http://localhost:8000
```

10. Buka Browser 
```bash
http://127.0.0.1:8000/login
http://127.0.0.1:8000/register
```

11. Login atau Register dengan akun berikut
```bash
username : test@example.com
password : password
```

## Link Demo

http://test-tonjoo.temukreatif.id/

## Screenshoot Project

## Home Page
![image](https://github.com/user-attachments/assets/385849a7-668e-417e-a3f8-213c999faaf0)

## List Transactions Page
![image](https://github.com/user-attachments/assets/950c32d5-1b89-4a21-9fd6-6b4f324257e1)

## Create Transactions Page
![image](https://github.com/user-attachments/assets/b4051c6e-fd0a-4cf8-8fd8-6c54f657c7e8)

## Edit Transactions Page
![image](https://github.com/user-attachments/assets/1ee36627-7b06-4691-b52a-d210a85b8400)

## View Transactions Page
![image](https://github.com/user-attachments/assets/7a212675-783c-4078-9cc8-05b0b0b65d8f)

## Recap Transactions Page
![image](https://github.com/user-attachments/assets/2570b066-a227-4ea3-9b84-51aa8f7e8a33)

## Fibonasi Page
![image](https://github.com/user-attachments/assets/a3ca7340-816c-4225-8eb4-19de76d23829)

## Validation Create
![image](https://github.com/user-attachments/assets/befabef3-a40a-41a5-9b44-aab153c92edc)

## Validation Edit
![image](https://github.com/user-attachments/assets/5c2574e1-19be-4797-be57-28af36b56c8f)