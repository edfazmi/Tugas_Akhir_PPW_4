# EdfaContact --- Sistem Manajemen Kontak Sederhana

EdfaContact adalah aplikasi web ringan yang dirancang untuk mempermudah
pengelolaan kontak melalui antarmuka yang bersih, modern, dan responsif.
Menggunakan PHP native dan Tailwind CSS, aplikasi ini menyediakan fitur
CRUD kontak lengkap dengan sistem login sederhana berbasis session.

------------------------------------------------------------------------

## ✨ Fitur Utama

-   **Sistem Login (Dummy Authentication)**\
    Login menggunakan kredensial yang ditentukan secara hardcoded.

-   **Session Guard (Proteksi Halaman)**\
    Hanya pengguna yang sudah login yang dapat mengakses halaman kontak.

-   **CRUD Kontak Lengkap**

    -   **Create** → Tambah kontak baru (disimpan di session)\
    -   **Read** → Tampilkan daftar kontak\
    -   **Update** → Edit informasi kontak\
    -   **Delete** → Hapus kontak yang tidak diperlukan

-   **Pencarian Kontak Real-Time**\
    Pencarian cepat terhadap data kontak yang tersimpan di session.

-   **Manajemen Sesi Lengkap**\
    Login, aktivitas session, dan logout yang jelas dan terkendali.

-   **Data Non-Permanen**\
    Semua data kontak akan kembali ke data dummy setelah logout.

------------------------------------------------------------------------

## 🛠️ Teknologi yang Digunakan

-   **Backend:** PHP 
-   **Frontend:** HTML5
-   **UI:** Tailwind CSS
-   **Storage:** PHP Session (`$_SESSION`)

------------------------------------------------------------------------

## 📁 Struktur Direktori

    edfacontact/
    │
    ├── index.php         # Halaman utama 
    ├── login.php         # Form login
    ├── logout.php        # Proses logout & destroy session
    ├── tambah.php        # Form tambah kontak
    ├── edit.php          # Form edit kontak
    ├── hapus.php         # Konfirmasi hapus kontak
    │
    └── includes/
        ├── config.php    # Konfigurasi utama (session_start)
        ├── auth.php      # Autentikasi & session guard
        ├── functions.php # Fungsi CRUD menggunakan $_SESSION
        ├── header.php    # Template header + navbar
        └── footer.php    # Template footer

------------------------------------------------------------------------

## 🚀 Cara Menjalankan

1.  Pastikan memiliki server lokal seperti **XAMPP**.
2.  Salin folder **edfacontact** ke direktori:
    -   XAMPP → `htdocs/`
    -   WAMP → `www/`
3.  Buka browser dan akses:\
    **http://localhost/edfacontact/**
4.  Anda akan diarahkan ke halaman login.
5.  Gunakan kredensial berikut:

```{=html}
<!-- -->
```
    Username : edfa
    Password : admin123

------------------------------------------------------------------------

## 🧠 Arsitektur Manajemen Sesi (Inti Aplikasi)

Aplikasi EdfaContact tidak menggunakan database.\
Session (`$_SESSION`) bertindak sebagai *database sementara* selama
pengguna aktif.

------------------------------------------------------------------------

### 1. Inisiasi Session (`includes/config.php`)

Semua halaman yang berhubungan dengan session memanggil
`session_start()`.\
File `config.php` dipanggil melalui `header.php`, sehingga session aktif
di seluruh halaman.

------------------------------------------------------------------------

### 2. Login & Pembuatan Data Session

Saat login berhasil:

Menandai user sebagai login:

    $_SESSION['user_id'] = $username;

Inisialisasi data kontak dummy:

    $_SESSION['contacts'] = get_initial_dummy_contacts();

------------------------------------------------------------------------

### 3. Proteksi Halaman

-   `is_logged_in()` → mengecek apakah user sudah login\
-   `force_login()` → redirect jika belum login

------------------------------------------------------------------------

### 4. CRUD Kontak via Session

Semua operasi dilakukan pada:

    $_SESSION['contacts']

Contoh Create:

    $contacts = $_SESSION['contacts'];
    $contacts[] = $data;
    $_SESSION['contacts'] = $contacts;

------------------------------------------------------------------------

### 5. Logout & Penghancuran Session

    session_destroy();

Semua data session hilang, termasuk `contacts` dan `user_id`.

------------------------------------------------------------------------
