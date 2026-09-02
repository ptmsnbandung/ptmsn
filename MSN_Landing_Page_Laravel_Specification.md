# MSN Landing Page — Laravel Rebuild Specification

> **Project:** PT Media Solusi Network (MSN) / ISP Landing Page  
> **Framework:** Laravel + Blade + Vite  
> **Reference:** Screenshot landing page yang diberikan user  
> **Goal:** Rebuild dengan struktur dan informasi yang sama, tetapi UI dibuat jauh lebih modern, elegan, profesional, responsive, dan premium.

---

## 1. Tujuan Project

Buat ulang landing page PT Media Solusi Network menggunakan Laravel.

Landing page harus terasa seperti website perusahaan ISP profesional, bukan template generik.

Prioritas desain:

1. Professional
2. Elegant
3. Modern
4. Clean
5. Premium
6. Responsive
7. Fast loading
8. SEO friendly
9. Mudah dikembangkan
10. Memiliki animasi yang halus

Screenshot hanya menjadi **referensi layout dan konten**, bukan untuk disalin secara pixel-perfect.

---

# 2. Tech Stack

Gunakan:

- Laravel versi stabil yang kompatibel dengan project
- PHP 8.2+
- Blade
- Vite
- Bootstrap 5.3 **atau** Tailwind CSS
- JavaScript ES6+
- CSS custom
- Bootstrap Icons / Lucide Icons
- SweetAlert2 jika diperlukan
- Google Fonts
- Intersection Observer / AOS untuk scroll animation
- MySQL untuk data dinamis

Gunakan komponen Blade reusable.

---

# 3. Struktur Project

Gunakan struktur:

```text
app/
├── Http/
│   └── Controllers/
│       ├── HomeController.php
│       ├── ContactController.php
│       └── CoverageController.php
│
├── Models/
│   ├── Package.php
│   ├── Service.php
│   ├── Portfolio.php
│   ├── Client.php
│   └── ContactMessage.php
│
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   │
│   ├── components/
│   │   ├── navbar.blade.php
│   │   ├── hero.blade.php
│   │   ├── section-title.blade.php
│   │   ├── about.blade.php
│   │   ├── service-card.blade.php
│   │   ├── package-card.blade.php
│   │   ├── portfolio.blade.php
│   │   ├── client-logos.blade.php
│   │   ├── coverage-checker.blade.php
│   │   ├── contact.blade.php
│   │   ├── footer.blade.php
│   │   └── floating-whatsapp.blade.php
│   │
│   └── home.blade.php
│
├── css/
│   └── app.css
│
└── js/
    └── app.js

public/
├── images/
│   ├── logo/
│   ├── hero/
│   ├── about/
│   ├── services/
│   ├── packages/
│   ├── portfolio/
│   └── clients/
│
└── favicon.ico

routes/
└── web.php

database/
├── migrations/
└── seeders/
```

---

# 4. Page Structure

Urutan section utama:

```text
1. Navbar
2. Hero
3. Tentang Kami
4. Layanan / Keunggulan
5. Paket Internet
6. Portfolio
7. Client
8. Coverage Checker
9. CTA
10. Kontak
11. Footer
12. Floating WhatsApp
```

Gunakan smooth scrolling antar-section.

---

# 5. Design System

## Primary Color

Gunakan identitas warna MSN dengan warna utama:

```text
#48B5C3
```

Secondary:

```text
#0EA5E9
#2563EB
#1E3A8A
```

Dark:

```text
#0F172A
#111827
```

Neutral:

```text
#F8FAFC
#F1F5F9
#E2E8F0
#FFFFFF
```

## Gradient

Gunakan gradient dengan sangat halus.

Contoh:

```css
linear-gradient(135deg, #48B5C3, #2563EB);
```

Jangan membuat seluruh website terlalu penuh warna.

---

# 6. Typography

Gunakan font modern seperti:

```text
Inter
Poppins
Manrope
```

Rekomendasi:

- Heading: Poppins / Manrope
- Body: Inter

Hierarchy:

```text
Hero H1       : 48–64px desktop
Section H2    : 32–42px
Card H3       : 18–22px
Body          : 15–17px
Small text    : 13–14px
```

Mobile:

```text
Hero H1       : 34–42px
Section H2    : 28–32px
```

---

# 7. Navbar

Navbar mengikuti konsep screenshot tetapi dibuat lebih premium.

Menu:

```text
Home
Tentang Kami
Layanan
Paket
Portfolio
Client
Coverage
Kontak
```

CTA:

```text
Berlangganan
```

### Desktop

- Logo kiri
- Navigation kanan/tengah
- CTA kanan
- Background putih/transparan
- Sticky

### Saat scroll

Navbar berubah menjadi:

```css
background: rgba(255,255,255,.90);
backdrop-filter: blur(14px);
box-shadow: 0 8px 30px rgba(...);
```

Tambahkan transition 300ms.

### Mobile

Gunakan hamburger menu.

Menu mobile harus rapi dan mudah disentuh.

---

# 8. Hero Section

Screenshot menunjukkan hero dengan:

- Area putih
- Heading di kiri
- Ilustrasi network/IT di kanan
- Aksen cyan
- Banyak whitespace

Pertahankan konsep ini.

## Heading

Gunakan:

```text
Get Your IT Solution
```

Alternatif subtitle:

```text
Solusi Internet & Teknologi
Untuk Kebutuhan Anda
```

## Description

```text
Nikmati koneksi internet cepat, stabil, dan terpercaya
untuk rumah, bisnis, maupun kebutuhan perusahaan.
```

## CTA

Primary:

```text
Berlangganan Sekarang
```

Secondary:

```text
Cek Coverage
```

## Hero Illustration

Gunakan ilustrasi:

- Fiber optic
- Internet
- Router
- Network
- Teknologi
- Customer support

Ilustrasi berada di sisi kanan.

Jika asset lama tersedia, gunakan asset tersebut. Jangan mengganti logo perusahaan dengan logo palsu.

---

# 9. Hero Animation

Ketika halaman pertama kali dibuka:

### Heading

```text
fade-up
```

### Description

```text
fade-up + delay
```

### Button

```text
fade-up + delay
```

### Illustration

```text
fade-right
```

Tambahkan floating animation ringan pada beberapa elemen dekoratif.

Durasi:

```text
600–900ms
```

Easing:

```text
ease-out
```

Hindari animasi yang membuat website terasa berat.

---

# 10. Tentang Kami

Pada screenshot terdapat section:

```text
Tentang Kami
```

Kemudian layout dua kolom.

### Heading

```text
Tentang Kami
```

Subtitle:

```text
Mengenal lebih dekat PT Media Solusi Network
```

### Content

Judul:

```text
PT Media Solusi Network
```

Isi:

```text
PT Media Solusi Network merupakan perusahaan yang bergerak
di bidang layanan internet dan solusi teknologi informasi.
Kami menghadirkan konektivitas yang cepat, stabil, dan
dapat diandalkan untuk kebutuhan rumah, bisnis, dan perusahaan.
```

Buat teks dapat diganti dari database/config.

### Layout

Desktop:

```text
[ Illustration ] [ Text ]
```

Mobile:

```text
[ Illustration ]
[ Text ]
```

Tambahkan statistik kecil:

```text
+X
Pelanggan

+X
Area Coverage

24/7
Support
```

Nilai harus mudah dikonfigurasi.

---

# 11. Services / Keunggulan

Pada screenshot terdapat 3 card:

```text
IT
Software Development
IT Support
```

Buat menjadi section layanan.

## Card 1

### IT

```text
Solusi teknologi informasi untuk membantu
operasional bisnis menjadi lebih efektif.
```

Icon:

```text
wifi/network/server
```

## Card 2

### Software Development

```text
Pengembangan aplikasi dan sistem informasi
sesuai kebutuhan bisnis.
```

Icon:

```text
code
```

## Card 3

### IT Support

```text
Dukungan teknis untuk menjaga sistem dan
infrastruktur tetap berjalan optimal.
```

Icon:

```text
headset / support
```

### Design Card

Gunakan:

- White background
- Border subtle
- Radius 20px
- Shadow lembut
- Icon dalam circular container
- Hover lift
- Gradient glow tipis

Hover:

```text
translateY(-8px)
```

---

# 12. Paket Internet

Screenshot menunjukkan 4 paket:

```text
BRONZE
SILVER
GOLD
PLATINUM
```

Pertahankan struktur tersebut.

## Bronze

```text
15 Mbps
Rp 200.000 / bulan
```

## Silver

```text
20 Mbps
Rp 225.000 / bulan
```

## Gold

```text
25 Mbps
Rp 250.000 / bulan
```

## Platinum

```text
30 Mbps
Rp 300.000 / bulan
```

> Harga dan speed harus dibuat dinamis sehingga mudah diubah dari database.

### Card Package

Setiap card:

```text
Nama Paket
Speed
Harga
Periode
Feature list
CTA
```

Contoh:

```text
BRONZE

15 Mbps

Rp 200.000
/bulan

✓ Internet Unlimited
✓ Fiber Optic
✓ Customer Support
✓ Instalasi
```

CTA:

```text
Berlangganan
```

---

# 13. Highlight Paket

Paket Silver/GOLD dapat diberikan status:

```text
Paling Populer
```

Gunakan badge kecil.

Card populer dibuat sedikit lebih menonjol:

```text
scale(1.03)
```

Namun tetap menjaga keseragaman.

---

# 14. Package Hover

Ketika mouse hover:

- Card naik sedikit
- Shadow meningkat
- Border berubah menjadi warna primary
- CTA sedikit berubah
- Feature icon bergerak sangat halus

Jangan menggunakan transform berlebihan.

---

# 15. Portfolio

Screenshot menunjukkan section:

```text
Portfolio
```

Berisi beberapa logo/portfolio project.

Buat:

```text
Portfolio
```

Subtitle:

```text
Berbagai solusi teknologi yang telah kami kembangkan
untuk mendukung kebutuhan bisnis dan organisasi.
```

Tampilkan dalam grid.

Contoh:

```text
[ Project 1 ]
[ Project 2 ]
[ Project 3 ]
[ Project 4 ]
```

Setiap item:

- Logo/image
- Nama project
- Kategori
- Short description

Hover:

```text
image scale 1.04
overlay
project information
```

---

# 16. Client Section

Pada screenshot terdapat banyak logo client.

Buat section:

```text
Client
```

Subtitle:

```text
Dipercaya oleh berbagai perusahaan dan organisasi
```

Gunakan grid logo.

Logo harus:

- Tidak pecah
- Background transparan jika memungkinkan
- Ukuran konsisten
- `object-fit: contain`

### Hover

Logo:

```text
grayscale(100%)
```

menjadi:

```text
grayscale(0%)
```

atau opacity meningkat.

Jangan mengubah logo client secara paksa.

---

# 17. Coverage Checker

Buat section untuk mengecek area layanan.

Heading:

```text
Cek Coverage
```

Description:

```text
Cari tahu apakah lokasi Anda sudah terjangkau
jaringan PT Media Solusi Network.
```

Input:

```text
Masukkan alamat atau lokasi
```

Button:

```text
Cek Coverage
```

Jika sistem coverage sudah tersedia, integrasikan API/database yang ada.

Status:

### Covered

```text
✓ Lokasi Anda tercover
```

### Not Covered

```text
× Maaf, lokasi Anda belum tercover
```

Jangan membuat hasil coverage palsu.

---

# 18. CTA

Tambahkan section CTA sebelum kontak.

Contoh:

```text
Siap Mendapatkan Internet
yang Lebih Cepat dan Stabil?
```

Description:

```text
Hubungi kami dan konsultasikan kebutuhan internet
dan teknologi untuk Anda.
```

Button:

```text
Hubungi Kami
```

Design:

- Gradient cyan → blue
- Rounded 24px
- Decorative network pattern
- White text
- Subtle glow

---

# 19. Contact Section

Screenshot menampilkan:

```text
Kontak
```

Buat layout:

```text
[ Kontak Perusahaan ] [ Form Kontak ]
```

## Informasi

```text
Kantor Operasional
Alamat perusahaan

Kontak
Nomor telepon

Email
Email perusahaan

Jam Operasional
Senin - Jumat
08.00 - 17.00
```

Gunakan icon untuk masing-masing informasi.

---

# 20. Contact Form

Fields:

```text
Nama Lengkap
Email
No. WhatsApp
Subjek
Pesan
```

Button:

```text
Kirim Pesan
```

Validation Laravel:

```text
nama       required|string|max:100
email      required|email
whatsapp   required|string|max:20
subjek     required|string|max:150
pesan      required|string
```

Tampilkan SweetAlert setelah berhasil:

```text
Pesan berhasil dikirim.
```

Jika gagal:

```text
Terjadi kesalahan.
Silakan coba kembali.
```

Jangan menampilkan error mentah server kepada user.

---

# 21. Floating WhatsApp

Tambahkan tombol WhatsApp floating seperti screenshot.

Posisi:

```text
fixed
right: 20px
bottom: 20px
```

Design:

- Circular
- WhatsApp icon
- Green
- Shadow
- Tooltip

Tooltip:

```text
Chat WhatsApp
```

Klik membuka WhatsApp dengan pesan otomatis:

```text
Halo PT Media Solusi Network, saya ingin mendapatkan informasi mengenai layanan internet.
```

Nomor WhatsApp harus disimpan di:

```text
config/company.php
```

bukan hard-code di banyak file.

---

# 22. Footer

Footer harus lebih profesional daripada screenshot.

Isi:

### Company

```text
Tentang Kami
Layanan
Portfolio
Client
```

### Services

```text
Internet
IT Solution
Software Development
IT Support
```

### Support

```text
Coverage
FAQ
Kontak
WhatsApp
```

### Social Media

Tambahkan:

```text
Instagram
Facebook
LinkedIn
YouTube
```

Jika akun tersedia.

Bottom:

```text
© 2026 PT Media Solusi Network. All Rights Reserved.
```

---

# 23. Responsive Design

WAJIB responsive.

Breakpoint minimal:

```text
Mobile      < 576px
Tablet      576px – 991px
Desktop     >= 992px
Large       >= 1200px
```

### Mobile

Pastikan:

- Tidak ada horizontal overflow
- Navbar menjadi hamburger
- Hero satu kolom
- About satu kolom
- Service cards satu kolom
- Package cards satu kolom
- Portfolio 1–2 kolom
- Client logos 3–4 kolom
- Contact satu kolom
- Footer menjadi stacked

---

# 24. Animation System

Gunakan animasi dengan prinsip:

```text
subtle
smooth
premium
```

Animasi yang boleh:

```text
fade-up
fade-down
fade-left
fade-right
scale
hover lift
floating
```

Gunakan Intersection Observer atau AOS.

Contoh:

```html
data-aos="fade-up"
```

Jangan semua elemen diberi animasi.

Prioritas:

- Hero
- Section title
- Cards
- Portfolio
- CTA

---

# 25. Scroll Experience

Tambahkan:

- Smooth scroll
- Active navbar section
- Navbar berubah saat scroll
- Back to top button
- Progress indicator opsional

Back to top muncul setelah user scroll:

```text
300px
```

---

# 26. SEO

`<head>` wajib memiliki:

```html
<title>PT Media Solusi Network — Internet & IT Solution</title>

<meta
    name="description"
    content="PT Media Solusi Network menyediakan layanan internet dan solusi teknologi untuk rumah, bisnis, dan perusahaan."
>

<meta name="keywords"
      content="internet, ISP, fiber optic, internet cepat, IT solution, PT Media Solusi Network">
```

Tambahkan:

- Open Graph
- Twitter Card
- Canonical URL
- Favicon
- Structured Data Organization/LocalBusiness jika datanya tersedia

---

# 27. Performance

WAJIB:

- Lazy load image
- Gunakan WebP jika memungkinkan
- Compress image
- Jangan menggunakan video besar sebagai background
- Minimize CSS/JS
- Gunakan Vite
- Hindari library yang tidak diperlukan
- Gunakan SVG untuk icon sederhana

Image:

```html
loading="lazy"
```

Untuk hero image jangan lazy load jika berada di viewport pertama.

---

# 28. Accessibility

Pastikan:

- Semua image memiliki `alt`
- Button memiliki label jelas
- Contrast cukup
- Form memiliki label
- Keyboard navigation bekerja
- Focus state terlihat
- Jangan hanya menggunakan warna untuk status

---

# 29. Database

Untuk tahap awal gunakan database untuk konten yang kemungkinan sering berubah.

Model:

```text
Package
Service
Portfolio
Client
ContactMessage
```

## packages

```text
id
name
speed
price
period
description
is_popular
is_active
sort_order
created_at
updated_at
```

## services

```text
id
title
slug
description
icon
is_active
sort_order
created_at
updated_at
```

## portfolios

```text
id
title
category
description
image
url
is_active
sort_order
created_at
updated_at
```

## clients

```text
id
name
logo
url
is_active
sort_order
created_at
updated_at
```

## contact_messages

```text
id
name
email
whatsapp
subject
message
status
created_at
updated_at
```

---

# 30. Seeder

Buat seeder awal untuk:

### Packages

```text
Bronze
15 Mbps
200000

Silver
20 Mbps
225000

Gold
25 Mbps
250000

Platinum
30 Mbps
300000
```

### Services

```text
IT
Software Development
IT Support
```

Jangan memasukkan data client/portfolio yang belum diketahui secara pasti.

Untuk logo, gunakan asset yang diberikan user.

---

# 31. Controller

HomeController:

```php
public function index()
{
    $packages = Package::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $services = Service::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $portfolios = Portfolio::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $clients = Client::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    return view('home', compact(
        'packages',
        'services',
        'portfolios',
        'clients'
    ));
}
```

---

# 32. Routes

Gunakan:

```php
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::post('/coverage/check', [CoverageController::class, 'check'])
    ->name('coverage.check');
```

Gunakan route name daripada hard-code URL.

---

# 33. Blade Component

Gunakan component:

```blade
<x-navbar />

<x-hero />

<x-about />

<x-service-card />

<x-package-card />

<x-portfolio />

<x-client-logos />

<x-coverage-checker />

<x-contact />

<x-footer />

<x-floating-whatsapp />
```

Jangan membuat `home.blade.php` menjadi file yang terlalu besar.

---

# 34. Component Package Card

Gunakan:

```blade
<x-package-card
    :package="$package"
/>
```

Component harus menangani:

```text
nama
speed
harga
feature
popular badge
CTA
```

Format harga menggunakan:

```php
number_format($package->price, 0, ',', '.')
```

Output:

```text
Rp 200.000
```

---

# 35. Config Company

Buat:

```text
config/company.php
```

Contoh:

```php
return [
    'name' => 'PT Media Solusi Network',
    'short_name' => 'MSN',
    'phone' => '',
    'whatsapp' => '',
    'email' => '',
    'address' => '',
    'instagram' => '',
    'facebook' => '',
    'linkedin' => '',
];
```

Data yang belum diketahui jangan dibuat-buat.

---

# 36. Visual Rules

## DO

Gunakan:

- Banyak whitespace
- Grid rapi
- Border subtle
- Shadow lembut
- Gradient halus
- Rounded corner modern
- Typography konsisten
- Icon konsisten
- Animasi halus
- Hover elegant
- Responsive layout

## DON'T

Jangan:

- Menggunakan terlalu banyak warna
- Menggunakan animasi berlebihan
- Menggunakan shadow hitam pekat
- Menggunakan font terlalu banyak
- Menggunakan card dengan border tebal
- Membuat tombol terlalu besar
- Membuat section terlalu padat
- Membuat website terlihat seperti template murah
- Menggunakan data perusahaan yang tidak diketahui
- Menggunakan logo palsu

---

# 37. Premium UI Rules

Gunakan prinsip:

```text
Whitespace > Decoration
Consistency > Complexity
Subtle Animation > Excessive Animation
Typography > Excessive Graphics
Quality > Quantity
```

Gunakan radius:

```text
Small: 10px
Medium: 16px
Large: 24px
```

Shadow:

```text
soft
low opacity
large blur
```

Contoh:

```css
box-shadow:
    0 10px 30px rgba(15, 23, 42, 0.08);
```

---

# 38. Desktop Layout

Container maksimal:

```text
1200px
```

Gunakan:

```css
.container {
    max-width: 1200px;
}
```

Section vertical spacing:

```text
Desktop: 90–120px
Tablet : 70–90px
Mobile : 60–80px
```

Jangan membuat section terlalu pendek.

---

# 39. Screenshot Matching

Pertahankan karakteristik utama screenshot:

```text
WHITE SPACE
     ↓
Hero dengan ilustrasi kanan
     ↓
Tentang Kami
     ↓
About image + text
     ↓
3 service cards
     ↓
4 package cards
     ↓
Portfolio
     ↓
Client logos
     ↓
Coverage
     ↓
Kontak
     ↓
Footer
```

Tetapi hasil akhir harus terlihat lebih modern dan profesional daripada screenshot.

---

# 40. Asset Management

Gunakan:

```text
public/images/
```

Struktur:

```text
images/
├── logo/
│   └── logo.png
├── hero/
│   └── hero.png
├── about/
│   └── about.png
├── services/
├── packages/
├── portfolio/
└── clients/
```

Gunakan helper:

```blade
{{ asset('images/hero/hero.png') }}
```

Jangan hard-code path.

---

# 41. Final Acceptance Criteria

Landing page dianggap selesai jika:

- [ ] Laravel berjalan tanpa error
- [ ] Semua route berjalan
- [ ] Navbar responsive
- [ ] Hero sesuai konsep screenshot
- [ ] About section tersedia
- [ ] Service section tersedia
- [ ] 4 package tersedia
- [ ] Package berasal dari database
- [ ] Portfolio tersedia
- [ ] Client logo tersedia
- [ ] Coverage checker tersedia
- [ ] Contact form bekerja
- [ ] Validation bekerja
- [ ] WhatsApp floating button bekerja
- [ ] Footer lengkap
- [ ] Responsive mobile
- [ ] Responsive tablet
- [ ] Responsive desktop
- [ ] Animasi halus
- [ ] Tidak ada horizontal overflow
- [ ] SEO dasar tersedia
- [ ] Image menggunakan alt
- [ ] Asset menggunakan Vite/public dengan benar
- [ ] Tidak ada data perusahaan fiktif
- [ ] Tidak ada hard-coded data yang seharusnya berasal dari database/config
- [ ] Tidak ada console error
- [ ] Tidak ada PHP/Laravel error
- [ ] UI terlihat premium dan profesional

---

# 42. Urutan Implementasi

Implementasikan bertahap:

## Phase 1 — Foundation

- Setup Laravel
- Setup Vite
- Setup CSS
- Setup layout
- Setup config/company.php
- Setup asset structure

## Phase 2 — Main UI

- Navbar
- Hero
- About
- Services
- Packages

## Phase 3 — Business Content

- Portfolio
- Client
- Coverage
- CTA
- Contact
- Footer

## Phase 4 — Backend

- Migration
- Model
- Seeder
- Controller
- Validation
- Contact form

## Phase 5 — Animation

- Scroll animation
- Hover animation
- Navbar transition
- Floating effects
- Smooth scrolling

## Phase 6 — Optimization

- Responsive testing
- SEO
- Accessibility
- Image optimization
- Performance
- Browser testing

---

# 43. Instruksi Untuk AI Coding Agent

Jika file ini diberikan kepada AI coding agent, agent harus:

1. Membaca file ini terlebih dahulu.
2. Memeriksa struktur Laravel yang sudah ada.
3. Jangan menghapus fitur existing tanpa alasan.
4. Jangan mengganti konfigurasi penting secara sembarangan.
5. Gunakan Blade component.
6. Gunakan database untuk data dinamis.
7. Jangan membuat data perusahaan yang tidak diberikan.
8. Jangan menggunakan placeholder yang terlihat seperti data asli.
9. Jangan membuat logo perusahaan palsu.
10. Gunakan asset yang tersedia.
11. Jika asset belum tersedia, gunakan placeholder visual yang jelas dan mudah diganti.
12. Pastikan setiap perubahan dapat dijalankan.
13. Setelah implementasi, lakukan pengecekan route.
14. Periksa responsive layout.
15. Periksa console error.
16. Periksa Laravel error.
17. Pastikan tidak ada horizontal overflow.
18. Pastikan desain lebih modern daripada screenshot.
19. Jangan mengorbankan readability demi efek visual.
20. Jangan membuat UI terlalu ramai.

---

# 44. Target Visual Akhir

Target akhir:

```text
PT MEDIA SOLUSI NETWORK
        ↓
Modern ISP Company Website
        ↓
Clean + Elegant + Premium
        ↓
White Space
        ↓
Cyan / Blue Accent
        ↓
Smooth Animation
        ↓
Professional Typography
        ↓
Responsive
        ↓
Fast
        ↓
SEO Friendly
```

Landing page harus memberikan kesan:

> **"PT Media Solusi Network adalah perusahaan ISP dan teknologi yang profesional, modern, terpercaya, dan siap melayani kebutuhan pelanggan."**

---

# 45. Prioritas Utama

Jika harus memilih antara efek visual dan usability:

```text
1. Usability
2. Responsive
3. Performance
4. Accessibility
5. Visual consistency
6. Animation
```

**Jangan membuat efek 3D/animasi yang mengganggu user.**

Gunakan 3D hanya sebagai aksen visual ringan, bukan sebagai elemen utama.

---

## End of Specification
