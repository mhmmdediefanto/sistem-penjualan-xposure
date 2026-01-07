<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sistem Penjualan (Laravel 12)

Fitur utama yang disiapkan untuk studi kasus:
- Login & logout.
- Master data: Produk dan Pelanggan (CRUD sederhana).
- Transaksi penjualan: multi-produk per transaksi, stok berkurang, subtotal dan total otomatis.
- Dashboard ringkas: jumlah produk, pelanggan, transaksi, dan daftar transaksi terbaru.

### Prasyarat
- PHP 8.3+
- Composer
- Node.js & npm

### Cara Setup Cepat
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed   # akan menyiapkan user, produk, pelanggan sample
npm install
npm run build
php artisan serve
```

### Kredensial Default
- Admin: `admin@gmail.com` / `admin123`
- User: `testing@gmail.com` / `user123`

### Alur Pakai
1) Login ke aplikasi.
2) Atur master data: Produk & Pelanggan.
3) Buat transaksi: pilih pelanggan, tambah beberapa produk + qty, simpan. Stok otomatis berkurang.
4) Cek dashboard atau halaman transaksi untuk riwayat dan ringkasan item.

### Struktur Halaman
- `/login` – form login.
- `/dashboard` – ringkasan metrik & transaksi terbaru.
- `/products` – CRUD produk.
- `/pelanggans` – CRUD pelanggan.
- `/transactions` – daftar transaksi.
- `/transactions/create` – form transaksi baru.

### Testing Ringan
- Pastikan bisa login dengan kredensial default.
- Buat produk/pelanggan baru dan pastikan tampil di list.
- Buat transaksi dengan lebih dari satu produk; verifikasi stok berkurang sesuai qty.
