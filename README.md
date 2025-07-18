:

<h1>
    📦 Laravel Purchasing System - Internal Finance Tools
Aplikasi Purchasing ini dibuat berdasarkan kebutuhan dan permintaan dari tim manajemen finance di kantor kami. Sistem ini dibangun menggunakan Laravel dan Filament, dan dirancang untuk memudahkan proses pengadaan barang/jasa secara terstruktur dan terdokumentasi.
</h1>

<h2>
✨ Fitur Utama
Aplikasi ini terdiri dari beberapa modul penting, yaitu:
</h2>

<str>✅ Purchase Request (PR)</str>
Pengajuan permintaan pembelian barang/jasa oleh user internal.

<str>📝 Purchase Order (PO)</str>
Proses persetujuan dan pembuatan dokumen pemesanan barang kepada vendor.

<str>📄 SP3 (Surat Perintah Pembayaran/Pengadaan/Pekerjaan)</str>
Dokumen finalisasi sebagai dasar pembayaran atau realisasi pekerjaan.

🛠️ Tech Stack
Laravel 11

Filament Admin Panel

PHP 8+

TailwindCSS

MySQL/MariaDB

Node.js (untuk frontend assets)

🚀 Cara Install & Menjalankan Project
Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini secara lokal:

1. Clone Repository
bash
Salin
Edit
git clone https://github.com/tongoyy/cms.git
cd cms
2. Hapus file composer.lock
bash
Salin
Edit
rm composer.lock
3. Install Dependensi Backend
bash
Salin
Edit
composer install
4. Install Dependensi Frontend
bash
Salin
Edit
npm install
5. Generate Key Aplikasi
bash
Salin
Edit
php artisan key:generate
6. Jalankan Migrasi Database
Catatan: Pastikan database sudah dikonfigurasi di .env

bash
Salin
Edit
php artisan migrate
7. Jalankan Server Laravel
bash
Salin
Edit
php artisan serve
Akses aplikasi di: http://localhost:8000

📂 Struktur Folder Penting
app/Filament/Resources — Berisi definisi halaman Filament untuk PR, PO, dan SP3.

database/migrations — Berisi skema database untuk masing-masing entitas.

routes/web.php — Rute utama aplikasi.

.env.example — Template konfigurasi environment.

👨‍💼 Kontribusi & Dukungan
Saat ini project ini bersifat internal dan dikembangkan untuk keperluan kantor. Namun, jika kamu punya saran atau ingin diskusi lebih lanjut, silakan buat issue atau pull request.

