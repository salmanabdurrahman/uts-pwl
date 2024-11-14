# SimpleNews Website

## Deskripsi

SimpleNews adalah website berita sederhana yang menampilkan berita-berita terkini terkait topik-topik populer seperti politik, bisnis, teknologi, dan lainnya. Website ini dibangun sebagai proyek akhir mata kuliah **Pengenalan Perancangan Web**, memanfaatkan teknologi web modern untuk memberikan pengalaman pengguna yang bersih dan responsif.

## Preview

![Home Page Preview](./preview/home.png)

## Halaman pada Project

-   **Home:** Halaman utama yang menampilkan berita-berita terbaru dan menarik.
-   **Blog:** Daftar artikel terkait berbagai topik.
-   **Contact:** Halaman kontak dengan form penerimaan data.
-   **Error:** Halaman yang ditampilkan ketika terjadi kesalahan navigasi atau halaman tidak ditemukan.
-   **Login & Register:** Halaman otentikasi pengguna untuk login dan mendaftar.
-   **Dashboard Admin/User:** Halaman sederhana untuk mengelola konten bagi admin atau pengguna yang sudah login.

## Teknologi yang Digunakan

-   **PHP:** Backend dan logika pemrosesan data.
-   **TailwindCSS:** Framework CSS untuk mendesain tampilan yang responsif dan modern.
-   **Vanilla JavaScript dengan Vite:** Membantu membangun JavaScript dengan optimasi performa dan modularisasi.
-   **Preline UI:** Komponen UI untuk meningkatkan desain dan fungsionalitas.
-   **SweetAlert2:** Library untuk menampilkan alert dan konfirmasi yang interaktif.

## Struktur Direktori

project/
├── actions/
├── admin/
├── assets/
│ ├── css/
│ ├── icons/
│ ├── images/
│ ├── js/
│ └── uploads/
├── config/
├── database/
├── functions/
├── node_modules/
├── pages/
├── preview/
├── user/
├── .eslintrc
├── .gitignore
├── .prettierrc
├── index.php
├── package.json
├── pnpm-lock.yaml
├── README.md
└──tailwind.config.js

## CRUD dan Olah Data

-   **Users dan Articles:** Fitur CRUD untuk mengelola pengguna dan artikel.
-   **Subscribe dan Contact:** Pengumpulan data dari form subscribe dan kontak.

## Cara Menjalankan

1. **Clone Repository**
    ```bash
    git clone https://github.com/salmanabdurrahman/fp-ppw.git
    cd fp-ppw
    ```
2. **Instalasi Dependencies**
   Jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan.

    ```bash
    npm install
    ```

3. **Build CSS**
   Gunakan perintah ini untuk membangun file CSS dengan Tailwind.

    ```bash
    npm run build-css
    ```

4. **Setup Database**

    - Buat database baru dengan nama `simple_news_website_2961`.
    - Import file setup awal database yang ada di folder `database`.

5. **Jalankan Server**
   Gunakan XAMPP, Laragon, atau server lokal lain untuk menjalankan project ini. Letakkan file project di dalam folder `htdocs` (untuk XAMPP) atau `www` (untuk Laragon), kemudian akses di browser melalui `http://localhost/fp-ppw`.

Project ini kini siap dijalankan di server lokal Anda!
