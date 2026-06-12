# ⚡ Master Quiz Voice Generator — Class of Champions

Aplikasi web berbasis Laravel untuk melakukan **Text-to-Speech (TTS)** bergaya *voiceover* kompetisi, terinspirasi oleh announcer acara *Clash of Champions*. Aplikasi ini menggunakan teknologi Microsoft Azure Edge TTS secara gratis melalui skrip Python `edge-tts`.

## ✨ Fitur Utama
- **Template Naskah Bawaan**: Berbagai preset naskah kompetisi seperti Pembukaan, Pembacaan Soal, Hitung Mundur, dan Pengumuman Juara.
- **Pengaturan Suara Lanjutan**: Bisa mengatur tingkat *Pitch* (tinggi-rendah nada) dan *Speed* (kecepatan bicara) untuk memberikan efek suara yang dramatis dan berwibawa.
- **Scrubbing Audio**: Memutar dan menggeser (*drag/scrub*) hasil audio yang sudah di-generate secara langsung di halaman web tanpa harus menyimpannya terlebih dahulu.
- **Download MP3**: Unduh hasil audio dengan mudah.

---

## 🛠️ Persyaratan Sistem (Prerequisites)

Sebelum melakukan instalasi, pastikan komputermu sudah memiliki:
1. **PHP** (minimal versi 8.2) & **Composer**
2. **Python** (minimal versi 3.7) beserta **pip**
3. **Git** (Opsional, untuk pull/clone dari GitHub)

---

## 🚀 Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menginstal project ini di komputermu:

### 1. Kloning Repository
```bash
git clone https://github.com/miomidev/Text-To-Voice.git
cd Text-To-Voice
```

### 2. Install Dependencies Laravel (PHP)
```bash
composer install
```

### 3. Persiapkan Environment Laravel
Copy file konfigurasi `.env.example` menjadi `.env`, lalu generate APP_KEY:
```bash
cp .env.example .env
php artisan key:generate
```
*(Khusus pengguna Windows CMD/PowerShell, kamu bisa langsung copy paste file .env.example lalu rename menjadi .env)*

### 4. Install Dependencies Python
Project ini menggunakan modul `edge-tts` dari Python. Install menggunakan `pip`:
```bash
pip install edge-tts
```
> **Penting:** Pastikan Python sudah terdaftar di `PATH` sistem operasi kamu (bisa diuji dengan perintah `python --version` di terminal).

### 5. Buat Storage Link
Aplikasi ini menyimpan audio hasil generate di dalam folder `storage`. Agar audio bisa diakses oleh public (ditampilkan di web), jalankan perintah ini:
```bash
php artisan storage:link
```

---

## 💻 Cara Menjalankan Aplikasi (Usage)

1. Jalankan development server bawaan Laravel:
   ```bash
   php artisan serve
   ```
2. Buka browser dan akses URL: **[http://localhost:8000](http://localhost:8000)** (atau sesuai dengan port yang tampil di terminal).
3. **Cara pakai:**
   - Masukkan naskah kamu atau klik salah satu **Template Naskah**.
   - Sesuaikan **Kecepatan Bicara** dan **Nada Suara (Pitch)** di Pengaturan Suara. Tip: Untuk hasil ala announcer dramatis, gunakan suara *Ardi* dengan Kecepatan `-10%` dan Pitch `-15Hz`.
   - Klik **Generate Voice**. Tunggu beberapa saat, dan audio siap untuk diputar & di-download.

---

## 📝 Catatan Penting
- **Pembersihan Otomatis**: Secara default, setiap kali kamu menekan tombol *Generate*, aplikasi akan otomatis menghapus file audio MP3 yang sudah berumur lebih dari 1 jam. Hal ini menjaga agar folder storage tidak membengkak seiring waktu.
- Error "No such file or directory": Jika muncul error bahwa Python tidak menemukan file, pastikan file `master_quiz_tts.py` berada persis di direktori *root* (paling luar) project ini, sejajar dengan file `artisan`.

---
*Dibuat dengan ⚡ oleh Class of Champions — Powered by Microsoft Azure Edge TTS*
