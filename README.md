# Aplikasi Pendaftaran Beasiswa berbasis WEB

Aplikasi berbasis web untuk memfasilitasi proses publikasi informasi beasiswa, pendaftaran beasiswa oleh mahasiswa, verifikasi berkas persyaratan oleh pihak Biro Administrasi Akademik dan Kemahasiswaan (BAAK), pencetakan laporan PDF, serta pengelolaan data master oleh Super Admin di lingkungan **Universitas Kuningan (UNIKU)**.

---

## 1. Informasi Proyek & URL

- **URL Aplikasi Aktif:** [https://firmanz.site.je](https://firmanz.site.je)
- **URL Repository Git:** [https://github.com/Firs-Bot/Aplikasi-Pendaftaran-Beasiswa_Laravel.git](https://github.com/Firs-Bot/Aplikasi-Pendaftaran-Beasiswa_Laravel.git)

---

## 2. Fitur Utama

1. **Registrasi & Autentikasi Multi-Peran:**
   - **Validasi NIM Akademik:** Registrasi akun mahasiswa memvalidasi NIM terhadap tabel data akademik kampus (`master_mahasiswas`).
   - **Pemisahan Portal Login:** Halaman login khusus Mahasiswa (`/login`) dan halaman login khusus Staf BAAK / Super Admin (`/admin-login`).
2. **Pengelolaan Data (CRUD) Berbasis Peran:**
   - **Mahasiswa:**
     - Melihat daftar program beasiswa yang sedang dibuka dan pengumuman terbaru.
     - Mengajukan pendaftaran beasiswa beserta unggah 7 berkas persyaratan berformat PDF (SKTM, Transkrip Nilai, Surat Aktif Kuliah, KTP, KTM, KRS, dan Surat Pernyataan Tidak Menerima Beasiswa Lain).
     - Memantau status verifikasi (`MENUNGGU`, `SEDANG DITINJAU`, `LOLOS`, `DITOLAK`) dan memperbarui data/berkas selama status masih `MENUNGGU`.
   - **BAAK:**
     - Dashboard statistik pendaftaran (total beasiswa, total pendaftar, menunggu verifikasi, dan pendaftar lolos).
     - CRUD program beasiswa beserta poster/banner.
     - CRUD pengumuman beasiswa.
     - Peninjauan dokumen persyaratan pendaftar dan penetapan status verifikasi (`SEDANG DITINJAU`, `LOLOS`, `DITOLAK`).
   - **Super Admin:**
     - Dashboard ringkasan seluruh entitas sistem.
     - Pengelolaan penuh (lihat, cari, filter, ubah, hapus) untuk data Pengguna, Beasiswa, Pengumuman, dan Pendaftaran.
3. **Laporan & Ekspor Data:**
   - Rekapitulasi data pendaftar beasiswa dengan filter berdasarkan status verifikasi.
   - **Ekspor PDF (`A4 Landscape`):** Pencetakan laporan daftar pendaftar beasiswa menggunakan `barryvdh/laravel-dompdf` pada modul BAAK (`/baak/pendaftaran/pdf`).

---

## 3. Teknologi yang Digunakan

- **Backend:** PHP 8.2+, Laravel Framework 12.x
- **Frontend:** Laravel Blade, Tailwind CSS 3, Alpine.js 3, Vite 7
- **Database:** MySQL / MariaDB
- **Generator Laporan PDF:** `barryvdh/laravel-dompdf` (DomPDF 3.1)

---

## 4. Penerapan Keamanan

1. **Hashing & Kebijakan Password:**
   - Password disimpan menggunakan algoritma hashing **`bcrypt`** (`BCRYPT_ROUNDS=12`) melalui `Hash::make()` dan cast model `'password' => 'hashed'`.
   - Kebijakan password minimum 8 karakter dengan kombinasi huruf dan angka (`Password::min(8)->letters()->numbers()`).
2. **Pencegahan SQL Injection & Cross-Site Scripting (XSS):**
   - Seluruh interaksi database menggunakan **Eloquent ORM** dengan parameter binding serta escaping karakter wildcard (`%`, `_`) pada fitur pencarian.
   - Seluruh output pada template Blade di-escape otomatis menggunakan `{{ ... }}`, data ke atribut Alpine.js di-serialize dengan `@js(...)`, parameter URL pada `fetch` menggunakan `encodeURIComponent()`, serta input teks disanitasi dengan `strip_tags()` dan aturan validasi ketat (tipe, panjang maksimum, whitelist `in:...`, dan MIME berkas).
3. **Manajemen Sesi & Cookie Aman:**
   - Sesi disimpan di database dengan enkripsi payload aktif (`SESSION_ENCRYPT=true`).
   - Cookie sesi dikonfigurasi dengan atribut **`HttpOnly=true`**, **`Secure=true`**, dan **`SameSite=lax`**, disertai regenerasi ID sesi saat login (`session()->regenerate()`) serta invalidasi sesi dan token saat logout (`session()->invalidate()` & `regenerateToken()`).
4. **Kontrol Akses Berbasis Peran (RBAC) & Anti-IDOR:**
   - Otorisasi berbasis `Gate` dan middleware rute (`can:admin`, `can:baak`, `can:mahasiswa`).
   - Berkas persyaratan mahasiswa (KTP, KTM, KRS, SKTM, Transkrip) disimpan pada storage privat (`local` disk) dan hanya dapat diakses melalui endpoint terproteksi `/pendaftaran/{pendaftaran}/dokumen/{jenis}` yang memverifikasi kepemilikan (`user_id === auth()->id()`) atau peran `baak`/`admin`.
   - Validasi server-side untuk mencegah mahasiswa mengubah data pendaftaran yang sudah berstatus selain `MENUNGGU` maupun memalsukan identitas `nim`/`nama_lengkap` pada saat pengajuan.
5. **Keamanan Tambahan:**
   - **CSRF Protection:** Token `@csrf` diterapkan pada seluruh form state-changing (`POST`, `PUT`, `PATCH`, `DELETE`).
   - **Rate Limiting:** Pembatasan percobaan pada endpoint login (`LoginRequest` 5 percobaan gagal & middleware `throttle:10,1`), registrasi (`throttle:6,1`), serta API pengecekan NIM (`throttle:10,1`).
   - **Log Aktivitas (Audit Trail):** Pencatatan aktivitas autentikasi (login berhasil/gagal, logout, registrasi), perubahan data CRUD/verifikasi, dan percobaan akses dokumen tidak sah (IDOR) ke `storage/logs/laravel.log`.

---

## 5. Cara Instalasi dan Menjalankan Secara Lokal

### Prasyarat
- PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`/`dom`)
- Composer
- Node.js & NPM
- MySQL / MariaDB (misalnya melalui XAMPP)

### Langkah Instalasi
1. **Clone repository:**
   ```bash
   git clone https://github.com/Firs-Bot/Aplikasi-Pendaftaran-Beasiswa_Laravel.git
   cd Aplikasi-Pendaftaran-Beasiswa_Laravel
   ```
2. **Instal dependency PHP dan JavaScript:**
   ```bash
   composer install
   npm install
   ```
3. **Salin file konfigurasi environment dan buat `APP_KEY`:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Konfigurasi koneksi database pada file `.env`**, lalu jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```
5. **Buat symbolic link storage publik (untuk banner beasiswa & pengumuman):**
   ```bash
   php artisan storage:link
   ```
6. **Build aset frontend dan jalankan server lokal:**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses aplikasi melalui browser di `http://localhost:8000`.

---

## 6. Konfigurasi Environment Variable (Tanpa Nilai Rahasia)

Berikut adalah variabel lingkungan utama yang perlu dikonfigurasi pada file `.env` (tanpa menyertakan nilai kredensial/rahasia):

```dotenv
APP_NAME="Beasiswa UNIKU"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://namaaplikasi.example.com

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_beasiswa_uniku
DB_USERNAME=<isi_username_database>
DB_PASSWORD=<isi_password_database>

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_HTTP_ONLY=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

FILESYSTEM_DISK=local

SEED_ADMIN_PASSWORD=<isi_password_seed_admin>
SEED_BAAK_PASSWORD=<isi_password_seed_baak>
```

---

## 7. Ringkasan Penggunaan AI Agent

- **Alat AI yang Digunakan:** **Antigravity AI Agent (berbasis model Google Gemini)**.
- **Bagian Pekerjaan yang Dibantu & Alur Pengerjaan:**
  1. **Analisis Kebutuhan & Konseptualisasi Sistem:** Seluruh data kebutuhan aplikasi yang diperoleh dari hasil observasi dan wawancara langsung dengan pihak **BAAK Universitas Kuningan** diberikan kepada AI Agent untuk dikonsepkan secara menyeluruh (meliputi alur pendaftaran mahasiswa, validasi NIM terhadap data akademik, syarat 7 dokumen PDF, alur verifikasi BAAK, hingga pembagian peran Mahasiswa, BAAK, dan Super Admin).
  2. **Pengembangan Kode Bertahap per Modul:** Setelah konsep keseluruhan sesuai dengan kebutuhan, AI diperintahkan untuk menulis kode secara bertahap per modul (modul autentikasi & validasi NIM, modul pengelolaan beasiswa & pengumuman, modul pengajuan & riwayat pendaftaran mahasiswa, modul verifikasi & cetak laporan PDF BAAK, serta modul manajemen Super Admin).
  3. **Verifikasi, Peninjauan, dan Penyuntingan Manual:** Setiap modul yang selesai dibuat diperiksa dan diuji secara langsung untuk memastikan fungsinya sesuai dengan kebutuhan hasil wawancara BAAK. Apabila ditemukan fungsi atau tampilan yang kurang sesuai, maupun celah keamanan saat proses *self-testing*, kode tersebut ditulis ulang atau diedit secara manual agar selaras dengan kebutuhan aplikasi dan standar keamanan.
- **Contoh Prompt Utama:**
  - *Prompt Konseptualisasi Awal:*
    > "Berdasarkan hasil observasi dan wawancara dengan pihak BAAK UNIKU, saya ingin membangun aplikasi web pendaftaran beasiswa menggunakan Laravel. Kebutuhan utamanya: (1) Mahasiswa hanya bisa registrasi jika NIM terdaftar di data akademik master, (2) Mahasiswa dapat mendaftar beasiswa dengan mengunggah 7 berkas PDF persyaratan (SKTM, Transkrip, Surat Aktif Kuliah, KTP, KTM, KRS, Surat Tidak Menerima Beasiswa Lain), (3) Staf BAAK dapat mengelola program beasiswa, pengumuman, memverifikasi berkas pendaftar (Menunggu, Sedang Ditinjau, Lolos, Ditolak), serta mencetak laporan PDF, dan (4) Super Admin dapat mengelola seluruh data master. Buatkan konsep arsitektur, skema tabel database, dan pembagian modulnya terlebih dahulu."
  - *Prompt Implementasi per Modul:*
    > "Konsep sudah sesuai. Sekarang tuliskan kode untuk modul pendaftaran mahasiswa dan verifikasi BAAK secara bertahap, termasuk validasi unggah 7 berkas PDF maksimal 2MB dan fitur ekspor laporan PDF pendaftar berdasarkan filter status verifikasi."
  - *Prompt Audit & Perbaikan Keamanan:*
    > "Periksa apakah aplikasi ini sudah memenuhi ketentuan teknis keamanan (validasi password kuat, anti-SQLi dan XSS, cookie sesi HttpOnly dan Secure, kontrol akses RBAC & pencegahan IDOR pada berkas pendaftaran, rate limiting, security headers, dan log aktivitas), lalu perbaiki bug dan celah keamanan yang ditemukan."

---

## 8. Hasil Self-Testing Keamanan

Pengujian dilakukan secara kombinasi (peninjauan kode dengan bantuan AI Agent dan verifikasi manual pada endpoint, form input, serta header HTTP). Berikut dokumentasi skenario pengujian beserta perbaikan yang telah diterapkan:

| No | Skenario Uji | Cara Pengujian | Hasil Awal (Sebelum Perbaikan) | Perbaikan yang Dilakukan | Hasil Akhir (Sesudah Perbaikan) |
| :-: | :--- | :--- | :---: | :--- | :---: |
| 1 | **Autentikasi & Kebijakan Password Lemah** | Mengirimkan request registrasi (`POST /register`) dengan password pendek/lemah seperti `123` tanpa kombinasi huruf dan angka. | **Gagal** *(Password lemah diterima karena aturan validasi hanya `required\|confirmed`)* | Menambahkan aturan default `Password::min(8)->letters()->numbers()` di `AppServiceProvider` dan menerapkan `Rules\Password::defaults()` pada `RegisteredUserController` serta `Admin\DashboardController::updateUser()`. | **Lolos** *(Password lemah ditolak oleh server)* |
| 2 | **Kontrol Akses & IDOR pada Berkas Persyaratan Mahasiswa** | Mengakses URL berkas PDF persyaratan (KTP/SKTM/Transkrip) milik mahasiswa lain secara langsung tanpa login atau menggunakan akun mahasiswa berbeda. | **Gagal** *(Berkas tersimpan di `public/storage/uploads/dokumen` dan dapat diakses langsung lewat URL publik)* | Memindahkan penyimpanan berkas pendaftaran ke disk privat (`local`), memblokir akses langsung direktori dokumen publik via `.htaccess`, serta membuat endpoint `/pendaftaran/{pendaftaran}/dokumen/{jenis}` yang memverifikasi role `admin`/`baak` atau pemilik (`user_id === auth()->id()`). | **Lolos** *(Akses oleh pengguna tidak berhak menghasilkan `403 Forbidden` & tercatat di log)* |
| 3 | **Kontrol Akses & Manipulasi Status/Data Pendaftaran** | Mengirim request `PUT /mahasiswa/pendaftaran/{id}` ketika status pendaftaran sudah `LOLOS`/`DITOLAK`, serta mengubah field `readonly` (`nim` dan `nama_lengkap`) saat `POST /mahasiswa/pendaftaran`. | **Gagal** *(Pengecekan status hanya di sisi tampilan/tombol Blade, dan `nim`/`nama_lengkap` diambil dari input request)* | Menambahkan pengecekan server-side `if ($pendaftaran->status_verifikasi !== 'MENUNGGU') abort(403)` pada `update()`, serta mengambil `nim` dan `nama_lengkap` langsung dari `auth()->user()` pada `store()` dan `update()`. | **Lolos** *(Request manipulasi ditolak dengan `403 Forbidden` dan identitas terkunci pada akun login)* |
| 4 | **SQL Injection & XSS pada Form Input dan Parameter URL** | Menguji payload `' OR '1'='1` dan karakter wildcard `%_` pada pencarian/filter serta menyisipkan payload `<script>alert(1)</script>` atau tanda kutip `'; alert(1); //` pada input teks yang dirender ke modal Alpine.js (`@click`) dan parameter `/api/check-nim/{nim}`. | **Temuan Minor** *(Query aman dengan Eloquent binding, namun atribut `@click` memakai `'{{ addslashes(...) }}'` dan fetch NIM belum memakai `encodeURIComponent()`)* | Mengganti seluruh interpolasi data di atribut `@click` menjadi direktif JSON-safe `@js(...)`, menambahkan `encodeURIComponent()` pada `fetch`, menerapkan `strip_tags()` & validasi regex pada NIM/No HP, serta meng-escape wildcard `%_` dengan `addcslashes()`. | **Lolos** *(Seluruh input tervalidasi, tersanitasi, dan di-encode dengan aman)* |
| 5 | **Manajemen Sesi, Cookie (`HttpOnly` & `Secure`), dan Rate Limiting** | Memeriksa konfigurasi sesi/cookie serta melakukan percobaan request berulang pada `/login`, `/admin-login`, `/register`, dan `/api/check-nim/{nim}`. | **Temuan sebagian** *(`HttpOnly` dan rate limit login 5x sudah aktif, namun `SESSION_SECURE_COOKIE` dan `SESSION_ENCRYPT` belum diaktifkan secara default, serta `/register` dan `/api/check-nim` belum memiliki rate limit)* | Mengaktifkan `SESSION_SECURE_COOKIE=true`, `SESSION_HTTP_ONLY=true`, `SESSION_SAME_SITE=lax`, dan `SESSION_ENCRYPT=true` di `config/session.php` & `.env`, serta menambahkan middleware `throttle:6,1` pada registrasi dan `throttle:10,1` pada login & API cek NIM. | **Lolos** *(Cookie memiliki atribut `HttpOnly; Secure; SameSite=Lax`, sesi terenkripsi, dan brute-force dibatasi `429 Too Many Requests`)* |
| 6 | **HTTP Security Headers** | Memeriksa header respons HTTP dari aplikasi untuk proteksi clickjacking, MIME sniffing, dan kebijakan sumber konten (CSP). | **Gagal** *(Header keamanan seperti `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`, dan `Referrer-Policy` belum ada)* | Membuat middleware global `App\Http\Middleware\SecurityHeaders` di `bootstrap/app.php` dan aturan `mod_headers` di `public/.htaccess` yang menyertakan `CSP`, `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Referrer-Policy`, `Permissions-Policy`, dan `HSTS`. | **Lolos** *(Seluruh respons HTTP menyertakan security headers standar)* |
| 7 | **Pengelolaan Secret, Dump Database, Kesiapan HTTPS, & Pengujian Otomatis** | Memeriksa kode seeder/migrasi, file dump SQL terindeks Git, keberadaan berkas mahasiswa di storage publik, serta menjalankan suite pengujian fitur keamanan PHPUnit. | **Gagal** *(Terdapat password hardcoded di `AdminBaakSeeder` dan migrasi `alter_role_enum_in_users_table`, `db_beasiswa_uniku.sql` terlacak Git, 100 berkas PDF mahasiswa masih di `storage/app/public/uploads/dokumen`, dan suite test Breeze belum disesuaikan dengan skema baru)* | Mengganti password hardcoded di `AdminBaakSeeder` dengan `SEED_ADMIN_PASSWORD`/`SEED_BAAK_PASSWORD` (atau generator acak `Str::password(16)`), menghapus insert password hardcoded pada migrasi serta membuatnya kompatibel MySQL & SQLite, meng-untrack `db_beasiswa_uniku.sql` & menambahkan `*.sql` ke `.gitignore`, memindahkan 100 PDF ke `storage/app/private/uploads/dokumen/`, mengonfigurasi `trustProxies` + `URL::forceScheme('https')` untuk production, serta menambahkan `SecurityTest.php` dan memperbarui test autentikasi/profil. | **Lolos Lokal** *(`php artisan test` lulus 28 test / 98 assertions; pembersihan riwayat commit GitHub, rotasi kredensial lama, dan deployment HTTPS publik masih perlu dijalankan pada environment target)* |
| 8 | **Audit Kerentanan Dependensi (`composer audit` & `npm audit`)** | Menjalankan `composer audit` dan `npm audit` pada dependensi PHP (`composer.lock`) serta Node.js (`package-lock.json`). | **Gagal** *(Ditemukan 39 advisory keamanan pada 10 paket Composer termasuk `laravel/framework`, `dompdf/dompdf`, `symfony/*`, serta 11 kerentanan NPM termasuk `axios`, `vite`, `postcss`, dan `shell-quote`)* | Menjalankan `composer update` (antara lain memperbarui `laravel/framework` ke `v12.72.0`, `dompdf/dompdf` ke `v3.1.6`, `symfony/*` ke `v7.4.22`/`v7.4.23`) dan `npm audit fix` (memperbarui `axios` ke `1.21.1`, `vite` ke `7.3.8`, `postcss` ke `8.5.33`, dll.), lalu melakukan build ulang aset dengan `npm run build`. | **Lolos** *(`composer audit` melaporkan `No security vulnerability advisories found` dan `npm audit` melaporkan `0 vulnerabilities`)* |
