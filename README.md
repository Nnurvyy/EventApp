# 📅✨ EventApp - Cute & Premium Event Platform ✨📅

Selamat datang di **EventApp**, platform manajemen dan pendaftaran acara (event) yang dikemas dengan desain visual **Neo-brutalist & Glassmorphism** yang super imut, responsif, dan premium! 🌸✨

🚀 **Tautan Hosting Deployed:** [https://event-app.infinityfree.io](https://event-app.infinityfree.io)

---

## 🔑 Akun Demo Pengujian (Demo Accounts)

Untuk mempermudah pengujian oleh penguji/reviewer, berikut adalah akun demo yang dapat langsung digunakan untuk masuk ke dalam sistem:

| Peran (Role) | Alamat Email | Kata Sandi (Password) | Deskripsi Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@eventapp.com` | `password` | Akses penuh dashboard admin, kelola event (CRUD), kelola user (CRUD), & pantau pemasukan tiket. |
| **Regular User** | `user@eventapp.com` | `password` | Melihat katalog, melakukan pendaftaran event (berbayar/gratis), simulasi Midtrans, & ubah profil. |

*(Selain menggunakan akun di atas, Anda juga dapat menggunakan tombol **Sign in with Google** untuk masuk secara instan).*

---

## 🌟 Fitur-Fitur Unggulan

Aplikasi ini dilengkapi berbagai fitur modern:

### 🔑 1. Login with Google (OAuth)
* Masuk ke aplikasi secara instan hanya dengan sekali klik menggunakan akun Google Anda!
* Sistem otomatis membuat akun baru dan mensinkronisasikan nama, email, serta foto profil Google Anda ke database.

### 💳 2. Midtrans Payment Gateway
* Integrasi pembayaran online yang aman dan terpercaya melalui **Midtrans Snap**.
* Pengguna dapat mendaftar ke acara berbayar dan melakukan pembayaran menggunakan berbagai metode (E-Wallet seperti GoPay/ShopeePay, Transfer Bank/VA, dll.).
* Menggunakan **Webhook Callback** otomatis untuk mengubah status pembayaran dari `pending` menjadi `confirmed` secara *real-time* begitu transaksi sukses.

### ✉️ 3. Notifikasi Tiket via Email (SMTP)
* Setiap kali pendaftaran sukses (baik gratis maupun setelah pembayaran Midtrans selesai), sistem akan mengirimkan e-ticket konfirmasi secara otomatis ke email pengguna.

> [!IMPORTANT]
> ### 📧 Mengapa Email Masuk ke Folder Spam?
> Karena email otomatis dikirim dari server hosting bersama, beberapa penyedia email (seperti Gmail/Yahoo) mendeteksinya sebagai email promosi otomatis dan memasukkannya ke folder **Spam**.
> 
> **Cara Mengatasinya Agar Masuk Inbox Utama:**
> 1. Buka folder **Spam** di Gmail/aplikasi email Anda.
> 2. Cari email masuk dari **EventApp**.
> 3. Buka email tersebut, lalu klik tombol **"Report not spam"** (Laporkan bukan spam) atau **"Pindahkan ke Inbox"**.
> 4. Tambahkan alamat email pengirim tersebut ke dalam daftar **Kontak** Anda.
> 5. Setelah itu, semua email tiket pendaftaran Anda berikutnya akan langsung masuk ke **Kotak Masuk (Primary Inbox) Utama**! 🎉

### 👤 4. Profil Pengguna & Avatar Hewan Lucu 🐱🐸🐹
* Pengguna dan Admin dapat mengubah foto profil secara manual dengan fitur unggah berkas (disertai preview gambar instan menggunakan Alpine.js).
* **Fitur Fallback Unik**: Jika pengguna tidak memiliki foto profil (dan tidak menggunakan Google Sign-In), sistem akan otomatis membuatkan avatar hewan lucu (seperti Kucing 🐱, Katak 🐸, Beruang 🐻, Kelinci 🐰, Koala 🐨, Panda 🐼, dll.) secara acak berdasarkan ID unik pengguna.
* *Catatan Penting: Tidak ada ikon anjing 🐶 sesuai instruksi kesayangan pemilik aplikasi.*

### 🖥️ 5. Dashboard Interaktif (Admin & User)
* **Aesthetic User Dashboard**:
  * Katalog Acara (Event Catalog) interaktif dengan fitur pencarian dan pengurutan dinamis.
  * Halaman "Acara yang Diikuti" untuk melacak status pendaftaran dan tiket.
  * Manajemen Profil yang rapi dan responsif.
* **Aesthetic Admin Dashboard**:
  * **Manajemen Event (CRUD)**: Kelola acara baru, unggah pamflet/foto event, deskripsi, tanggal, dan harga tiket.
  * **Manajemen User (CRUD)**: Kelola data pengguna, hak akses (User/Admin), serta pembuatan akun manual.
  * **Manajemen Transaksi**: Pantau total pendapatan kotor dari pendaftaran berbayar, filter berdasarkan status transaksi, dan hapus transaksi.

### 📱 6. Desain Neo-Brutalist & 100% Responsif
* Desain visual modern berciri khas border tebal hitam, drop shadow dinamis, gradasi warna harmonis (HSL), dan micro-animations premium.
* Responsif di segala perangkat (HP, Tablet, iPad, maupun PC Desktop) dengan margin dan padding yang pas di mata.

---

## 🛠️ Cara Menjalankan Aplikasi Secara Lokal (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di komputer lokal Anda:

### **Prasyarat Sistem**
* PHP versi `>= 8.2` (Proyek ini dikunci ke PHP `8.3` agar kompatibel dengan server hosting)
* Composer
* Node.js & NPM
* Database MySQL/MariaDB

### **Langkah-Langkah Instalasi**

**1. Clone Proyek**
```bash
git clone <url-repository-anda>
cd eventapp
```

**2. Instal Dependensi PHP (Composer)**
```bash
composer install
```

**3. Instal Dependensi Frontend (NPM)**
```bash
npm install
```

**4. Konfigurasi Environment File**
* Duplikat file `.env.example` dan ubah namanya menjadi `.env`:
```bash
copy .env.example .env
```
* Buka file `.env` dan sesuaikan koneksi database lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_lokal
DB_USERNAME=root
DB_PASSWORD=
```
* Sesuaikan juga konfigurasi Google Client ID, Midtrans, dan SMTP Mailer Anda di dalam `.env`.

**5. Generate Application Key**
```bash
php artisan key:generate
```

**6. Jalankan Migrasi Database beserta Seeder**
```bash
php artisan migrate --seed
```
*(Seeder akan otomatis membuat akun Admin bawaan untuk login pertama kali)*

**7. Hubungkan Tautan Storage Publik**
```bash
php artisan storage:link
```

**8. Jalankan Server Lokal**
Buka terminal dan jalankan server PHP beserta Vite Asset Bundler secara bersamaan:
```bash
composer run dev
```
Atau Anda dapat menjalankannya di dua terminal terpisah:
* Terminal 1: `php artisan serve`
* Terminal 2: `npm run dev`

Buka browser Anda dan akses halaman web lokal di: `http://localhost:8000` 🎈

---

## ☁️ Catatan Konfigurasi Deployment (InfinityFree)

Demi mengatasi batasan keamanan gratis seperti **`open_basedir restriction`** dan penonaktifkan fungsi **`symlink()`** pada InfinityFree, struktur proyek di hosting disesuaikan sebagai berikut:

* **Struktur Folder:**
  ```text
  /htdocs
  ├── laravel-core/         <-- Berisi semua file core Laravel (app, config, vendor, dll.)
  ├── build/                <-- Aset CSS & JS hasil compile NPM
  ├── index.php             <-- File index publik yang diarahkan ke laravel-core
  └── storage/              <-- Folder upload publik fisik (bukan symlink)
  ```
* **Bypass Symlink:** Jalur root pada disk `'public'` di `config/filesystems.php` dialihkan langsung ke `public_path('storage')` sehingga Laravel mengunggah gambar langsung ke `/htdocs/storage` agar bisa dibaca langsung oleh browser secara instan.

---

Selamat menjelajahi **EventApp**! Semoga aplikasi manajemen acara imut ini bermanfaat untuk Anda! 📅✨💕
