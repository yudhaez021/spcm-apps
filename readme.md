<h1>Dokumentasi Aplikasi</h1>

<h2>Instalasi</h2>

1.  Sebelum memulai instalasi aplikasi, pastikan anda sudah mengunduh xampp / mamp pada komputer anda, untuk versi php yang disarankan adalah PHP7.
2.  Extract file zip yang bernama ci_app.
3.  Untuk localhost/lokal server, pastikan sudah ditaruh di htdocs dengan nama folder ci_app.
4.  Buka file config.php pada direktori applications/config/config.php kemudian ubah value $config['base_url'] menjadi url anda
    Contoh: saya punya url http://localhost/aplikasi_bagus maka value $config['base_url'] menjadi $config['base_url'] = 'http://localhost/aplikasi_bagus'
5.  Buatlah sebuah database yang bernama ci_app pada phpmyadmin/mysql server
6.  Kemudian import ci_app.sql yang terletak sejajar pada direktori Applications
7.  Ketika melakukan login, username dan password adalah: admin, admin

<h2>Cara Menggunakan Aplikasi<h2>

<h3>Data Mahasiswa</h3>

<h4>A. Tambah Data Mahasiswa</h4>

<h5>A.1 Manual</h5>

1. Klik button/tombol Tambah data mahasiswa
2. Kemudian, pastikan anda mengisi seluruh field yang sudah dilampirkan *catatan: untuk NIM tidak boleh sama.
3. Kemudian, klik button/tombol Tambah Data Mahasiswa

<h5>A.2 Import</h5>

1. Klik button/tombol Import data mahasiswa
2. Unduh template nya terlebih dahulu dengan mengeklik 'silahkan unduh templatenya disini'
3. Kemudian sesuaikan data excel dengan data template yang sudah diunduh
4. Save data excel berupa .xls dan pastikan data tidak lebih dari 8MB / 8024kb
5. Apabila data mahasiswa sudah ada maka data tersebut akan otomatis terupdate

<h4>B. Update Data Mahasiswa</h4>

1.  Klik button/tombol Ubah pada field/kolom aksi
2.  Kemudian ubah field yang telah disediakan apabila ingin dirubah oleh anda
3.  Kemudian, klik button/tombol Perbarui Data

<h4>C. Hapus Data Mahasiswa</h4>

1. Klik button/tombol hapus pada field/kolom aksi

<h4>D. Mencari data mahasiswa / mensortir data mahasiswa</h4>

1. Show 10 entries, artinya hanya menampilkan 10 data saja per halaman
2. Search: bisa mencari data mahasiswa berdasarkan NIM, Nama Lengkap, Angkatan, dan Status

<h3>Alat Canggih</h3>

<h4>A. Ramalan Data dengan metode Exponential Smoothing & Moving Average</h4>

<h5>A.1 Menggunakan Manual Data</h5>

1. Tentukan data berapa tahun yang ingin diinput, contoh: 7 tahun maka data yang terisi adalah 7
2. Kemudian klik button/tombol Kirim
3. Masukkan data pada field yang sudah disediakan
4. Kemudian klik button/tombol Kirim (*catatan: button/tombol Reset Field berguna untuk mereset field yang telah terisi tadi. Contoh: apabila ingin merubah data 7 tahun tadi cukup mengklik button/tombol reset field tadi)
5. Hasil data akan muncul, apabila ingin merubah konstanta cukup di isikan field tersebut
6. Kemudian klik button/tombol Kirim
7. Apabila anda ingin menggunakan fitur ini menggunakan data yang lain anda harus mengklik button/tombol Ulangi Perhitungan terlebih dahulu, untuk melanjutkannya.

<h5>A.2 Menggunakan Auto Data</h5>

1. Tentukan data tahun dimulai - selesai yang ingin diinput pada element select box, contoh: 2012 - 2018
2. Kemudian klik button/tombol Kirim
3. Hasil data akan muncul, apabila ingin merubah konstanta cukup di isikan field tersebut
4. Kemudian klik button/tombol Kirim
5. Apabila anda ingin menggunakan fitur ini menggunakan data yang lain anda harus mengklik button/tombol Ulangi Perhitungan terlebih dahulu, untuk melanjutkannya.

<h3>Manajemen Akses</h3>

<h4>A. Tambah Data Manajemen Akses</h4>

1. Klik button/tombol Tambah user hak akses
2. Kemudian, pastikan anda mengisi seluruh field yang sudah dilampirkan (kecuali foto)
3. Kemudian, klik button/tombol Tambahkan User

<h4>B. Update Data Manajemen Akses</h4>

1.  Klik button/tombol Ubah pada field/kolom aksi
2.  Kemudian ubah field yang telah disediakan apabila ingin dirubah oleh anda (kecuali foto, apabila field foto dikosongkan tidak apa-apa)
3.  Kemudian, klik button/tombol Perbarui Data

<h4>C. Hapus Data Manajemen Akses</h4>

1. Klik button/tombol hapus pada field/kolom aksi (*catatan: apabila status akun manajemen akses adalah Utama, maka akun tersebut tidak dapat dihapus)

<h3>Pengaturan</h3>

<h4>A. Mengubah Pengaturan Aplikasi</h4>

1. Cukup mengubah field yang diinginkan, untuk aplikasi tersebut
2. Kemudian klik button/tombol Update
3. Maka secara otomatis pengaturan aplikasi akan berubah

<h2>Penjelasan Fitur</h2>

**Dashboard**
Melihat total data mahasiswa (keseluruhan), total data mahasiswa 5 tahun terakhir, Informasi tentang aplikasi, dan tanggal hari ini

**Data Mahasiswa**
Bisa mengubah, menambahkan, mensortir, mengupload, menghapus data mahasiswa yang ada di database

**Alat Canggih**
Bisa menghitung ramalan / data tahun depan mahasiswa menggunakan metode Exponential Smoothing dan Perhitungan Moving Average

**Manajemen Akses**
Bisa mengubah, menambahkan, menghapus data administrator yang ada di database

**Pengaturan**
Bisa mengubah pengaturan aplikasi (nama aplikasi, intro aplikasi, deskripsi aplikasi, pembuat aplikasi)
