# Technical Test

Selamat datang di technical test ini. Anda diberikan sebuah aplikasi **Financial Management** berbasis Laravel yang memiliki beberapa **bug** dan **fitur yang belum selesai**. Tugas Anda adalah menemukan, menganalisis, dan menyelesaikan semua permasalahan yang ada.


# Deskripsi Aplikasi

Aplikasi ini adalah sistem manajemen keuangan sederhana yang mencatat transaksi **pemasukan (income)** dan **pengeluaran (expense)**. Fitur utama meliputi:

- Menampilkan daftar transaksi (menggunakan DataTables server-side)
- Menambah transaksi baru
- Menghapus transaksi
- Menampilkan summary (total pemasukan, total pengeluaran, saldo)


# Tugas Anda

# 1. Bug dan Eror Fixing

Aplikasi ini memiliki **bug dan eror tersembunyi** yang menyebabkan fitur tidak berjalan dengan benar. Temukan dan perbaiki bug dan eror tersebut.

**Yang diharapkan:**
- Identifikasi root cause dari eror dan bug
- Bisa memperbaiki bug dan eror tersebut
- Jelaskan apa penyebab bug dan eror serta bagaimana solusi Anda mengatasi masalahnya

# 2. Implementasi Fitur Update

Saat ini aplikasi hanya memiliki fitur **Tambah (Store)** dan **Hapus (Delete)** transaksi. Fitur **Edit/Update** belum diimplementasi.

Implementasikan fitur update transaksi secara **end-to-end**, meliputi:
- Backend (Request validation, Repository, Service, Controller, Route)
- Frontend (Tombol edit, Modal edit, JavaScript handler)

# 3. Implementasi Summary Cards

Summary cards di bagian atas halaman (Total Pemasukan, Total Pengeluaran, dan Saldo) saat ini selalu menampilkan **Rp 0**. Data belum dihitung dari transaksi yang ada.

Implementasikan logika perhitungan agar:
- **Total Pemasukan** menampilkan jumlah semua transaksi bertipe `income`
- **Total Pengeluaran** menampilkan jumlah semua transaksi bertipe `expense`
- **Saldo** menampilkan selisih antara pemasukan dan pengeluaran

# 4. Implementasi Filter Date Range pada DataTable

Tampilan input filter **date range** (Dari Tanggal — Sampai Tanggal) sudah tersedia di halaman, namun belum berfungsi. Implementasikan logika filter agar:

- Klik tombol **Filter** mengirim parameter tanggal ke server dan DataTable menampilkan data sesuai rentang tanggal yang dipilih
- Klik tombol **Reset** menghapus filter dan menampilkan semua data kembali
- Filter berlaku untuk **kedua tab** (Pemasukan dan Pengeluaran)


# Panduan Pengerjaan

1. Pelajari struktur project dan pattern yang digunakan
2. Pahami arsitektur yang digunakan sebelum mulai coding
3. Ikuti pattern/convention yang **sudah ada** di project ini
4. Perhatikan kode yang sudah ada sebagai referensi gaya penulisan
5. Gunakan helper/utility yang sudah tersedia, jangan membuat ulang


# Catatan penilaian:
- Bukan hanya *fix* yang dinilai, tapi juga kemampuan menjelaskan **root cause**
- Mengikuti pattern yang ada di project lebih diutamakan daripada "asal jalan"
- Kerapian kode dan konsistensi dengan convention project menjadi nilai tambah
- Memanfaatkan modal yang sudah ada (partial blade) untuk fitur update menjadi nilai tambah
