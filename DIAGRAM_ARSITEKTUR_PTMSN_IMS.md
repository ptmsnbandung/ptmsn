# Dokumentasi Arsitektur & Diagram Sistem
## MyMSN Customer Self-Care Portal (`ptmsn`) & Integrated Management System (`ims_v2`)

Dokumen ini berisi spesifikasi teknis dan visualisasi diagram Mermaid lengkap untuk ekosistem aplikasi **PT Media Solusi Network (PT MSN)**.

---

### Informasi Aplikasi
- **Nama Aplikasi**: MyMSN Customer Self-Care Portal (`ptmsn`) & Integrated Management System (`ims_v2`)
- **Deskripsi**: Ekosistem layanan ISP PT Media Solusi Network yang mencakup portal mandiri pelanggan (Self-Care), manajemen operasional & billing finance (IMS-v2), sistem ticketing gangguan/NOC, dan gateway pembayaran otomatis/transfer bank.
- **Aktor**: 
  1. **Pelanggan (Customer)**: Mengakses dashboard layanan, membuat tiket kendala, membayar tagihan via Midtrans/Transfer Bank, dan memperbarui email notifikasi.
  2. **Admin / Finance / NOC Staff**: Mengelola data pelanggan, memverifikasi bukti transfer, menangani tiket gangguan teknis, dan mengontrol status registrasi/billing di IMS-v2.
  3. **Payment Gateway (Midtrans)**: Memproses transaksi pembayaran otomatis dan mengirim webhook callback status pelunasan.
- **Teknologi**: Laravel 11/12 + Blade + Tailwind CSS + Alpine.js + MySQL / MariaDB (Database `ims_v3` & `mysql`) + Midtrans API.

---

### 1. Flowchart Alur Utama Aplikasi (`flowchart TD`)
Diagram ini memodelkan alur lengkap aplikasi mulai dari user membuka halaman login, validasi autentikasi, pengecekan `is_login` database untuk verifikasi email & onboarding tour, hingga transaksi tagihan dan logout.

```mermaid
flowchart TD
    Start([Mulai: User Akses Portal]) --> InputLogin[/Input Nomor Internet atau No. WhatsApp/]
    InputLogin --> SubmitLogin[Klik Tombol Masuk]
    
    SubmitLogin --> ValidasiLogin{Validasi Data Pelanggan?}
    ValidasiLogin -- Tidak Ditemukan --> ErrorLogin[Tampilkan Pesan Error: Nomor Tidak Terdaftar]
    ErrorLogin --> InputLogin
    
    ValidasiLogin -- Ditemukan --> CheckIsLogin{is_login == 0 di Database IMS?}
    
    %% Alur Onboarding Perdana
    CheckIsLogin -- Ya: Pelanggan Baru / is_login=0 --> ModalEmail[Buka Modal Pengecekan & Verifikasi Email]
    ModalEmail --> CekEmailInput{Pilihan Pelanggan}
    CekEmailInput -- Ya: Email Aktif --> StartTour[Mulai Onboarding Tour 5 Langkah]
    CekEmailInput -- Ubah/Isi Email Baru --> SubmitEmail[Kirim AJAX POST update-email]
    SubmitEmail --> SimpanEmailDb[(Simpan ke m_pelanggan)]
    SimpanEmailDb --> StartTour
    
    StartTour --> StepTour[Jalankan Tour: Beranda -> Tiket NOC -> Billing Tagihan]
    StepTour --> CompleteTour[Selesai Tour: Kirim POST completeOnboarding]
    CompleteTour --> UpdateIsLogin[(Update is_login = 1 di trx_batchjob_register)]
    UpdateIsLogin --> DashboardView
    
    %% Alur Normal Dashboard
    CheckIsLogin -- Tidak: Sudah Pernah Login --> DashboardView[Tampil Halaman Dashboard MyMSN]
    
    DashboardView --> MenuPilihan{Pilih Aktivitas}
    
    %% Alur Tiket Gangguan
    MenuPilihan -- Tiket Kendala --> MenuTiket[Buka Menu Laporan Gangguan]
    MenuTiket --> FormTiket[/Isi Deskripsi & Upload Foto Kendala/]
    FormTiket --> SubmitTiket[Simpan Tiket Baru ke trx_tiket_gangguan]
    SubmitTiket --> TrackingTiket[Pantau Progres Penanganan Teknisi NOC]
    
    %% Alur Pembayaran Tagihan
    MenuPilihan -- Bayar Tagihan --> MenuBilling[Buka Menu Tagihan & Invoice]
    MenuBilling --> CekStatusBayar{Status Tagihan?}
    CekStatusBayar -- Lunas --> DownloadKwitansi[Unduh / Cetak Bukti Pembayaran]
    CekStatusBayar -- Belum Lunas --> PilihMetodeBayar{Pilih Metode Bayar}
    
    PilihMetodeBayar -- Midtrans Otomatis --> SnapPopup[Buka Midtrans Snap: QRIS/VA/E-Wallet]
    SnapPopup --> WebhookNotif[(Webhook Midtrans Update is_paid = 1)]
    
    PilihMetodeBayar -- Transfer Bank Manual --> UploadBukti[/Upload Foto Bukti Transfer/]
    UploadBukti --> SimpanBuktiTransfer[(Simpan ke bayar_transfer & Sinkron ke IMS-v2)]
    SimpanBuktiTransfer --> VerifFinance[Finance IMS-v2 Verifikasi Pembayaran]
    
    %% Alur Selesai & Logout
    TrackingTiket --> DashboardView
    DownloadKwitansi --> DashboardView
    WebhookNotif --> DashboardView
    VerifFinance --> DashboardView
    
    MenuPilihan -- Logout --> ProsesLogout[Hapus Sesi & Invalidate Token]
    ProsesLogout --> Selesai([Selesai: Kembali ke Halaman Login])
```

---

### 2. Entity Relationship Diagram / ERD (`erDiagram`)
Diagram ini menggambarkan struktur relasi tabel antara database portal pelanggan (`ptmsn`) dan database manajemen IMS (`ims_v3`) beserta kardinalitasnya.

```mermaid
erDiagram
    TRX_BATCHJOB_REGISTER ||--|| M_PELANGGAN : "nik_penduduk"
    TRX_BATCHJOB_REGISTER ||--o{ TRX_TIKET_GANGGUAN : "nomor_internet"
    TRX_BATCHJOB_REGISTER ||--o{ TRX_BILLING_LAYANAN : "nomor_internet"
    TRX_BATCHJOB_REGISTER ||--o{ TRX_UBAH_LAYANAN : "nomor_internet"
    TRX_BATCHJOB_REGISTER ||--o{ TRX_SUSPEND : "nomor_internet"
    TRX_BATCHJOB_REGISTER ||--o{ TRX_TERMINASI : "nomor_internet"
    TRX_BATCHJOB_REGISTER }o--|| M_BANDWITH : "kode_bandwith"
    TRX_BATCHJOB_REGISTER }o--|| M_STATUS_REGISTRASI : "status_reg"
    TRX_BILLING_LAYANAN ||--o{ BAYAR_TRANSFER : "kode_billing / nomor_internet"

    TRX_BATCHJOB_REGISTER {
        string nomor_internet PK "ID Pelanggan (Primary Key)"
        string nik_penduduk FK "NIK Identitas Pelanggan"
        string kode_bandwith FK "Paket Kecepatan Bandwidth"
        string status_reg FK "Kode Status Registrasi"
        string nama_pelanggan "Nama Lengkap"
        string alamat_pasang "Alamat Pemasangan"
        int is_login "0 = Wajib Onboarding, 1 = Sudah Login"
        int is_suspend "Status Suspend Layanan"
        int periode_billing "Tanggal Jatuh Tempo Bulanan"
        date date_create "Tanggal Mulai Berlangganan"
    }

    M_PELANGGAN {
        string nik_penduduk PK "NIK Pelanggan"
        string nama_pelanggan "Nama Sesuai KTP"
        string nomor_hp "Nomor WhatsApp Utama"
        string nomor_hp_2 "Nomor Kontak Alternatif"
        string email "Alamat Email Notifikasi"
        string alamat "Alamat Domisili"
    }

    M_BANDWITH {
        string kode_bandwith PK "Kode Paket"
        string nama_bandwith "Nama Paket Layanan"
        int nominal_bandwith "Kecepatan (Mbps)"
        decimal harga_bandwith "Harga Tagihan Bulanan"
    }

    M_STATUS_REGISTRASI {
        string status_reg PK "Kode Status"
        string desc_registrasi "Deskripsi Status (Aktif, Terminasi, dll)"
    }

    TRX_TIKET_GANGGUAN {
        int id_tiket PK "Auto Increment"
        string nomor_internet FK "Nomor Internet Pelanggan"
        string keluhan "Rincian Kendala Koneksi"
        string foto_kendala "File Bukti Foto Gangguan"
        string status "open / proses / resolved / closed"
        datetime date_create "Waktu Laporan Dibuat"
    }

    TRX_BILLING_LAYANAN {
        string kode_billing PK "Nomor Invoice Tagihan"
        string nomor_internet FK "Nomor Internet Pelanggan"
        int bulan_billing "Bulan Tagihan (1-12)"
        int tahun_billing "Tahun Tagihan"
        decimal total_bayar "Nominal Tagihan"
        int is_paid "0 = Belum Lunas, 1 = Lunas"
        string metode_bayar "midtrans / transfer / cash"
        datetime tgl_bayar "Waktu Pembayaran Dilakukan"
    }

    BAYAR_TRANSFER {
        int id PK "Primary Key"
        string nomor_internet FK "Nomor Internet Pelanggan"
        string kode_billing "Kode Tagihan Terkait"
        string bank_tujuan "Bank Rekening Tujuan"
        string file_bukti "Path File Bukti Transfer"
        decimal nominal_transfer "Nominal yang Ditransfer"
        datetime tgl_upload "Waktu Upload Bukti"
        string status_verifikasi "pending / approved / rejected"
    }
```

---

### 3. Sequence Diagram: Proses Transaksi & CRUD (`sequenceDiagram`)
Diagram ini memodelkan interaksi step-by-step antar komponen saat pelanggan melakukan **Verifikasi & Update Email** serta proses **Pembayaran Transfer & Sinkronisasi ke IMS-v2**.

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Pelanggan
    participant Frontend as Frontend (Blade + Alpine.js)
    participant Backend as Backend (Laravel Controller)
    participant Database as Database (IMS v3 & MySQL)
    participant AdminIMS as Staff Finance (IMS-v2)

    %% Skenario 1: Update Email Saat Onboarding
    Note over Customer,Database: Skenario 1: Pengecekan & Update Email Pelanggan
    Customer->>Frontend: Buka Modal Email & Masukkan Email Baru
    Frontend->>Frontend: Validasi Format Email Regex Client-Side
    Frontend->>Backend: POST /portal/profile/update-email (email, CSRF Token)
    Backend->>Backend: Validasi Request: required|email|max:255
    Backend->>Database: UPDATE m_pelanggan SET email = :email WHERE nik_penduduk = :nik
    Database-->>Backend: Query OK (Row Updated)
    Backend-->>Frontend: JSON Response: { success: true, email: '...' }
    Frontend-->>Customer: Tampilkan SweetAlert Sukses & Lanjut ke Tutorial

    %% Skenario 2: Pembayaran Konfirmasi Transfer
    Note over Customer,AdminIMS: Skenario 2: Upload Bukti Transfer & Sinkronisasi IMS-v2
    Customer->>Frontend: Upload Bukti Transfer & Input Bank Tujuan
    Frontend->>Backend: POST /portal/tagihan/{invoice}/transfer-confirm (File Image, Bank)
    Backend->>Backend: Simpan Gambar ke Storage (public/uploads/bukti_transfer)
    Backend->>Database: INSERT INTO bayar_transfer (nomor_internet, kode_billing, file_bukti)
    Backend->>Database: UPDATE trx_billing_layanan SET metode_bayar = 'transfer'
    Database-->>Backend: Record Saved
    Backend-->>Frontend: Response 200 OK: "Bukti transfer berhasil dikirim"
    Frontend-->>Customer: Tampilkan Status "Menunggu Verifikasi Finance"

    %% Skenario 3: Verifikasi di IMS-v2
    Note over Database,AdminIMS: Skenario 3: Verifikasi Pembayaran oleh Finance di IMS-v2
    AdminIMS->>Backend: Akses Menu /finance/billing-layanan
    Backend->>Database: SELECT invoice, bukti_transfer FROM trx_billing_layanan JOIN bayar_transfer
    Database-->>Backend: Data Transaksi Pending
    Backend-->>AdminIMS: Tampilkan Tabel Tagihan dengan Thumbnail Bukti Transfer
    AdminIMS->>Backend: Klik "Verifikasi Lunas"
    Backend->>Database: UPDATE trx_billing_layanan SET is_paid = 1, tgl_bayar = NOW()
    Database-->>Backend: Status Lunas Tersimpan
    Backend-->>AdminIMS: Alert "Pembayaran Berhasil Diverifikasi"
```

---

### 4. Use Case Diagram
Diagram ini memetakan batasan hak akses dan fungsionalitas untuk masing-masing aktor di sistem portal MyMSN dan IMS-v2.

```mermaid
flowchart LR
    %% Aktor
    subgraph Actors [Aktor Sistem]
        C((Pelanggan / Customer))
        A((Admin / Finance / NOC))
        PG((Payment Gateway Midtrans))
    end

    %% Batasan Sistem MyMSN & IMS-v2
    subgraph System [Ekosistem MyMSN & IMS-v2]
        %% Portal Pelanggan Use Cases
        UC1([Login No. Internet / WA])
        UC2([Verifikasi & Update Email Notifikasi])
        UC3([Menjalankan Onboarding Tour Interaktif])
        UC4([Melihat Status Koneksi & KPI Layanan])
        UC5([Membuat Tiket Laporan Gangguan])
        UC6([Tracking Status Perbaikan Tiket])
        UC7([Melihat Rincian Tagihan & Invoice])
        UC8([Bayar Otomatis via Midtrans Snap])
        UC9([Upload Bukti Transfer Bank])
        UC10([Cetak Kuitansi Pembayaran])
        UC11([Mengajukan Upgrade / Terminasi Layanan])

        %% IMS-v2 Admin Use Cases
        UC12([Kelola Master Pelanggan & Paket])
        UC13([Monitoring & Verifikasi Billing Finance])
        UC14([Validasi Bukti Transfer Pembayaran])
        UC15([Penugasan Teknisi & Update Status Tiket NOC])
        UC16([Broadcast & Webhook Notification])
    end

    %% Relasi Pelanggan
    C --> UC1
    C --> UC2
    C --> UC3
    C --> UC4
    C --> UC5
    C --> UC6
    C --> UC7
    C --> UC8
    C --> UC9
    C --> UC10
    C --> UC11

    %% Relasi Admin IMS-v2
    A --> UC12
    A --> UC13
    A --> UC14
    A --> UC15

    %% Relasi Payment Gateway
    PG --> UC16
    UC8 -.->|include Webhook Callback| UC16
    UC16 -.->|update lunas| UC7
    UC9 -.->|extend verifikasi manual| UC14
```

---

### 5. Class Diagram (`classDiagram`)
Diagram ini menyajikan struktur kelas model Eloquent Laravel, Controller, relasi asosiasi, atribut, dan method utamanya.

```mermaid
classDiagram
    class Customer {
        +string nomor_internet
        +string nik_penduduk
        +string kode_bandwith
        +string status_reg
        +int is_login
        +int is_suspend
        +int periode_billing
        +date date_create
        +getCustomerIdAttribute() string
        +getNameAttribute() string
        +getEmailAttribute() string
        +getBillingStatusAttribute() string
        +getPackageAttribute() object
        +markAsLoggedIn() bool
        +pelanggan() Pelanggan
        +bandwith() Bandwith
        +tickets() HasMany
        +billingLayanan() HasMany
    }

    class Pelanggan {
        +string nik_penduduk
        +string nama_pelanggan
        +string nomor_hp
        +string email
        +string alamat
        +customer() HasOne
    }

    class Bandwith {
        +string kode_bandwith
        +string nama_bandwith
        +int nominal_bandwith
        +decimal harga_bandwith
    }

    class TiketGangguan {
        +int id_tiket
        +string nomor_internet
        +string keluhan
        +string foto_kendala
        +string status
        +datetime date_create
        +customer() BelongsTo
    }

    class BillingLayanan {
        +string kode_billing
        +string nomor_internet
        +int bulan_billing
        +int tahun_billing
        +decimal total_bayar
        +int is_paid
        +string metode_bayar
        +customer() BelongsTo
        +buktiTransfer() HasOne
    }

    class BayarTransfer {
        +int id
        +string nomor_internet
        +string kode_billing
        +string bank_tujuan
        +string file_bukti
        +string status_verifikasi
    }

    class ProfileController {
        +index() View
        +update(Request) RedirectResponse
        +updateEmailAjax(Request) JsonResponse
    }

    class DashboardController {
        +index() View
        +completeOnboarding(Request) JsonResponse
    }

    class BillingController {
        +index() View
        +payDirect(Request) JsonResponse
        +confirmTransfer(Request, invoice) RedirectResponse
        +handleNotification(Request) Response
    }

    %% Relasi Model
    Customer "1" <--> "1" Pelanggan : Relasi Biodata (nik_penduduk)
    Customer "n" --> "1" Bandwith : Relasi Paket (kode_bandwith)
    Customer "1" --> "n" TiketGangguan : Relasi Tiket NOC (nomor_internet)
    Customer "1" --> "n" BillingLayanan : Relasi Tagihan (nomor_internet)
    BillingLayanan "1" --> "0..1" BayarTransfer : Konfirmasi Transfer Manual

    %% Relasi Controller ke Model
    ProfileController ..> Customer : Mengelola Data Email & Profil
    DashboardController ..> Customer : Mengelola Dashboard & Onboarding
    BillingController ..> BillingLayanan : Mengelola Invoice & Webhook
```

---

### Asumsi Sistem:
1. **Multi-Database Connection**: Aplikasi `ptmsn` terhubung ke koneksi default `mysql` untuk data umum web/CMS dan koneksi `ims` yang mengarah ke database `ims_v3` (tabel master pelanggan, batchjob registrasi, dan billing).
2. **Autentikasi Customer**: Menggunakan guard `customer` berbasis nomor internet atau nomor WhatsApp terdaftar tanpa memerlukan input password manual demi kemudahan self-care pelanggan.
3. **Mekanisme Onboarding**: Nilai `is_login = 0` menandakan user baru pertama kali masuk sehingga otomatis diarahkan ke alur verifikasi email dan spotlight tour 5 langkah sebelum diupdate menjadi `1`.
