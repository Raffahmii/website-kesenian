<div align="center">

<img src="kesenian/public/images/logo.png" alt="Giri Adiwarna" width="120" />

# 🎭 Giri Adiwarna Management Information System

### GAMIS — Sistem Informasi Organisasi Kesenian SMKN 1 Banjar

> **1 Suara · 1 Rasa · 1 Extra · We Are The Best Yes**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13+-336791?style=for-the-badge&logo=postgresql&logoColor=white)](https://postgresql.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)](https://alpinejs.dev)

[![Status](https://img.shields.io/badge/Status-Active-success?style=flat-square)]()
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)]()
[![PRs Welcome](https://img.shields.io/badge/PRs-Welcome-blue?style=flat-square)]()

</div>

---

## 📖 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Filosofi Nama](#-filosofi-nama)
- [Fitur Utama](#-fitur-utama)
- [Screenshots](#-screenshots)
- [Tech Stack](#️-tech-stack)
- [Arsitektur Sistem](#️-arsitektur-sistem)
- [Skema Database](#️-skema-database)
- [Instalasi](#-instalasi)
- [Akun Default](#-akun-default)
- [Struktur Project](#-struktur-project)
- [User Roles](#-user-roles)
- [Routes Ringkasan](#-routes-ringkasan)
- [Color Palette](#-color-palette)
- [Roadmap](#️-roadmap)
- [Kontribusi](#-kontribusi)
- [Developer](#-developer)
- [Lisensi](#-lisensi)

---

## 📌 Tentang Project

**Giri Adiwarna Management Information System (GAMIS)** adalah sistem informasi berbasis web untuk organisasi **Kesenian Giri Adiwarna SMKN 1 Banjar**. Dibangun untuk **menggantikan administrasi manual** (buku tulis & file Excel terpisah-pisah) menjadi **sistem digital terpusat** yang modern, cepat, dan aman.

### 🎯 Kenapa GAMIS Dibuat?

| Masalah Sebelumnya | Solusi GAMIS |
|---|---|
| Data anggota tercatat di buku | Database anggota terpusat + search |
| Absensi manual pakai kertas | Absensi digital per cabang |
| Kas dicatat di buku terpisah | Sistem kas dengan laporan PDF/Excel |
| Dokumentasi tercecer di HP | Album digital terorganisir |
| Riwayat kepengurusan hilang | Timeline kepengurusan per periode |
| Data susah dicari | Search global + filter |
| Laporan susah dibuat | Export PDF/Excel instan |

### 🎁 Fungsi Utama

1. **Website Publik** — Media informasi & publikasi organisasi ke masyarakat
2. **Sistem Internal** — Tools operasional harian untuk pengurus
3. **Arsip Digital** — Menyimpan sejarah & prestasi organisasi
4. **Portfolio Project** — Showcase Full-Stack Development untuk developer

---

## 🗿 Filosofi Nama

**Giri Adiwarna** berasal dari bahasa **Sanskerta**:

| Kata | Arti | Makna |
|---|---|---|
| **Giri** | Gunung | Kekuatan, keteguhan, solidaritas yang kokoh |
| **Adiwarna** | Seni / Keindahan | Ekspresi kreativitas & pelestarian budaya |

> *"Bahwa Kesenian SMKN 1 Banjar menjunjung tinggi nilai seni budaya dengan dasar kekuatan dan solidaritas untuk mencapai kesuksesan bersama."*

**Tagline:** `1 Suara · 1 Rasa · 1 Extra · We Are The Best Yes`

---

## ✨ Fitur Utama

### 🌐 Website Publik (Landing Page)

<table>
<tr>
<td width="50%">

**🏠 Hero Section**
- Logo dengan glow effect
- Typing animation tagline
- Parallax background wayang
- CTA buttons (Jelajahi & Dokumentasi)
- Loading screen 3 detik

**📖 Tentang Kami**
- Makna nama Giri Adiwarna
- Makna logo (4 elemen)
- Quote filosofi organisasi

**🎯 Visi & Misi**
- Visi card dengan gradient gold
- 5 poin misi organisasi

</td>
<td width="50%">

**🎭 Divisi (6 Cabang)**
- Padus, Seni Tari, Dance
- Band, Musik, Seni Rupa & Teater
- Card dengan foto arch + hover effect

**🏆 Prestasi**
- Grid prestasi dengan trophy SVG
- Filter tingkat (Kab/Prov/Nas)
- Detail prestasi + peserta

**📸 Dokumentasi**
- Grid album dengan cover
- Lightbox gallery
- Modal detail dengan navigation

**📅 Event**
- List jadwal kegiatan
- Date block visual
- Info waktu & lokasi

</td>
</tr>
</table>

### 🔐 Dashboard Internal

| Modul | Fitur | Akses |
|---|---|---|
| **Dashboard** | Statistik real-time, quick actions | Semua role |
| **Anggota** | CRUD, approve, alumni massal, serah terima jabatan | Sekretaris+ |
| **Kepengurusan** | Kelola jabatan & periode, timeline | Ketua, Pembina |
| **Absensi** | Input per cabang, rekap, riwayat pribadi | Sekretaris+ |
| **Kas** | Input bulk, verifikasi, laporan, export PDF/Excel | Bendahara+ |
| **Dokumentasi** | Album + media (foto/video), lightbox gallery | PDD+ |
| **Prestasi** | CRUD prestasi + peserta multi | PDD+ |
| **Pengumuman** | Publish/draft, target role, lampiran | Sekretaris+ |
| **Jadwal & Event** | CRUD jadwal, kalender kegiatan | Sekretaris+ |
| **Laporan** | Export PDF/Excel dengan filter custom | Ketua, Pembina |
| **Audit Log** | Tracking semua aktivitas user | Ketua, Pembina |
| **Pengaturan** | CRUD periode, clear cache, system info | Ketua, Pembina |

### 🎁 Fitur Bonus

- 🔍 **Global Search** — Cari anggota/event/prestasi/album/pengumuman dari navbar
- 🔔 **Notifikasi** — Badge count + dropdown dengan aktivitas terbaru
- 👤 **Profile** — Edit email, password, foto, cover, bio
- 🔗 **Lihat Profile Orang** — Public profile dengan riwayat kepengurusan
- 🎨 **Custom Error Pages** — 403, 404, 419, 500, 503 (dark theme + gold)
- 🎭 **Timeline Kepengurusan** — Per periode dengan status aktif
- 📱 **Mobile Responsive** — Optimized untuk HP

---

## 📸 Screenshots

### 🖥️ Landing Page

<table>
<tr>
<td width="50%">

**Landing Page**

![Landing Page](kesenian/docs/screenshots/desktop/01-landing.png)

</td>
<td width="50%">

**Login Modal**

![Login Modal](kesenian/docs/screenshots/desktop/02-login-modal.png)

</td>
</tr>
</table>

### 🔐 Auth

<table>
<tr>
<td width="50%">

**Login Page**

![Login Page](kesenian/docs/screenshots/desktop/02-login-modal.png)

</td>
<td width="50%">

**Register Modal**

![Register Modal](kesenian/docs/screenshots/desktop/03-register-modal.png)

</td>
</tr>
</table>

### 📊 Dashboard & Anggota

<table>
<tr>
<td width="50%">

**Dashboard**

![Dashboard](kesenian/docs/screenshots/desktop/04-dashboard.png)

</td>
<td width="50%">

**Manajemen Anggota**

![Manajemen Anggota](kesenian/docs/screenshots/desktop/05-members.png)

</td>
</tr>
<tr>
<td width="50%">

**Detail Anggota**

![Detail Anggota](kesenian/docs/screenshots/desktop/06-member-detail.png)

</td>
<td width="50%">

**Kepengurusan**

![Kepengurusan](kesenian/docs/screenshots/desktop/15-management.png)

</td>
</tr>
</table>

### 📅 Kegiatan & Absensi

<table>
<tr>
<td width="50%">

**Jadwal & Event**

![Jadwal Event](kesenian/docs/screenshots/desktop/07-events.png)

</td>
<td width="50%">

**Detail Event**

![Detail Event](kesenian/docs/screenshots/desktop/08-event-detail.png)

</td>
</tr>
<tr>
<td colspan="2">

**Input Absensi per Cabang**

![Input Absensi](kesenian/docs/screenshots/desktop/09-attendance-input.png)

</td>
</tr>
</table>

### 💰 Kas & Dokumentasi

<table>
<tr>
<td width="50%">

**Kas & Pembayaran**

![Kas](kesenian/docs/screenshots/desktop/10-cash.png)

</td>
<td width="50%">

**Album Dokumentasi**

![Album](kesenian/docs/screenshots/desktop/11-albums.png)

</td>
</tr>
<tr>
<td colspan="2">

**Lightbox Gallery (Foto & Video)**

![Lightbox](kesenian/docs/screenshots/desktop/12-lightbox.png)

</td>
</tr>
</table>

### 🏆 Prestasi & Pengumuman

<table>
<tr>
<td width="50%">

**Prestasi**

![Prestasi](kesenian/docs/screenshots/desktop/13-achievements.png)

</td>
<td width="50%">

**Pengumuman**

![Pengumuman](kesenian/docs/screenshots/desktop/14-announcements.png)

</td>
</tr>
</table>

### 📋 Laporan & Sistem

<table>
<tr>
<td width="50%">

**Laporan + Export**

![Laporan](kesenian/docs/screenshots/desktop/16-reports.png)

</td>
<td width="50%">

**Audit Log**

![Audit Log](kesenian/docs/screenshots/desktop/17-audit-log.png)

</td>
</tr>
<tr>
<td width="50%">

**Pengaturan**

![Pengaturan](kesenian/docs/screenshots/desktop/18-settings.png)

</td>
<td width="50%">

**Profile User**

![Profile](kesenian/docs/screenshots/desktop/19-profile.png)

</td>
</tr>
</table>

### 🔍 Fitur Bonus

<table>
<tr>
<td width="50%">

**Global Search**

![Search](kesenian/docs/screenshots/desktop/20-search.png)

</td>
<td width="50%">

**Notifikasi**

![Notifikasi](kesenian/docs/screenshots/desktop/21-notification.png)

</td>
</tr>
</table>

---

## 🛠️ Tech Stack

### Backend

| Teknologi | Versi | Fungsi |
|---|---|---|
| Laravel | 12.x | Framework utama |
| PHP | 8.2+ | Bahasa pemrograman |
| PostgreSQL | 13+ | Database |

### Frontend

| Teknologi | Versi | Fungsi |
|---|---|---|
| Blade | - | Template engine |
| Tailwind CSS | 3.x | CSS framework |
| Alpine.js | 3.x | JavaScript framework |
| Vite | 7.x | Build tool |

### Packages

| Package | Fungsi |
|---|---|
| `laravel/breeze` | Authentication scaffold |
| `spatie/laravel-permission` | Role & permission management |
| `barryvdh/laravel-dompdf` | Export PDF |
| `maatwebsite/excel` | Export Excel |
| `intervention/image` | Image processing (resize, compress) |
| `simplesoftwareio/simple-qrcode` | QR code generator |

### Libraries (Frontend)

| Library | Fungsi |
|---|---|
| AOS | Scroll animations |
| SweetAlert2 | Modern popup/alert |
| Chart.js | Data visualization |
| Flowbite | UI components |

---

## 🏗️ Arsitektur Sistem

### Konsep Dual-Layer

```
┌─────────────────────────────────────────────────────┐
│                                                       │
│   🌐 PUBLIC LAYER (Landing Page)                     │
│   ─────────────────────────────────────             │
│   • Tidak perlu login                                │
│   • Data dari database (dinamis)                     │
│   • SEO-friendly                                     │
│                                                       │
├─────────────────────────────────────────────────────┤
│                                                       │
│   🔐 INTERNAL LAYER (Dashboard)                      │
│   ─────────────────────────────────────             │
│   • Perlu login + role-based access                  │
│   • CRUD semua data                                  │
│   • Export laporan                                   │
│                                                       │
└─────────────────────────────────────────────────────┘
```

### Struktur Kepengurusan

```
                        PEMBINA (Guru)
                             │
                          KETUA
                             │
                       WAKIL KETUA
         ┌───────────────────┼───────────────────┐
         │                   │                   │
    SEKRETARIS           BENDAHARA              PDD
     (1 & 2)              (1 & 2)           (Publikasi)
         │                   │                   │
         │                   │                   │
    ┌────┴────┐         ┌────┴────┐         ┌────┴────┐
    │         │         │         │         │         │
  DEP.      DEP.      DEP.      DEP.      DEP.      DEP.
KESENIAN   OSIS   PERALATAN   ...     PERALATAN    ...
    │
    │
    ├── Koor. Padus
    ├── Koor. Seni Tari
    ├── Koor. Dance
    ├── Koor. Band
    ├── Koor. Musik
    └── Koor. Seni
```

---

## 🗄️ Skema Database

**15 Tabel Utama + 3 Spatie Tables**

### 📊 ERD Sederhana

```
users ────┬── kepengurusan ──── jabatan
          │       │
          │       └── periode
          │
          ├── absensi ──── jadwal_kegiatan
          │
          ├── kas_pembayaran ──── kas_kategori
          │
          ├── dokumentasi_album ──── dokumentasi_media
          │
          ├── prestasi_peserta ──── prestasi
          │
          ├── pengumuman
          │
          └── audit_log
```

### 📋 Detail Tabel

<details>
<summary><b>👥 User & Struktur</b></summary>

| Tabel | Kolom Penting | Fungsi |
|---|---|---|
| `users` | id_user, nama_lengkap, email, role, cabang, status_anggota | Data anggota |
| `periode` | id_periode, nama_periode, tahun_mulai, tahun_selesai, is_active | Periode kepengurusan |
| `jabatan` | id_jabatan, nama_jabatan, level, divisi | Master jabatan |
| `kepengurusan` | id_user, id_jabatan, id_periode, is_active | Relasi user-jabatan-periode |

</details>

<details>
<summary><b>📅 Kegiatan & Absensi</b></summary>

| Tabel | Kolom Penting | Fungsi |
|---|---|---|
| `jadwal_kegiatan` | judul, jenis, tanggal, jam_mulai, lokasi | Jadwal kegiatan |
| `absensi` | id_jadwal, id_user, status, keterangan | Absensi per kegiatan |

</details>

<details>
<summary><b>💰 Kas & Keuangan</b></summary>

| Tabel | Kolom Penting | Fungsi |
|---|---|---|
| `kas_kategori` | nama, nominal | Master kategori kas |
| `kas_pembayaran` | id_user, id_kategori, periode_bulan, status | Pembayaran kas |

</details>

<details>
<summary><b>📸 Dokumentasi</b></summary>

| Tabel | Kolom Penting | Fungsi |
|---|---|---|
| `dokumentasi_album` | judul, cover_image, kategori | Album dokumentasi |
| `dokumentasi_media` | id_album, tipe, file_path | Foto/video per album |

</details>

<details>
<summary><b>🏆 Prestasi & Pengumuman</b></summary>

| Tabel | Kolom Penting | Fungsi |
|---|---|---|
| `prestasi` | nama_lomba, tingkat, peringkat, tahun | Data prestasi |
| `prestasi_peserta` | id_prestasi, id_user | Pivot peserta |
| `pengumuman` | judul, isi, target_role, is_published | Pengumuman |

</details>

<details>
<summary><b>📋 Audit</b></summary>

| Tabel | Kolom Penting | Fungsi |
|---|---|---|
| `audit_log` | id_user, action, module, description | Log semua aktivitas |

</details>

### 🎯 Enum Types (9 Enum)

```php
RoleUser:         anggota, pdd, bendahara, sekretaris, ketua, wakil_ketua, pembina
StatusAnggota:    aktif, alumni, nonaktif
JenisKegiatan:    latihan, pentas, lomba, rapat
StatusAbsensi:    hadir, izin, sakit, alpa
StatusKas:        lunas, belum_lunas
TipeMedia:        foto, video
TingkatPrestasi:  sekolah, kabupaten, provinsi, nasional
TargetPengumuman: semua, anggota, pengurus
Cabang:           padus, seni_tari, dance, band, musik, seni
```

---

## 🚀 Instalasi

### 📋 Prasyarat

- ✅ **PHP >= 8.2** (extension: `pdo_pgsql`, `gd`, `zip`, `mbstring`)
- ✅ **Composer**
- ✅ **Node.js >= 18** & **NPM**
- ✅ **PostgreSQL >= 13**
- ✅ **Git**

### 🔧 Langkah Instalasi

#### 1️⃣ Clone Repository

```bash
git clone https://github.com/RaffaHmii/website-kesenian.git
cd website-kesenian/kesenian
```

#### 2️⃣ Install Dependencies

```bash
composer install
npm install
```

#### 3️⃣ Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

#### 4️⃣ Konfigurasi Database

Edit `.env`:

```env
APP_NAME="Giri Adiwarna"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=website_kesenian
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Buat DB di PostgreSQL:

```sql
CREATE DATABASE website_kesenian;
```

#### 5️⃣ Migrate & Seed

```bash
php artisan migrate --seed
```

#### 6️⃣ Storage Link

```bash
php artisan storage:link

# Windows
mkdir storage\app\public\avatars
mkdir storage\app\public\covers
mkdir storage\app\public\albums
mkdir storage\app\public\achievements
mkdir storage\app\public\announcements
```

#### 7️⃣ Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

#### 8️⃣ Jalankan Server

**Terminal 1:**
```bash
npm run dev
```

**Terminal 2:**
```bash
php artisan serve
```

Buka: **http://localhost:8000**

---

## 👤 Akun Default

Password semua: **`password`**

| Email | Role | Nama |
|---|---|---|
| `pembina@giriadiwarna.test` | Pembina | Lin Karlina |
| `ketua@giriadiwarna.test` | Ketua | Rikza Fariq Harii |
| `wakil@giriadiwarna.test` | Wakil Ketua | Agung Mulyana |
| `sekretaris1@giriadiwarna.test` | Sekretaris | Chika Syalsa Atifah |
| `sekretaris2@giriadiwarna.test` | Sekretaris | Devany Julia Putri |
| `bendahara1@giriadiwarna.test` | Bendahara | Siti Anisa |
| `bendahara2@giriadiwarna.test` | Bendahara | Diva Tyara Indriana |
| `pdd@giriadiwarna.test` | PDD | Josephine Abigail |
| `koorpadus@giriadiwarna.test` | Anggota | Dea Rahmawati |

> ⚠️ **Ganti password default sebelum deploy production!**

---

## 📁 Struktur Project

```
website-kesenian/                   # Root repository
├── kesenian/                       # Project Laravel
│   ├── app/
│   │   ├── Enums/                  # 9 Enum PHP
│   │   ├── Exports/                # Export Excel
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Auth/           # Breeze auth
│   │   │   │   ├── Dashboard/      # Controller internal
│   │   │   │   ├── Public/         # Controller publik
│   │   │   │   ├── ProfileController.php
│   │   │   │   └── Controller.php
│   │   │   ├── Middleware/
│   │   │   │   └── EnsureUserHasRole.php
│   │   │   └── Requests/
│   │   ├── Models/                 # 14 Model Eloquent
│   │   ├── Providers/
│   │   └── Services/
│   │       ├── AttendanceService.php
│   │       └── ImageUploadService.php
│   │
│   ├── database/
│   │   ├── migrations/             # 18 file migration
│   │   └── seeders/                # 7 seeder
│   │
│   ├── docs/                       # Dokumentasi & screenshot
│   │   └── screenshots/
│   │       └── desktop/            # 21 screenshot desktop
│   │
│   ├── public/
│   │   ├── build/
│   │   ├── images/
│   │   │   ├── logo.png
│   │   │   ├── batik.jpeg
│   │   │   ├── wayang_background.jpg
│   │   │   └── divisi/
│   │   └── storage/
│   │
│   ├── resources/
│   │   ├── css/app.css
│   │   ├── js/app.js
│   │   └── views/
│   │       ├── auth/
│   │       ├── components/
│   │       ├── dashboard/
│   │       ├── errors/
│   │       ├── layouts/
│   │       ├── profile/
│   │       └── public/
│   │
│   ├── routes/
│   │   ├── web.php
│   │   └── auth.php
│   │
│   ├── storage/
│   │   └── app/public/
│   │
│   ├── .env.example
│   ├── composer.json
│   ├── package.json
│   ├── tailwind.config.js
│   └── vite.config.js
│
├── README.md                       # File ini
└── .gitignore
```

---

## 🎭 User Roles

| Role | Level | Akses |
|---|---|---|
| **Pembina** | 1 | Full akses + monitoring |
| **Ketua** | 2 | Full akses + laporan + audit log |
| **Wakil Ketua** | 3 | Sama dengan Ketua |
| **Sekretaris** | 4 | Anggota, absensi, jadwal, pengumuman |
| **Bendahara** | 5 | Kas, laporan keuangan, export |
| **PDD** | 6 | Dokumentasi, prestasi, publikasi |
| **Anggota** | 7 | View-only (riwayat pribadi) |

> 💡 Register publik otomatis jadi **Anggota**. Role lain di-assign manual.

---

## 🚏 Routes Ringkasan

<details>
<summary><b>🌐 Public Routes</b></summary>

```
GET  /                    → Landing page
GET  /login               → Login page
GET  /register            → Register page
GET  /users/{id}          → Public profile (perlu login)
```

</details>

<details>
<summary><b>🔐 Dashboard Routes</b></summary>

```
GET  /dashboard                        → Dashboard utama
GET  /dashboard/members                → List anggota
GET  /dashboard/events                 → Jadwal kegiatan
GET  /dashboard/attendance             → Absensi
GET  /dashboard/cash                   → Kas
GET  /dashboard/albums                 → Dokumentasi
GET  /dashboard/achievements           → Prestasi
GET  /dashboard/announcements          → Pengumuman
GET  /dashboard/management             → Kepengurusan
GET  /dashboard/reports                → Laporan
GET  /dashboard/audit                  → Audit log
GET  /dashboard/settings               → Pengaturan
```

</details>

<details>
<summary><b>🔍 API Endpoints (AJAX)</b></summary>

```
GET  /dashboard/search?q={query}       → Global search
GET  /dashboard/notifications          → Notifikasi
```

</details>

---

## 🎨 Color Palette

| Nama | Hex | Fungsi |
|---|---|---|
| **Primary BG** | `#1E2328` | Background utama |
| **Secondary BG** | `#2A2E34` | Background alternatif |
| **Card** | `#3B3F46` | Card/panel |
| **Gold** | `#F5B301` | Brand accent |
| **Gold Hover** | `#FEB053` | Hover state |
| **Gold Dark** | `#C28A00` | Aksen gelap |
| **Text** | `#FFFFFF` | Text utama |

---

## 🗺️ Roadmap

### ✅ Selesai (FASE 1-4)

- [x] Setup project + Tailwind config
- [x] Landing page full
- [x] Database schema + 9 Enum + 14 Model
- [x] Authentication + 7 Role-based access
- [x] Dashboard universal + sidebar dynamic
- [x] Modul Anggota (CRUD, approve, alumni massal, serah terima)
- [x] Modul Jadwal + Absensi per cabang
- [x] Modul Kas + Export PDF/Excel
- [x] Modul Dokumentasi (album + media + lightbox)
- [x] Modul Prestasi + Peserta
- [x] Modul Pengumuman
- [x] Modul Laporan + Audit Log
- [x] Modul Kepengurusan + Jabatan
- [x] Pengaturan + CRUD Periode
- [x] Global Search + Notifikasi
- [x] Profile + Cover + Bio
- [x] Custom Error Pages (403, 404, 419, 500, 503)

### 🚧 Sedang Dikerjakan (FASE 5)

- [ ] Polish tampilan mobile
- [ ] Full README + screenshots
- [ ] Setup GitHub repository

### 📅 Akan Datang (FASE 6)

- [ ] Deploy ke Railway/Fly.io (trial 1 bulan)
- [ ] Testing menyeluruh
- [ ] Demo & handover ke Bu Lin & Rikza
- [ ] Analytics & monitoring

---

## 🤝 Kontribusi

Kontribusi welcome! Caranya:

1. **Fork** repo ini
2. **Bikin branch** (`git checkout -b fitur/FiturBaru`)
3. **Commit** (`git commit -m 'feat: tambah FiturBaru'`)
4. **Push** (`git push origin fitur/FiturBaru`)
5. **Buka Pull Request**

### 📝 Coding Standards

- Pakai **PSR-12** untuk PHP
- Nama **camelCase** untuk method, **snake_case** untuk database
- Commit message pakai **conventional commits** (`feat:`, `fix:`, `docs:`, `refactor:`)

---

## 👨‍💻 Developer

<div align="center">

**M Raffa Izzel H**

*Full Stack Developer*

[![GitHub](https://img.shields.io/badge/GitHub-RaffaHmii-181717?style=for-the-badge&logo=github)](https://github.com/RaffaHmii)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-Raffa_Izzel-0077B5?style=for-the-badge&logo=linkedin)](https://linkedin.com/in/raffa-izzel)
[![Email](https://img.shields.io/badge/Email-1mraffaizzelh@gmail.com-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:1mraffaizzelh@gmail.com)

</div>

---

## 🙏 Credits

- **Kesenian Giri Adiwarna SMKN 1 Banjar** — Kepercayaan & dukungan
- **Bu Lin Karlina** — Pembina yang selalu support
- **Rikza Fariq Harii** — Ketua yang kooperatif
- **Laravel Community** — Framework luar biasa
- **Tailwind Labs** — Design system keren
- **Alpine.js** — JavaScript yang ringan
- **Open Source Community** — Semua library yang dipakai

---

## 📄 Lisensi

MIT License — bebas dipakai, dimodifikasi, dan didistribusikan dengan mencantumkan credit.

```
MIT License

Copyright (c) 2026 M Raffa Izzel H

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

<div align="center">

### ⭐ Kalau project ini bermanfaat, kasih bintang di GitHub! ⭐

**Made with M Raffa in Banjar, Jawa Barat**

🎭 **1 Suara · 1 Rasa · 1 Extra · We Are The Best Yes** 🎭

---

<img src="kesenian/public/images/logo.png" alt="Giri Adiwarna" width="80" />

</div>
```

---
