# Booksales API - Tugas Pertemuan 1 (Sistem MVC Laravel)

Proyek ini dibuat untuk memenuhi tugas implementasi sistem MVC (Model-View-Controller), Migration, Seeder, dan Relasi Eloquent sederhana pada framework Laravel dengan studi kasus data **Author** dan **Book**.

---

## Struktur File & Perubahan

Berikut adalah daftar file yang ditambahkan dan disesuaikan dalam tugas ini:

### 1. Database & Seeder
- `database\migrations\2026_10_27_032748_create_authors_table.php` — Skema tabel `authors` (id, name, photo, bio, timestamps).
- `database\migrations\2026_10_27_032809_create_books_table.php` — Skema tabel `books` (id, title, description, price, stock, cover_photo, author_id, timestamps).
- `database/seeders/AuthorSeeder.php` — Mengisi data awal dummy untuk tabel `authors`.
- `database/seeders/BookSeeder.php` — Mengisi data awal dummy untuk tabel `books`.

### 2. Model
- `app/Models/Author.php` — Model untuk tabel `authors` beserta relasi `hasMany` ke `Book`.
- `app/Models/Book.php` — Model untuk tabel `books` beserta relasi `belongsTo` ke `Author`.

### 3. Controller
- `app/Http/Controllers/AuthorController.php` — Mengambil data dari `Author` Model dan mengirimkannya ke View `authors.index`.
- `app/Http/Controllers/BookController.php` — Mengambil data dari `Book` Model beserta relasi author-nya dan mengirimkannya ke View `books.index`.

### 4. View
- `resources/views/authors/index.blade.php` — Menampilkan tabel daftar author dengan styling CSS.
- `resources/views/books/index.blade.php` — Menampilkan tabel daftar buku lengkap dengan harga, stok, dan nama penulis.

### 5. Routing
- `routes/web.php` — Mendaftarkan rute `/authors` dan `/books`.

---

## 📸 Tampilan Aplikasi

### 1. Daftar Author (`/authors`)
![Daftar Author](author.png)

### 2. Daftar Book (`/books`)
![Daftar Book](book.png)