<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://www.yiiframework.com/image/design/logo/yii3_full_for_dark.svg">
        <source media="(prefers-color-scheme: light)" srcset="https://www.yiiframework.com/image/design/logo/yii3_full_for_light.svg">
        <img src="https://www.yiiframework.com/image/design/logo/yii3_full_for_light.svg" alt="Yii Framework" height="100">
    </picture>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg?style=for-the-badge&label=Stable&logo=packagist)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg?style=for-the-badge&label=Downloads)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://img.shields.io/github/actions/workflow/status/yiisoft/yii2-app-advanced/build.yml?style=for-the-badge&logo=github&label=Build)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)
[![Static Analysis](https://img.shields.io/github/actions/workflow/status/yiisoft/yii2-app-advanced/static.yml?style=for-the-badge&label=Static)](https://github.com/yiisoft/yii2-app-advanced/actions/workflows/static.yml)

## Docker

[![Apache](https://img.shields.io/github/actions/workflow/status/yiisoft/yii2-app-advanced/docker.yml?style=for-the-badge&logo=apache&label=Apache)](https://github.com/yiisoft/yii2-app-advanced/actions/workflows/docker.yml)

REQUIREMENTS
------------

> [!IMPORTANT]
> - The minimum required [PHP](https://www.php.net/) version of Yii is PHP `8.2`.

## Install via Composer

If you do not have [Composer](https://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following commands:

```bash
composer create-project --prefer-dist yiisoft/yii2-app-advanced advanced
cd advanced
```

### Frontend

<picture>
    <source media="(prefers-color-scheme: dark)" srcset="docs/images/frontend/home-dark.png">
    <source media="(prefers-color-scheme: light)" srcset="docs/images/frontend/home-light.png">
    <img src="docs/images/frontend/home-light.png" alt="Web Application Advanced - Frontend">
</picture>

### Backend

<picture>
    <source media="(prefers-color-scheme: dark)" srcset="docs/images/backend/home-dark.png">
    <source media="(prefers-color-scheme: light)" srcset="docs/images/backend/home-light.png">
    <img src="docs/images/backend/home-light.png" alt="Web Application Advanced - Backend">
</picture>

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

Initialize the application for the `Development` environment:

```bash
php init --env=Development --overwrite=All
```

Now you should be able to access the application through the following URLs, assuming `advanced` is the directory
directly under the Web root.

```
http://localhost/advanced/frontend/web/
http://localhost/advanced/backend/web/
```

## Install with Docker

Build and start the containers:

```bash
docker compose up -d --build
```

Install dependencies inside the container:

```bash
docker compose exec frontend composer update --prefer-dist --no-interaction
```

Initialize the application for the `Development` environment:

```bash
docker compose exec frontend php /app/init --env=Development --overwrite=All
```

After running `init`, update the database connection in `common/config/main-local.php` to use the `postgres`
service hostname:

```php
'db' => [
    'class' => \yii\db\Connection::class,
    'dsn' => 'pgsql:host=postgres;dbname=yii2advanced',
    'username' => 'yii2advanced',
    'password' => 'secret',
    'charset' => 'utf8',
],
```

You can then access the application through the following URLs:

```
http://127.0.0.1:20080  (frontend)
http://127.0.0.1:21080  (backend)
```

To run the test suite, also update `common/config/test-local.php` to use the `postgres` hostname and create the
test database:

```php
'db' => [
    'dsn' => 'pgsql:host=postgres;dbname=yii2advanced_test',
],
```

```bash
docker compose exec -T postgres psql -U yii2advanced -d postgres -c "CREATE DATABASE yii2advanced_test;"
docker compose exec -T frontend php /app/yii_test migrate --interactive=0
docker compose exec -T frontend vendor/bin/codecept build
docker compose exec -T frontend vendor/bin/codecept run
```

**NOTES:**
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `~/.composer-docker/cache` for Composer caches

CONFIGURATION
-------------

## Database

Edit the file `common/config/main-local.php` with real data, for example:

```php
return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'pgsql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '1234',
            'charset' => 'utf8',
        ],
    ],
];
```

When using Docker, the PostgreSQL service is pre-configured. Update `common/config/main-local.php` to use:

```php
'db' => [
    'class' => \yii\db\Connection::class,
    'dsn' => 'pgsql:host=postgres;dbname=yii2advanced',
    'username' => 'yii2advanced',
    'password' => 'secret',
    'charset' => 'utf8',
],
```

Apply migrations:

```bash
php yii migrate
```

Or with Docker:

```bash
docker compose exec frontend php /app/yii migrate
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
  When using Docker, the PostgreSQL service creates the database automatically.
- Check and edit the other files in the `config/` directories to customize your application as required.
- Refer to the README in the `tests` directory for information specific to application tests.

TESTING
-------

Tests are located in `frontend/tests`, `backend/tests`, and `common/tests` directories.
They are developed with [Codeception PHP Testing Framework](https://codeception.com/).

Tests can be executed by running:

```bash
vendor/bin/codecept run --env php-builtin
```

Or using the Composer script:

```bash
composer tests
```

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?style=for-the-badge&logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=for-the-badge&logo=yii)](https://www.yiiframework.com/)
[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=for-the-badge&logo=telegram)](https://t.me/yii_framework_in_english)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=for-the-badge&logo=slack)](https://yiiframework.com/go/slack)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE.md)

## ORIGINAL PROMPTING
Saya ingin membangun Aplikasi Buku Ekspedisi Surat Digital dengan spesifikasi berikut:

══════════════════════════════════════════════
ARSITEKTUR UMUM
══════════════════════════════════════════════

- Backend: Yii2 Advanced Template
- Frontend Mobile: Flutter (Android/tablet)
- Database: Postgresql
- Satu codebase Yii2 Advanced dengan 3 app:
  • frontend → Portal divisi: user tiap divisi login untuk melihat/tracking surat masuk & keluar divisinya, melihat foto bukti, dan cetak laporan. Akses read-only atau limited-edit. Tampilan ringan dan user-friendly.
    • backend → Admin panel: input/kelola data surat, kelola user & divisi, dashboard rekapitulasi semua divisi, konfigurasi sistem. Hanya untuk admin & operator pusat.
      • api → REST API JSON untuk Flutter: sync data, upload foto bukti, autentikasi JWT.
      - Ketiganya share folder common (models, components, services)

      ══════════════════════════════════════════════
      PEMBAGIAN PERAN 3 APP
      ══════════════════════════════════════════════

      FRONTEND (Portal Divisi):
      - Login per user divisi (session auth)
      - Dashboard divisi: statistik surat masuk/keluar hari ini, minggu ini, bulan ini
      - Daftar surat masuk ke divisi (dengan filter & search)
      - Daftar surat keluar dari divisi
      - Detail surat + lihat foto bukti penerimaan (dengan overlay)
      - Cetak/export laporan per periode (PDF/Excel)
      - TIDAK bisa menambah/mengedit surat (read-only)
      - TIDAK bisa mengelola user atau divisi
      - Setiap user hanya melihat data divisinya sendiri

      BACKEND (Admin Panel):
      - Login admin/operator pusat (session auth)
      - Dashboard global: statistik semua divisi, grafik, surat pending
      - CRUD surat ekspedisi (input via web)
      - Kelola divisi (CRUD)
      - Kelola user (CRUD, assign divisi & role)
      - Lihat semua data lintas divisi
      - Monitoring sync dari perangkat Flutter
      - Konfigurasi sistem (format nomor surat, dll)

      API (REST untuk Flutter):
      - Autentikasi JWT (login, refresh token)
      - CRUD surat (scoped by divisi)
      - Upload foto bukti (original + overlay)
      - Sync download/upload batch
      - List divisi
      - Serve foto via authenticated endpoint

      ══════════════════════════════════════════════
      FITUR UTAMA
      ══════════════════════════════════════════════

      1. Pencatatan surat ekspedisi:
         - Nomor surat (opsional, auto-generate format EKS-YYYYMMDD-XXXX)
            - Tanggal surat / tanggal penyampaian
               - Divisi pengirim (asal)
                  - Divisi tujuan
                     - Tujuan perorangan (nama orang, opsional)
                        - Perihal surat
                           - Nama penerima
                              - Tanggal penerimaan (otomatis terisi saat foto bukti diambil)
                                 - Foto bukti penerimaan (dengan overlay)
                                    - Status: draft → dikirim → diterima

                                    2. Foto bukti dengan OVERLAY informasi (tidak bisa dipalsukan):
                                       - ID unik surat (EKS-YYYYMMDD-XXXX)
                                          - Divisi asal
                                             - Divisi tujuan / nama tujuan perorangan
                                                - Timestamp (tanggal & jam lengkap)
                                                   - Nama penerima
                                                      - Geolokasi (nama alamat/area, BUKAN koordinat lat/long)
                                                         - Overlay di-render menggunakan Canvas (dart:ui) di Flutter
                                                            - Simpan 2 file: foto original + foto dengan overlay
                                                               - Hash SHA-256 dikirim ke server untuk validasi keaslian

                                                               3. Multi-divisi dengan isolasi data:
                                                                  - Setiap user terkait satu divisi
                                                                     - User frontend hanya bisa melihat surat milik divisinya sendiri
                                                                        - User backend (admin) bisa melihat semua divisi
                                                                           - Isolasi diterapkan via behavior/scope di setiap query

                                                                           4. Role pengguna:
                                                                              - admin: akses backend, kelola semua data, user, divisi
                                                                                 - operator: akses backend, input surat, kelola surat
                                                                                    - divisi: akses frontend saja, lihat data divisinya sendiri (read-only)
                                                                                       - kurir: akses Flutter, ambil foto bukti, sync data

                                                                                       5. Offline-first (Flutter):
                                                                                          - Data disimpan di SQLite lokal
                                                                                             - UUID sebagai primary key untuk sinkronisasi
                                                                                                - Flag is_synced dan needs_upload
                                                                                                   - SyncManager: download surat baru dari server, upload surat + foto ke server
                                                                                                      - Jika offline, data tetap bisa di-entry dan di-upload nanti

                                                                                                      ══════════════════════════════════════════════
                                                                                                      DATABASE (PostgreSQL)
                                                                                                      ══════════════════════════════════════════════

                                                                                                      Tabel-tabel yang diperlukan:

                                                                                                      1. divisi
                                                                                                         - id (PK, auto increment)
                                                                                                            - kode_divisi (varchar 20, unique)
                                                                                                               - nama_divisi (varchar 100)
                                                                                                                  - is_active (boolean, default true)
                                                                                                                     - created_at, updated_at (datetime)

                                                                                                                     2. users
                                                                                                                        - id (PK, auto increment)
                                                                                                                           - divisi_id (FK → divisi.id)
                                                                                                                              - username (varchar 50, unique)
                                                                                                                                 - email (varchar 100, unique)
                                                                                                                                    - password_hash (varchar 255)
                                                                                                                                       - nama_lengkap (varchar 100)
                                                                                                                                          - role (enum: admin, operator, divisi, kurir)
                                                                                                                                             - is_active (boolean, default true)
                                                                                                                                                - created_at, updated_at (datetime)

                                                                                                                                                3. surat_ekspedisi
                                                                                                                                                   - id (PK, auto increment)
                                                                                                                                                      - uuid (char 36, unique) — untuk sinkronisasi Flutter
                                                                                                                                                         - nomor_surat (varchar 50, nullable)
                                                                                                                                                            - divisi_pengirim_id (FK → divisi.id)
                                                                                                                                                               - divisi_tujuan_id (FK → divisi.id)
                                                                                                                                                                  - nama_tujuan_orang (varchar 100, nullable)
                                                                                                                                                                     - tanggal_surat (date)
                                                                                                                                                                        - perihal (text)
                                                                                                                                                                           - nama_penerima (varchar 100, nullable)
                                                                                                                                                                              - tanggal_penerimaan (datetime, nullable)
                                                                                                                                                                                 - foto_bukti (varchar 255, nullable) — path foto overlay
                                                                                                                                                                                    - foto_bukti_original (varchar 255, nullable) — path foto asli
                                                                                                                                                                                       - foto_latitude (decimal 10,8, nullable)
                                                                                                                                                                                          - foto_longitude (decimal 11,8, nullable)
                                                                                                                                                                                             - foto_alamat (varchar 255, nullable) — alamat reverse-geocode
                                                                                                                                                                                                - foto_hash (varchar 64, nullable) — SHA-256
                                                                                                                                                                                                   - status (enum: draft, dikirim, diterima)
                                                                                                                                                                                                      - is_synced (boolean, default false)
                                                                                                                                                                                                         - needs_upload (boolean, default false)
                                                                                                                                                                                                            - created_by (FK → users.id)
                                                                                                                                                                                                               - updated_by (FK → users.id, nullable)
                                                                                                                                                                                                                  - created_at, updated_at (datetime)

                                                                                                                                                                                                                  4. refresh_tokens
                                                                                                                                                                                                                     - id (PK)
                                                                                                                                                                                                                        - user_id (FK → users.id)
                                                                                                                                                                                                                           - token (varchar 255, unique)
                                                                                                                                                                                                                              - device_id (varchar 100)
                                                                                                                                                                                                                                 - expires_at (datetime)
                                                                                                                                                                                                                                    - created_at (datetime)

                                                                                                                                                                                                                                    5. sync_log
                                                                                                                                                                                                                                       - id (PK)
                                                                                                                                                                                                                                          - user_id (FK → users.id)
                                                                                                                                                                                                                                             - device_id (varchar 100)
                                                                                                                                                                                                                                                - sync_type (enum: download, upload)
                                                                                                                                                                                                                                                   - records_count (int)
                                                                                                                                                                                                                                                      - status (enum: success, partial, failed)
                                                                                                                                                                                                                                                         - error_message (text, nullable)
                                                                                                                                                                                                                                                            - synced_at (datetime)

                                                                                                                                                                                                                                                            ══════════════════════════════════════════════
                                                                                                                                                                                                                                                            STRUKTUR FOLDER YII2 ADVANCED
                                                                                                                                                                                                                                                            ══════════════════════════════════════════════

                                                                                                                                                                                                                                                            project-root/
                                                                                                                                                                                                                                                            ├── frontend/               ← Portal Divisi (read-only per divisi)
                                                                                                                                                                                                                                                            │   ├── config/
                                                                                                                                                                                                                                                            │   ├── controllers/
                                                                                                                                                                                                                                                            │   │   ├── SiteController.php (login, dashboard divisi)
                                                                                                                                                                                                                                                            │   │   ├── SuratController.php (list & detail surat divisi)
                                                                                                                                                                                                                                                            │   │   └── LaporanController.php (cetak/export laporan)
                                                                                                                                                                                                                                                            │   ├── views/
                                                                                                                                                                                                                                                            │   │   ├── layouts/
                                                                                                                                                                                                                                                            │   │   ├── site/ (login, dashboard)
                                                                                                                                                                                                                                                            │   │   ├── surat/ (index, view)
                                                                                                                                                                                                                                                            │   │   └── laporan/ (filter, preview)
                                                                                                                                                                                                                                                            │   └── web/
                                                                                                                                                                                                                                                            │
                                                                                                                                                                                                                                                            ├── backend/                ← Admin Panel (full CRUD)
                                                                                                                                                                                                                                                            │   ├── config/
                                                                                                                                                                                                                                                            │   ├── controllers/
                                                                                                                                                                                                                                                            │   │   ├── SiteController.php (login, dashboard global)
                                                                                                                                                                                                                                                            │   │   ├── SuratController.php (CRUD surat)
                                                                                                                                                                                                                                                            │   │   ├── UserController.php (kelola user)
                                                                                                                                                                                                                                                            │   │   └── DivisiController.php (kelola divisi)
                                                                                                                                                                                                                                                            │   ├── views/
                                                                                                                                                                                                                                                            │   │   ├── layouts/
                                                                                                                                                                                                                                                            │   │   ├── site/
                                                                                                                                                                                                                                                            │   │   ├── surat/
                                                                                                                                                                                                                                                            │   │   ├── user/
                                                                                                                                                                                                                                                            │   │   └── divisi/
                                                                                                                                                                                                                                                            │   └── web/
                                                                                                                                                                                                                                                            │
                                                                                                                                                                                                                                                            ├── api/                    ← REST API (JSON, JWT auth)
                                                                                                                                                                                                                                                            │   ├── config/
                                                                                                                                                                                                                                                            │   ├── controllers/
                                                                                                                                                                                                                                                            │   │   ├── AuthController.php (login, refresh token)
                                                                                                                                                                                                                                                            │   │   ├── SuratController.php (CRUD JSON)
                                                                                                                                                                                                                                                            │   │   ├── SyncController.php (download/upload batch)
                                                                                                                                                                                                                                                            │   │   ├── DivisiController.php (list divisi)
                                                                                                                                                                                                                                                            │   │   └── FotoController.php (serve foto via auth)
                                                                                                                                                                                                                                                            │   ├── filters/
                                                                                                                                                                                                                                                            │   │   ├── JwtAuthFilter.php
                                                                                                                                                                                                                                                            │   │   └── DivisiScopeFilter.php
                                                                                                                                                                                                                                                            │   └── web/
                                                                                                                                                                                                                                                            │
                                                                                                                                                                                                                                                            ├── common/                 ← Shared code (dipakai frontend, backend, api)
                                                                                                                                                                                                                                                            │   ├── models/
                                                                                                                                                                                                                                                            │   │   ├── Divisi.php
                                                                                                                                                                                                                                                            │   │   ├── User.php (extends IdentityInterface)
                                                                                                                                                                                                                                                            │   │   ├── SuratEkspedisi.php
                                                                                                                                                                                                                                                            │   │   ├── RefreshToken.php
                                                                                                                                                                                                                                                            │   │   └── SyncLog.php
                                                                                                                                                                                                                                                            │   ├── services/
                                                                                                                                                                                                                                                            │   │   ├── PhotoStorageService.php
                                                                                                                                                                                                                                                            │   │   ├── SuratService.php
                                                                                                                                                                                                                                                            │   │   └── SyncService.php
                                                                                                                                                                                                                                                            │   └── components/
                                                                                                                                                                                                                                                            │       └── DivisiScope.php (trait/behavior untuk filter query by divisi)
                                                                                                                                                                                                                                                            │
                                                                                                                                                                                                                                                            ├── console/                ← CLI commands, migrations
                                                                                                                                                                                                                                                            │   ├── config/
                                                                                                                                                                                                                                                            │   ├── controllers/
                                                                                                                                                                                                                                                            │   └── migrations/
                                                                                                                                                                                                                                                            │       ├── m250101_000001_create_divisi_table.php
                                                                                                                                                                                                                                                            │       ├── m250101_000002_create_users_table.php
                                                                                                                                                                                                                                                            │       ├── m250101_000003_create_surat_ekspedisi_table.php
                                                                                                                                                                                                                                                            │       ├── m250101_000004_create_refresh_tokens_table.php
                                                                                                                                                                                                                                                            │       └── m250101_000005_create_sync_log_table.php
                                                                                                                                                                                                                                                            │
                                                                                                                                                                                                                                                            ├── storage/
                                                                                                                                                                                                                                                            │   └── app/uploads/bukti_foto/    ← foto di luar web root
                                                                                                                                                                                                                                                            │
                                                                                                                                                                                                                                                            ├── environments/
                                                                                                                                                                                                                                                            ├── composer.json
                                                                                                                                                                                                                                                            ├── init.bat
                                                                                                                                                                                                                                                            └── yii

                                                                                                                                                                                                                                                            ══════════════════════════════════════════════
                                                                                                                                                                                                                                                            API CONTRACT (api app)
                                                                                                                                                                                                                                                            ══════════════════════════════════════════════

                                                                                                                                                                                                                                                            Public (tanpa auth):
                                                                                                                                                                                                                                                            - POST   /api/auth/login          → {username, password, device_id} → {access_token, refresh_token, user, divisi}
                                                                                                                                                                                                                                                            - POST   /api/auth/refresh        → {refresh_token} → {access_token, refresh_token}

                                                                                                                                                                                                                                                            Protected (JWT required, divisi-scoped):
                                                                                                                                                                                                                                                            - GET    /api/surat               → list surat (filtered by divisi dari JWT)
                                                                                                                                                                                                                                                            - POST   /api/surat               → buat surat baru
                                                                                                                                                                                                                                                            - PUT    /api/surat/{uuid}        → update surat
                                                                                                                                                                                                                                                            - GET    /api/surat/{uuid}        → detail surat
                                                                                                                                                                                                                                                            - POST   /api/surat/{uuid}/upload-bukti → upload foto original + overlay (multipart)
                                                                                                                                                                                                                                                            - POST   /api/sync/download       → {last_sync_at} → surat baru/update sejak timestamp
                                                                                                                                                                                                                                                            - POST   /api/sync/upload         → batch upload surat + foto dari device
                                                                                                                                                                                                                                                            - GET    /api/divisi              → list semua divisi aktif
                                                                                                                                                                                                                                                            - GET    /api/foto/{uuid}/{type}  → serve foto (type: overlayed|original)

                                                                                                                                                                                                                                                            ══════════════════════════════════════════════
                                                                                                                                                                                                                                                            FOTO STORAGE DI SERVER
                                                                                                                                                                                                                                                            ══════════════════════════════════════════════

                                                                                                                                                                                                                                                            - Disimpan di: storage/app/uploads/bukti_foto/YYYY/MM/DD/
                                                                                                                                                                                                                                                            - Format nama: {short_uuid}_overlayed_{HHmmss}.jpg dan {short_uuid}_original_{HHmmss}.jpg
                                                                                                                                                                                                                                                            - TIDAK di dalam folder web/ (tidak bisa diakses langsung via URL)
                                                                                                                                                                                                                                                            - Diakses melalui controller dengan pengecekan auth + divisi ownership
                                                                                                                                                                                                                                                            - PhotoStorageService: validasi mime (jpeg/png/webp), max 10MB, generate path, simpan, baca, hapus
                                                                                                                                                                                                                                                            - Backend & frontend serve foto via action khusus (cek session + divisi)
                                                                                                                                                                                                                                                            - API serve foto via FotoController (cek JWT + divisi)

                                                                                                                                                                                                                                                            ══════════════════════════════════════════════
                                                                                                                                                                                                                                                            FLUTTER CLIENT
                                                                                                                                                                                                                                                            ══════════════════════════════════════════════

                                                                                                                                                                                                                                                            Dependencies utama:
                                                                                                                                                                                                                                                            - flutter_bloc, dio, sqflite, camera, geolocator, geocoding, image
                                                                                                                                                                                                                                                            - uuid, path_provider, shared_preferences, get_it
                                                                                                                                                                                                                                                            - flutter_secure_storage, connectivity_plus, permission_handler

                                                                                                                                                                                                                                                            Struktur:
                                                                                                                                                                                                                                                            - lib/core/ (database, network/dio, sync manager)
                                                                                                                                                                                                                                                            - lib/features/surat/ (model, datasource local+remote, repository, use-case, UI pages)
                                                                                                                                                                                                                                                            - lib/features/auth/
                                                                                                                                                                                                                                                            - lib/features/camera/ (CameraCapturePage dengan live overlay preview)

                                                                                                                                                                                                                                                            SQLite lokal meniru tabel surat_ekspedisi server + kolom is_synced, needs_upload.

                                                                                                                                                                                                                                                            Overlay foto di-render dengan Canvas (dart:ui):
                                                                                                                                                                                                                                                            - Semi-transparent background
                                                                                                                                                                                                                                                            - Baris info: ID SURAT, DARI, UNTUK, WAKTU, TERIMA, LOKASI
                                                                                                                                                                                                                                                            - Footer: "Buku Ekspedisi Digital v1.0"
                                                                                                                                                                                                                                                            - Simpan original + overlayed

                                                                                                                                                                                                                                                            SyncManager:
                                                                                                                                                                                                                                                            - Download: POST /api/sync/download dengan last_sync_at → simpan ke SQLite
                                                                                                                                                                                                                                                            - Upload: kumpulkan record needs_upload=true → POST /api/sync/upload + foto
                                                                                                                                                                                                                                                            - Catat sync_metadata (last_sync timestamp)

                                                                                                                                                                                                                                                            ══════════════════════════════════════════════
                                                                                                                                                                                                                                                            KEAMANAN & VALIDASI
                                                                                                                                                                                                                                                            ══════════════════════════════════════════════

                                                                                                                                                                                                                                                            - JWT access token (expire 1 jam) + refresh token (expire 30 hari) — khusus API
                                                                                                                                                                                                                                                            - Session auth + CSRF — untuk frontend & backend web
                                                                                                                                                                                                                                                            - DivisiScope behavior: inject divisi_id ke setiap query (frontend, api)
                                                                                                                                                                                                                                                            - Backend admin bisa bypass scope untuk lihat semua data
                                                                                                                                                                                                                                                            - Server validasi EXIF timestamp & GPS vs data yang dikirim (toleransi 5 menit / 500m)
                                                                                                                                                                                                                                                            - SHA-256 hash foto dikirim bersama upload, disimpan di DB
                                                                                                                                                                                                                                                            - Dual storage foto (original + overlay) untuk cross-check
                                                                                                                                                                                                                                                            - tanggal_penerimaan di-set dari waktu server, bukan client

                                                                                                                                                                                                                                                            ══════════════════════════════════════════════
                                                                                                                                                                                                                                                            ENVIRONMENT & SETUP
                                                                                                                                                                                                                                                            ══════════════════════════════════════════════

                                                                                                                                                                                                                                                            - Development di Windows dengan Laragon (PHP 8.4, PostgreSQL, Apache)
                                                                                                                                                                                                                                                            - Yii2 Advanced Template install via:
                                                                                                                                                                                                                                                                composer create-project --prefer-dist yiisoft/yii2-app-advanced ekspedisi-surat
                                                                                                                                                                                                                                                                    cd ekspedisi-surat
                                                                                                                                                                                                                                                                        init --env=Development
                                                                                                                                                                                                                                                                        - Buat database db_ekspedisi_surat di PostgreSQL
                                                                                                                                                                                                                                                                        - Edit common/config/main-local.php untuk koneksi DB
                                                                                                                                                                                                                                                                        - Jalankan migrasi: php yii migrate
                                                                                                                                                                                                                                                                        - Tambahkan folder api/ (copy dari backend/, modifikasi untuk REST)
                                                                                                                                                                                                                                                                        - Install JWT library: composer require firebase/php-jwt

                                                                                                                                                                                                                                                                        ══════════════════════════════════════════════
                                                                                                                                                                                                                                                                        INSTRUKSI UNTUK AI
                                                                                                                                                                                                                                                                        ══════════════════════════════════════════════

                                                                                                                                                                                                                                                                        1. Bantu saya step-by-step membangun aplikasi ini dari nol
                                                                                                                                                                                                                                                                        2. Mulai dari instalasi Yii2 Advanced Template di Windows/Laragon
                                                                                                                                                                                                                                                                        3. Lalu buat struktur folder api/, migrations, models, controllers satu per satu
                                                                                                                                                                                                                                                                        4. Setiap langkah berikan kode lengkap yang bisa langsung dipakai
                                                                                                                                                                                                                                                                        5. Gunakan best practice Yii2: ActiveRecord, REST controller, behaviors, filters
                                                                                                                                                                                                                                                                        6. Pastikan semua query surat di frontend & api di-filter berdasarkan divisi_id user yang login
                                                                                                                                                                                                                                                                        7. Backend (admin) bisa melihat semua data tanpa filter divisi
                                                                                                                                                                                                                                                                        8. Setelah backend & frontend web selesai, lanjut ke Flutter client
                                                                                                                                                                                                                                                                        9. Jelaskan dalam Bahasa Indonesia 
