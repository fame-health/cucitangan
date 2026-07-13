<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuci Tangan - Sistem Monitoring Cuci Tangan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            color-scheme: light;
            --ink: #102033;
            --muted: #607080;
            --line: #ead2dc;
            --surface: #ffffff;
            --surface-soft: #fff7fa;
            --teal: #db2777;
            --teal-soft: #fde7f0;
            --rose: #be185d;
            --rose-soft: #fde7f0;
            --amber: #b45309;
            --amber-soft: #fff3d9;
            --blue: #2563eb;
            --blue-soft: #e6efff;
            --green: #15803d;
            --green-soft: #e5f7ea;
            --shadow: 0 14px 34px rgba(190, 24, 93, 0.11);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #fff8fb;
            color: var(--ink);
            font-family: "Instrument Sans", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.55;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page-shell {
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            border-bottom: 1px solid rgba(234, 210, 220, 0.9);
            background: rgba(255, 248, 251, 0.94);
            backdrop-filter: blur(14px);
        }

        .topbar-inner,
        .section-inner {
            width: min(1080px, calc(100% - 36px));
            margin: 0 auto;
        }

        .topbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 60px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            letter-spacing: 0;
        }

        .brand-mark {
            display: grid;
            width: 36px;
            height: 36px;
            place-items: center;
            border: 1px solid #f6b1cc;
            border-radius: 8px;
            background: var(--teal-soft);
            color: var(--teal);
            font-weight: 700;
        }

        .brand small {
            display: block;
            color: var(--muted);
            font-size: 0.74rem;
            font-weight: 500;
            line-height: 1.2;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 0 13px;
            background: var(--surface);
            color: var(--ink);
            font-size: 0.88rem;
            font-weight: 700;
            white-space: nowrap;
            transition: transform 160ms ease, border-color 160ms ease, background 160ms ease;
        }

        .button:hover {
            transform: translateY(-1px);
            border-color: #f19abd;
        }

        .button-primary {
            border-color: var(--teal);
            background: var(--teal);
            color: #ffffff;
        }

        .hero {
            border-bottom: 1px solid var(--line);
            background: var(--surface);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(320px, 0.92fr);
            gap: 28px;
            align-items: center;
            padding: 44px 0 34px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 14px;
            border: 1px solid #f6b1cc;
            border-radius: 999px;
            padding: 5px 10px;
            background: var(--teal-soft);
            color: var(--teal);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .eyebrow::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: var(--teal);
        }

        h1,
        h2,
        h3,
        p {
            margin: 0;
        }

        h1 {
            max-width: 680px;
            font-size: clamp(2rem, 4vw, 3.45rem);
            line-height: 1.06;
            letter-spacing: 0;
        }

        .hero-copy {
            max-width: 650px;
            margin-top: 16px;
            color: var(--muted);
            font-size: 0.98rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .hero-note {
            margin-top: 16px;
            color: var(--muted);
            font-size: 0.86rem;
        }

        .hero-visual {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fffafd;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .visual-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border-bottom: 1px solid var(--line);
            padding: 14px;
            background: #ffffff;
        }

        .status-pill {
            border-radius: 999px;
            padding: 5px 9px;
            background: var(--green-soft);
            color: var(--green);
            font-size: 0.74rem;
            font-weight: 700;
        }

        .visual-body {
            padding: 14px;
        }

        .snapshot-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .snapshot-item {
            min-height: 92px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 12px;
            background: #ffffff;
        }

        .snapshot-label {
            color: var(--muted);
            font-size: 0.76rem;
            font-weight: 600;
        }

        .snapshot-value {
            margin-top: 6px;
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1;
        }

        .snapshot-desc {
            margin-top: 6px;
            color: var(--muted);
            font-size: 0.76rem;
            line-height: 1.38;
        }

        .mini-flow {
            display: grid;
            gap: 8px;
            margin-top: 12px;
        }

        .mini-flow-row {
            display: grid;
            grid-template-columns: 32px minmax(0, 1fr);
            gap: 10px;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 10px;
            background: #ffffff;
            font-size: 0.86rem;
        }

        .mini-flow-number {
            display: grid;
            width: 32px;
            height: 32px;
            place-items: center;
            border-radius: 8px;
            background: var(--teal-soft);
            color: var(--teal);
            font-weight: 800;
        }

        .band {
            padding: 38px 0;
        }

        .band-soft {
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            background: var(--surface-soft);
        }

        .section-heading {
            display: grid;
            gap: 9px;
            max-width: 780px;
            margin-bottom: 18px;
        }

        .section-kicker {
            color: var(--rose);
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        h2 {
            font-size: clamp(1.45rem, 2.35vw, 2.08rem);
            line-height: 1.18;
            letter-spacing: 0;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 0.94rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .info-card,
        .feature-card,
        .simple-card {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            padding: 15px;
        }

        .info-card h3,
        .feature-card h3,
        .simple-card h3 {
            margin-bottom: 8px;
            font-size: 0.98rem;
            line-height: 1.3;
        }

        .info-card p,
        .feature-card p,
        .simple-card p,
        .text-list {
            color: var(--muted);
            font-size: 0.88rem;
        }

        .text-list {
            display: grid;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .text-list li {
            position: relative;
            padding-left: 18px;
        }

        .text-list li::before {
            content: "";
            position: absolute;
            top: 0.68em;
            left: 0;
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: var(--teal);
        }

        .label-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 12px;
        }

        .label {
            border-radius: 999px;
            padding: 5px 8px;
            background: var(--rose-soft);
            color: var(--rose);
            font-size: 0.73rem;
            font-weight: 700;
        }

        .label:nth-child(2n) {
            background: var(--rose-soft);
            color: var(--rose);
        }

        .label:nth-child(3n) {
            background: var(--amber-soft);
            color: var(--amber);
        }

        .flow-wrap {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            padding: 14px;
            overflow-x: auto;
        }

        .flow {
            display: grid;
            grid-template-columns: repeat(6, minmax(126px, 1fr));
            gap: 10px;
            min-width: 780px;
        }

        .flow-step {
            position: relative;
            min-height: 126px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 13px;
            background: #ffffff;
        }

        .flow-step:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 50%;
            right: -15px;
            width: 20px;
            height: 2px;
            background: #f19abd;
        }

        .flow-step:not(:last-child)::before {
            content: "";
            position: absolute;
            top: calc(50% - 4px);
            right: -17px;
            width: 0;
            height: 0;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-left: 7px solid #f19abd;
        }

        .flow-index {
            display: inline-grid;
            width: 28px;
            height: 28px;
            margin-bottom: 9px;
            place-items: center;
            border-radius: 8px;
            background: var(--teal-soft);
            color: var(--teal);
            font-size: 0.8rem;
            font-weight: 800;
        }

        .flow-step h3 {
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .flow-step p {
            color: var(--muted);
            font-size: 0.8rem;
            line-height: 1.38;
        }

        .architecture {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            align-items: stretch;
        }

        .architecture-node {
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 13px;
            background: #ffffff;
        }

        .architecture-node strong {
            display: block;
            margin-bottom: 6px;
        }

        .architecture-node span {
            display: block;
            color: var(--muted);
            font-size: 0.8rem;
            line-height: 1.38;
        }

        .comparison {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .comparison .simple-card:first-child {
            border-top: 4px solid var(--teal);
        }

        .comparison .simple-card:last-child {
            border-top: 4px solid var(--amber);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #ffffff;
        }

        .data-table th,
        .data-table td {
            border-bottom: 1px solid var(--line);
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }

        .data-table tr:last-child td {
            border-bottom: 0;
        }

        .data-table th {
            background: #fde7f0;
            color: var(--rose);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table td {
            color: var(--muted);
            font-size: 0.86rem;
        }

        .data-table code {
            color: var(--rose);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-weight: 700;
        }

        .timeline {
            display: grid;
            gap: 10px;
            counter-reset: guide;
        }

        .timeline-item {
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            gap: 10px;
            align-items: start;
        }

        .timeline-item::before {
            counter-increment: guide;
            content: counter(guide);
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 8px;
            background: var(--rose-soft);
            color: var(--rose);
            font-weight: 800;
        }

        .timeline-item div {
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 13px;
            background: var(--surface);
        }

        .timeline-item h3 {
            margin-bottom: 5px;
            font-size: 0.94rem;
        }

        .timeline-item p {
            color: var(--muted);
            font-size: 0.86rem;
        }

        .footer {
            border-top: 1px solid var(--line);
            padding: 20px 0;
            background: #ffffff;
            color: var(--muted);
            font-size: 0.84rem;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        @media (max-width: 920px) {
            .hero-grid,
            .grid-2,
            .grid-3,
            .comparison,
            .architecture {
                grid-template-columns: 1fr;
            }

            .hero-grid {
                padding-top: 32px;
            }

            .hero-visual {
                order: -1;
            }
        }

        @media (max-width: 640px) {
            .topbar-inner,
            .section-inner {
                width: min(100% - 26px, 1080px);
            }

            .topbar-inner {
                align-items: flex-start;
                flex-direction: column;
                padding: 12px 0;
            }

            .nav-actions,
            .button {
                width: 100%;
            }

            .snapshot-grid {
                grid-template-columns: 1fr;
            }

            .band {
                padding: 30px 0;
            }

            h1 {
                font-size: 1.95rem;
            }

            .footer-inner {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    @php
        $dashboardUrl = url('/dashboard');
    @endphp

    <div class="page-shell">
        <header class="topbar">
            <div class="topbar-inner">
                <a class="brand" href="{{ url('/') }}" aria-label="Beranda Cuci Tangan">
                    <span class="brand-mark">CT</span>
                    <span>
                        Cuci Tangan
                        <small>Sistem Monitoring Kepatuhan Perawat</small>
                    </span>
                </a>

                <nav class="nav-actions" aria-label="Navigasi utama">
                    <a class="button" href="#alur">Lihat Alur</a>
                    <a class="button button-primary" href="{{ $dashboardUrl }}">
                        @auth
                            Buka Dashboard
                        @else
                            Masuk Dashboard
                        @endauth
                    </a>
                </nav>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="section-inner hero-grid">
                    <div>
                        <span class="eyebrow">Aplikasi dokumentasi cuci tangan perawat</span>
                        <h1>Monitoring cuci tangan yang rapi, cepat dicatat, dan mudah dievaluasi.</h1>
                        <p class="hero-copy">
                            Aplikasi ini membantu rumah sakit atau unit layanan kesehatan mencatat aktivitas cuci tangan perawat berdasarkan perawat, ruangan, shift, tanggal, dan waktu. Data yang terkumpul ditampilkan kembali dalam dashboard agar admin dapat melihat aktivitas harian, tren mingguan, serta ruangan atau shift yang membutuhkan perhatian.
                        </p>

                        <div class="hero-actions">
                            <a class="button button-primary" href="{{ $dashboardUrl }}">Masuk ke Sistem</a>
                            <a class="button" href="#ringkasan">Pelajari Aplikasi</a>
                        </div>

                        <p class="hero-note">
                            Dibangun dengan Laravel, Filament, Eloquent model, dan dashboard statistik untuk kebutuhan pemantauan operasional.
                        </p>
                    </div>

                    <aside class="hero-visual" aria-label="Ringkasan dashboard aplikasi">
                        <div class="visual-header">
                            <strong>Ringkasan Sistem</strong>
                            <span class="status-pill">Data real-time panel</span>
                        </div>
                        <div class="visual-body">
                            <div class="snapshot-grid">
                                <div class="snapshot-item">
                                    <div class="snapshot-label">Peran pengguna</div>
                                    <div class="snapshot-value">2</div>
                                    <div class="snapshot-desc">Admin dan perawat dengan akses data yang berbeda.</div>
                                </div>
                                <div class="snapshot-item">
                                    <div class="snapshot-label">Master data</div>
                                    <div class="snapshot-value">3</div>
                                    <div class="snapshot-desc">Perawat, ruangan, dan shift sebagai dasar pencatatan.</div>
                                </div>
                                <div class="snapshot-item">
                                    <div class="snapshot-label">Log utama</div>
                                    <div class="snapshot-value">1</div>
                                    <div class="snapshot-desc">Setiap aksi cuci tangan tercatat sebagai log terstruktur.</div>
                                </div>
                                <div class="snapshot-item">
                                    <div class="snapshot-label">Analisis</div>
                                    <div class="snapshot-value">7</div>
                                    <div class="snapshot-desc">Grafik aktivitas berjalan untuk tujuh hari terakhir.</div>
                                </div>
                            </div>

                            <div class="mini-flow" aria-label="Alur singkat">
                                <div class="mini-flow-row">
                                    <span class="mini-flow-number">1</span>
                                    <span>Admin menyiapkan data perawat, ruangan, dan shift.</span>
                                </div>
                                <div class="mini-flow-row">
                                    <span class="mini-flow-number">2</span>
                                    <span>Perawat memilih ruangan dan shift, lalu mencatat cuci tangan.</span>
                                </div>
                                <div class="mini-flow-row">
                                    <span class="mini-flow-number">3</span>
                                    <span>Dashboard menampilkan statistik, grafik, dan aktivitas terbaru.</span>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section id="ringkasan" class="band">
                <div class="section-inner">
                    <div class="section-heading">
                        <span class="section-kicker">Ringkasan</span>
                        <h2>Aplikasi ini dibuat untuk mendukung pemantauan kebiasaan cuci tangan secara digital.</h2>
                        <p>
                            Fokus utamanya adalah mengganti pencatatan manual yang sulit ditelusuri menjadi data yang lebih konsisten, cepat dicari, dan siap digunakan untuk evaluasi kepatuhan.
                        </p>
                    </div>

                    <div class="grid-3">
                        <article class="info-card">
                            <h3>Tujuan Utama</h3>
                            <ul class="text-list">
                                <li>Mencatat aktivitas cuci tangan perawat dengan waktu yang jelas.</li>
                                <li>Membantu admin memantau kepatuhan berdasarkan ruangan dan shift.</li>
                                <li>Menyediakan data awal untuk evaluasi kebersihan tangan dan pencegahan infeksi.</li>
                            </ul>
                        </article>

                        <article class="info-card">
                            <h3>Pengguna Sistem</h3>
                            <ul class="text-list">
                                <li>Admin mengelola data master, melihat semua log, dan mengevaluasi dashboard.</li>
                                <li>Perawat mencatat aktivitas cuci tangan miliknya sendiri.</li>
                                <li>Manajemen dapat memakai hasil rekap sebagai bahan pemantauan mutu layanan.</li>
                            </ul>
                        </article>

                        <article class="info-card">
                            <h3>Hasil yang Diharapkan</h3>
                            <ul class="text-list">
                                <li>Data cuci tangan lebih mudah ditelusuri daripada catatan manual.</li>
                                <li>Pola aktivitas harian dan mingguan terlihat lebih cepat.</li>
                                <li>Ruangan atau shift yang perlu perhatian dapat ditemukan lebih awal.</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </section>

            <section class="band band-soft">
                <div class="section-inner">
                    <div class="section-heading">
                        <span class="section-kicker">Fitur</span>
                        <h2>Modul utama mengikuti struktur aplikasi yang sudah tersedia di panel.</h2>
                        <p>
                            Setiap modul saling terhubung sehingga data log tidak berdiri sendiri, tetapi terkait dengan identitas perawat, lokasi ruangan, dan jadwal shift.
                        </p>
                    </div>

                    <div class="grid-3">
                        <article class="feature-card">
                            <h3>Log Cuci Tangan</h3>
                            <p>Menyimpan catatan aktivitas berdasarkan perawat, ruangan, shift, tanggal, dan waktu. Perawat dapat mencatat aktivitasnya sendiri, sedangkan admin dapat mengelola data lebih luas.</p>
                            <div class="label-row">
                                <span class="label">tanggal</span>
                                <span class="label">waktu</span>
                                <span class="label">shift</span>
                            </div>
                        </article>

                        <article class="feature-card">
                            <h3>Data Perawat</h3>
                            <p>Mengelola profil perawat seperti nama, NIP, jenis kelamin, nomor HP, dan alamat. Akses perawat dibatasi agar hanya melihat data yang sesuai akun masing-masing.</p>
                            <div class="label-row">
                                <span class="label">NIP</span>
                                <span class="label">profil</span>
                                <span class="label">akun</span>
                            </div>
                        </article>

                        <article class="feature-card">
                            <h3>Ruangan dan Shift</h3>
                            <p>Menjadi master referensi untuk lokasi dan waktu kerja. Data ini membuat laporan lebih mudah difilter berdasarkan area pelayanan dan periode kerja.</p>
                            <div class="label-row">
                                <span class="label">ruangan</span>
                                <span class="label">jam mulai</span>
                                <span class="label">jam selesai</span>
                            </div>
                        </article>

                        <article class="feature-card">
                            <h3>Dashboard Statistik</h3>
                            <p>Menampilkan total perawat, jumlah ruangan dan shift, aktivitas sepuluh menit terakhir, total hari ini, total minggu ini, serta total seluruh catatan.</p>
                            <div class="label-row">
                                <span class="label">hari ini</span>
                                <span class="label">mingguan</span>
                                <span class="label">total</span>
                            </div>
                        </article>

                        <article class="feature-card">
                            <h3>Grafik Aktivitas</h3>
                            <p>Menyajikan distribusi log cuci tangan tujuh hari terakhir berdasarkan shift, sehingga pola aktivitas dapat dilihat tanpa membaca tabel satu per satu.</p>
                            <div class="label-row">
                                <span class="label">7 hari</span>
                                <span class="label">per shift</span>
                                <span class="label">grafik</span>
                            </div>
                        </article>

                        <article class="feature-card">
                            <h3>Aktivitas Terbaru</h3>
                            <p>Admin dapat melihat log terbaru, sinyal aktivitas terkini, serta ruangan yang menonjol pada hari berjalan untuk membantu pemantauan cepat.</p>
                            <div class="label-row">
                                <span class="label">terbaru</span>
                                <span class="label">ruangan aktif</span>
                                <span class="label">monitoring</span>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section id="alur" class="band">
                <div class="section-inner">
                    <div class="section-heading">
                        <span class="section-kicker">Diagram Alur</span>
                        <h2>Alur kerja dari persiapan data sampai evaluasi dashboard.</h2>
                        <p>
                            Diagram ini menggambarkan proses utama yang terjadi di aplikasi, mulai dari admin menyiapkan master data hingga data digunakan untuk pemantauan kepatuhan.
                        </p>
                    </div>

                    <div class="flow-wrap" aria-label="Diagram alur aplikasi">
                        <div class="flow">
                            <article class="flow-step">
                                <span class="flow-index">1</span>
                                <h3>Login Pengguna</h3>
                                <p>Admin atau perawat masuk ke panel dashboard sesuai akun yang dimiliki.</p>
                            </article>

                            <article class="flow-step">
                                <span class="flow-index">2</span>
                                <h3>Siapkan Master</h3>
                                <p>Admin mengelola data perawat, ruangan, shift, dan jadwal sebagai referensi.</p>
                            </article>

                            <article class="flow-step">
                                <span class="flow-index">3</span>
                                <h3>Pilih Konteks</h3>
                                <p>Perawat memilih ruangan dan shift yang sedang dijalankan sebelum mencatat aksi.</p>
                            </article>

                            <article class="flow-step">
                                <span class="flow-index">4</span>
                                <h3>Catat Cuci Tangan</h3>
                                <p>Sistem menyimpan nurse_id, room_id, shift_id, tanggal, dan waktu ke log.</p>
                            </article>

                            <article class="flow-step">
                                <span class="flow-index">5</span>
                                <h3>Tampilkan Dashboard</h3>
                                <p>Log diolah menjadi statistik, grafik tujuh hari, dan daftar aktivitas terbaru.</p>
                            </article>

                            <article class="flow-step">
                                <span class="flow-index">6</span>
                                <h3>Evaluasi Mutu</h3>
                                <p>Admin meninjau pola aktivitas untuk menentukan tindak lanjut operasional.</p>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section class="band band-soft">
                <div class="section-inner">
                    <div class="section-heading">
                        <span class="section-kicker">Arsitektur</span>
                        <h2>Alur teknis sederhana dari tampilan sampai database.</h2>
                        <p>
                            Bagian ini menjelaskan bagaimana data bergerak di dalam aplikasi secara ringkas agar mudah dipahami oleh pengguna teknis maupun nonteknis.
                        </p>
                    </div>

                    <div class="architecture" aria-label="Arsitektur aplikasi">
                        <div class="architecture-node">
                            <strong>Browser</strong>
                            <span>Pengguna membuka halaman welcome atau panel dashboard.</span>
                        </div>
                        <div class="architecture-node">
                            <strong>Laravel Route</strong>
                            <span>Route utama menampilkan halaman ini, sedangkan panel berada di /dashboard.</span>
                        </div>
                        <div class="architecture-node">
                            <strong>Filament Panel</strong>
                            <span>Resource dan widget menyediakan form, tabel, grafik, dan statistik.</span>
                        </div>
                        <div class="architecture-node">
                            <strong>Eloquent Model</strong>
                            <span>Nurse, Room, Shift, Schedule, dan HandWashLog mengatur relasi data.</span>
                        </div>
                        <div class="architecture-node">
                            <strong>Database</strong>
                            <span>Data tersimpan dalam tabel terstruktur untuk laporan dan evaluasi.</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="band">
                <div class="section-inner">
                    <div class="section-heading">
                        <span class="section-kicker">Kelebihan dan Kekurangan</span>
                        <h2>Manfaat aplikasi kuat untuk pencatatan, tetapi masih punya batasan yang perlu dipahami.</h2>
                    </div>

                    <div class="comparison">
                        <article class="simple-card">
                            <h3>Kelebihan</h3>
                            <ul class="text-list">
                                <li>Pencatatan lebih cepat karena perawat dapat membuat log langsung dari dashboard.</li>
                                <li>Data lebih rapi karena setiap log terhubung dengan perawat, ruangan, dan shift.</li>
                                <li>Admin dapat melihat tren harian, mingguan, dan aktivitas terbaru tanpa rekap manual.</li>
                                <li>Akses data lebih terkontrol karena admin dan perawat memiliki cakupan akses berbeda.</li>
                                <li>Struktur Laravel dan Filament membuat pengembangan lanjutan relatif mudah dilakukan.</li>
                            </ul>
                        </article>

                        <article class="simple-card">
                            <h3>Kekurangan atau Batasan</h3>
                            <ul class="text-list">
                                <li>Validitas data masih bergantung pada kedisiplinan pengguna saat mencatat aktivitas.</li>
                                <li>Belum ada validasi sensor otomatis untuk memastikan aksi cuci tangan benar-benar terjadi.</li>
                                <li>Belum terlihat fitur bukti tambahan seperti foto, lokasi perangkat, atau integrasi alat.</li>
                                <li>Perhitungan kepatuhan terhadap jadwal ideal masih perlu aturan indikator yang lebih detail.</li>
                                <li>Export laporan, notifikasi keterlambatan, dan audit trail detail dapat menjadi pengembangan berikutnya.</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </section>

            <section class="band band-soft">
                <div class="section-inner">
                    <div class="section-heading">
                        <span class="section-kicker">Data</span>
                        <h2>Data inti yang dikelola aplikasi.</h2>
                        <p>
                            Tabel berikut membantu menjelaskan peran setiap data agar pengguna memahami hubungan antar fitur.
                        </p>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Fungsi</th>
                                <th>Contoh Penggunaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>users</code></td>
                                <td>Menyimpan akun, email, password, dan role pengguna.</td>
                                <td>Menentukan apakah pengguna masuk sebagai admin atau perawat.</td>
                            </tr>
                            <tr>
                                <td><code>nurses</code></td>
                                <td>Menyimpan profil perawat seperti nama, NIP, jenis kelamin, nomor HP, dan alamat.</td>
                                <td>Menghubungkan akun perawat dengan log cuci tangan miliknya.</td>
                            </tr>
                            <tr>
                                <td><code>rooms</code></td>
                                <td>Menyimpan daftar ruangan dan kode ruangan.</td>
                                <td>Melihat aktivitas cuci tangan berdasarkan area pelayanan.</td>
                            </tr>
                            <tr>
                                <td><code>shifts</code></td>
                                <td>Menyimpan nama shift, jam mulai, dan jam selesai.</td>
                                <td>Membandingkan aktivitas antar periode kerja.</td>
                            </tr>
                            <tr>
                                <td><code>nurse_schedules</code></td>
                                <td>Menyimpan relasi jadwal perawat dengan ruangan, shift, tanggal, dan status.</td>
                                <td>Menjadi dasar pengembangan analisis kepatuhan terhadap jadwal kerja.</td>
                            </tr>
                            <tr>
                                <td><code>hand_wash_logs</code></td>
                                <td>Menyimpan catatan utama cuci tangan: perawat, ruangan, shift, tanggal, dan waktu.</td>
                                <td>Menjadi sumber data dashboard, grafik, dan aktivitas terbaru.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="band">
                <div class="section-inner">
                    <div class="grid-2">
                        <div>
                            <div class="section-heading">
                                <span class="section-kicker">Cara Pakai</span>
                                <h2>Panduan singkat penggunaan harian.</h2>
                                <p>
                                    Alur ini bisa dipakai sebagai petunjuk awal untuk admin dan perawat saat pertama kali menggunakan sistem.
                                </p>
                            </div>
                        </div>

                        <div class="timeline">
                            <article class="timeline-item">
                                <div>
                                    <h3>Admin masuk ke dashboard</h3>
                                    <p>Admin memastikan data perawat, ruangan, dan shift sudah tersedia sebelum sistem digunakan.</p>
                                </div>
                            </article>
                            <article class="timeline-item">
                                <div>
                                    <h3>Perawat melengkapi atau memakai profil</h3>
                                    <p>Perawat menggunakan akun yang terhubung dengan data perawat agar log otomatis mengarah ke identitas yang benar.</p>
                                </div>
                            </article>
                            <article class="timeline-item">
                                <div>
                                    <h3>Perawat mencatat aktivitas</h3>
                                    <p>Perawat memilih ruangan dan shift, lalu mencatat cuci tangan saat aktivitas dilakukan.</p>
                                </div>
                            </article>
                            <article class="timeline-item">
                                <div>
                                    <h3>Admin memantau hasil</h3>
                                    <p>Admin membuka statistik, grafik, dan aktivitas terbaru untuk melihat perkembangan kepatuhan.</p>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section class="band band-soft">
                <div class="section-inner">
                    <div class="section-heading">
                        <span class="section-kicker">Pengembangan Lanjutan</span>
                        <h2>Beberapa ide peningkatan agar aplikasi semakin lengkap.</h2>
                    </div>

                    <div class="grid-3">
                        <article class="simple-card">
                            <h3>Indikator Kepatuhan</h3>
                            <p>Menambahkan rumus target per shift atau per ruangan agar dashboard tidak hanya menghitung log, tetapi juga menilai pencapaian.</p>
                        </article>
                        <article class="simple-card">
                            <h3>Laporan dan Export</h3>
                            <p>Menyediakan export PDF atau Excel untuk laporan harian, mingguan, bulanan, dan arsip audit mutu.</p>
                        </article>
                        <article class="simple-card">
                            <h3>Integrasi Validasi</h3>
                            <p>Menghubungkan sistem dengan QR, NFC, sensor, atau perangkat wastafel untuk mengurangi pencatatan yang tidak sesuai kejadian.</p>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="section-inner footer-inner">
                <span>Cuci Tangan - Sistem Monitoring Kepatuhan Perawat</span>
                <a href="{{ $dashboardUrl }}">Masuk ke dashboard</a>
            </div>
        </footer>
    </div>
</body>
</html>
