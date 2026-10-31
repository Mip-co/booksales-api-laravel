# Booksales API - Tugas Authentication & Authorization (REST API Laravel)

Proyek ini merupakan pengembangan lanjutan dari layanan **REST API** Laravel. Pada tahap ini ditambahkan **autentikasi** menggunakan **JWT (JSON Web Token)**, **middleware**, dan **RBAC (Role-Based Access Control)**, sehingga hak akses setiap endpoint untuk sumber daya **Genre** dan **Author** dapat diatur berdasarkan status login dan role pengguna.

---

## 🚀 Perubahan & Struktur API

Berikut adalah penyesuaian utama pada tahap ini:

1. ### Autentikasi JWT
   - Menggunakan paket `tymon/jwt-auth`.
   - `config/auth.php` — Menambahkan guard `api` dengan driver `jwt`.
   - `app/Models/User.php` — Mengimplementasikan `JWTSubject` dan menyimpan `role` di dalam payload token.
   - `app/Http/Controllers/AuthController.php` — Method `register`, `login`, `me`, dan `logout`.

2. ### Middleware & RBAC
   - `app/Http/Middleware/RoleMiddleware.php` — Memeriksa role pengguna. Belum login mengembalikan `401`, role tidak sesuai mengembalikan `403`.
   - `bootstrap/app.php` — Mendaftarkan alias middleware `role`, mengatur agar user yang belum login tidak di-redirect, dan memastikan semua error di `/api/*` selalu berformat JSON.

3. ### Routing API
   - `routes/api.php` — Rute dibagi menjadi tiga kelompok: publik, wajib login, dan khusus admin.

   ```php
   // Publik: Read All & Show (tanpa login)
   Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);
   Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);

   // Wajib login (token JWT)
   Route::middleware('auth:api')->group(function () {
       Route::get('/me', [AuthController::class, 'me']);
       Route::post('/logout', [AuthController::class, 'logout']);

       // Hanya admin: Create, Update, Destroy
       Route::middleware('role:admin')->group(function () {
           Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
           Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);
       });
   });
   ```

4. ### Database (Migration & Seeder)
   - `create_users_table` — Tabel `users` dengan kolom `role` (`admin` / `customer`) dan `last_access`.
   - `UserSeeder` — Membuat satu akun admin dan satu akun customer.

---

## 🔐 Akun Pengujian (Seeder)

| Role | Email | Password |
| :--- | :--- | :--- |
| `admin` | `admin@booksales.com` | `admin12345` |
| `customer` | `customer@booksales.com` | `customer12345` |

> Akun yang mendaftar lewat `/api/register` selalu mendapat role `customer`. Role tidak dapat ditentukan dari request.

---

## 📌 Endpoints API

| Method | Endpoint | Deskripsi | Hak Akses | Status Code |
| :--- | :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | Registrasi akun baru (role `customer`) | Publik | `201` / `422` |
| `POST` | `/api/login` | Login dan mendapatkan token JWT | Publik | `200` / `401` / `422` |
| `GET` | `/api/genres` | Mengambil seluruh data genre | Publik | `200` |
| `GET` | `/api/genres/{id}` | Mengambil satu data genre | Publik | `200` / `404` |
| `GET` | `/api/authors` | Mengambil seluruh data penulis | Publik | `200` |
| `GET` | `/api/authors/{id}` | Mengambil satu data penulis | Publik | `200` / `404` |
| `GET` | `/api/me` | Data user yang sedang login | Login | `200` / `401` |
| `POST` | `/api/logout` | Logout (token tidak berlaku lagi) | Login | `200` / `401` |
| `POST` | `/api/genres` | Menambahkan data genre | Admin | `201` / `401` / `403` / `422` |
| `PUT` | `/api/genres/{id}` | Memperbarui data genre | Admin | `200` / `401` / `403` / `404` / `422` |
| `DELETE` | `/api/genres/{id}` | Menghapus data genre | Admin | `200` / `401` / `403` / `404` |
| `POST` | `/api/authors` | Menambahkan data penulis | Admin | `201` / `401` / `403` / `422` |
| `PUT` | `/api/authors/{id}` | Memperbarui data penulis | Admin | `200` / `401` / `403` / `404` / `422` |
| `DELETE` | `/api/authors/{id}` | Menghapus data penulis | Admin | `200` / `401` / `403` / `404` |

### Cara Memakai Token

Setelah login, salin nilai `access_token` lalu kirimkan pada setiap request yang membutuhkan login melalui header:

```
Authorization: Bearer <access_token>
```

Di Postman: tab **Authorization** → **Bearer Token** → tempel token.

### Format Output JSON

**Login (`200 OK`)** — `POST /api/login`

Request body:

```json
{
  "email": "customer@booksales.com",
  "password": "customer12345"
}
```

Respons:

```json
{
  "status": "success",
  "message": "Berhasil login",
  "data": {
    "user": {
      "id": 2,
      "name": "Customer Booksales",
      "email": "customer@booksales.com",
      "role": "customer",
      "last_access": "2026-10-31T10:52:24.000000Z",
      "created_at": "2026-10-31T10:40:20.000000Z",
      "updated_at": "2026-10-31T10:52:24.000000Z"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600
  }
}
```

**Belum login (`401 Unauthorized`)** — misalnya `POST /api/genres` tanpa token

```json
{
  "message": "Unauthenticated."
}
```

**Bukan admin (`403 Forbidden`)** — misalnya `POST /api/genres` dengan token customer

```json
{
  "status": "error",
  "message": "Akses ditolak. Endpoint ini hanya untuk role: admin"
}
```

**Data tidak ditemukan (`404 Not Found`)** — misalnya `DELETE /api/genres/7` yang sudah dihapus

```json
{
  "status": "error",
  "message": "Data genre tidak ditemukan"
}
```

---


API dapat diakses di `http://127.0.0.1:8000/api`.

---

## 📸 Pengujian dengan Postman

### 1. Tanpa Login

#### Melihat daftar genre (`GET /api/genres`) — `200 OK`
![Get Genres](hasil/tanpa-login-get-genres.png)

#### Melihat detail genre (`GET /api/genres/1`) — `200 OK`
![Get Genre Detail](hasil/tanpa-login-get-genre-detail.png)

#### Melihat daftar author (`GET /api/authors`) — `200 OK`
![Get Authors](hasil/tanpa-login-get-authors.png)

#### Melihat detail author (`GET /api/authors/1`) — `200 OK`
![Get Author Detail](hasil/tanpa-login-get-author-detail.png)

#### Menambah genre tanpa login (`POST /api/genres`) — `401 Unauthorized`
![Create Genre 401](hasil/tanpa-login-post-genre-401.png)

#### Mengubah author tanpa login (`PUT /api/authors/1`) — `401 Unauthorized`
![Update Author 401](hasil/tanpa-login-put-author-401.png)

#### Menghapus genre tanpa login (`DELETE /api/genres/1`) — `401 Unauthorized`
![Delete Genre 401](hasil/tanpa-login-delete-genre-401.png)

### 2. Login sebagai Customer

#### Login customer (`POST /api/login`) — `200 OK`
![Login Customer](hasil/customer-login.png)

#### Menambah genre (`POST /api/genres`) — `403 Forbidden`
![Customer Create Genre 403](hasil/customer-post-genre-403.png)

#### Mengubah author (`PUT /api/authors/1`) — `403 Forbidden`
![Customer Update Author 403](hasil/customer-put-author-403.png)

#### Menghapus genre (`DELETE /api/genres/1`) — `403 Forbidden`
![Customer Delete Genre 403](hasil/customer-delete-genre-403.png)

#### Melihat detail genre (`GET /api/genres/1`) — `200 OK` (tetap bisa karena publik)
![Customer Get Genre](hasil/customer-get-genre-200.png)

### 3. Login sebagai Admin

#### Login admin (`POST /api/login`) — `200 OK`
![Login Admin](hasil/admin-login.png)

#### Menambah genre (`POST /api/genres`) — `201 Created`
![Admin Create Genre](hasil/admin-post-genre-201.png)

#### Mengubah genre (`PUT /api/genres/7`) — `200 OK`
![Admin Update Genre](hasil/admin-put-genre-200.png)

#### Menghapus genre (`DELETE /api/genres/7`) — `200 OK`
![Admin Delete Genre](hasil/admin-delete-genre-200.png)

#### Menghapus genre yang sudah dihapus (`DELETE /api/genres/7`) — `404 Not Found`
![Admin Delete Genre 404](hasil/admin-delete-genre-404.png)

#### Menambah author (`POST /api/authors`) — `201 Created`
![Admin Create Author](hasil/admin-post-author-201.png)

#### Mengubah author (`PUT /api/authors/7`) — `200 OK`
![Admin Update Author](hasil/admin-put-author-200.png)

#### Menghapus author (`DELETE /api/authors/7`) — `200 OK`
![Admin Delete Author](hasil/admin-delete-author-200.png)