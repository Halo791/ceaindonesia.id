<?php

$baseUrl = 'https://ceaindonesia.id';

return [
    'navigation' => [
        ['key' => 'beranda', 'label' => 'BERANDA', 'href' => '/', 'sourceHref' => $baseUrl.'/', 'description' => 'Halaman utama CEA Indonesia dan ringkasan aliansi.'],
        [
            'key' => 'profil',
            'label' => 'PROFIL',
            'href' => '/admin/profil',
            'publicHref' => '/profil/riwayat',
            'sourceHref' => $baseUrl.'/riwayat/',
            'description' => 'Kelola riwayat, mandat, struktur gerak, sumber daya, kontak, dan dokumen profil CEA.',
            'children' => [
                ['key' => 'riwayat', 'label' => 'Riwayat', 'href' => '/admin/profil/riwayat', 'publicHref' => '/profil/riwayat', 'sourceHref' => $baseUrl.'/riwayat/', 'description' => 'Latar pembentukan CEA dan kronologi rembug nasional.'],
                ['key' => 'mandat-visi-nilai', 'label' => 'Mandat, Visi, Nilai', 'href' => '/admin/profil/mandat-visi-nilai', 'sourceHref' => $baseUrl.'/', 'description' => 'Visi, mandat, tujuan, dan nilai-nilai gerakan CEA.'],
                ['key' => 'struktur-gerak', 'label' => 'Struktur Gerak', 'href' => '/admin/profil/struktur-gerak', 'sourceHref' => $baseUrl.'/struktur-gerak-cea/', 'description' => 'Struktur jejaring, simpul regional, gugus tugas, dan kaukus isu.'],
                ['key' => 'sumber-daya', 'label' => 'Sumber Daya', 'href' => '/admin/profil/sumber-daya', 'sourceHref' => $baseUrl.'/tata-kelola-sumber-daya-cea/', 'description' => 'Tata kelola sumber daya, mobilisasi, distribusi, dan kontribusi aliansi.'],
                ['key' => 'kontak', 'label' => 'Kontak', 'href' => '/admin/profil/kontak', 'sourceHref' => $baseUrl.'/kontak/', 'description' => 'Alamat sekretariat, kanal kontak, dan informasi penghubung publik.'],
            ],
        ],
        [
            'key' => 'regio',
            'label' => 'REGIO',
            'href' => '/admin/regio',
            'sourceHref' => $baseUrl.'/',
            'description' => 'Kelola data simpul regional dan organisasi anggota CEA.',
            'children' => [
                ['key' => 'simpul', 'label' => 'Simpul', 'href' => '/admin/regio/simpul', 'sourceHref' => $baseUrl.'/', 'description' => 'Peta simpul, focal point, wilayah kerja, dan status regional.'],
                ['key' => 'anggota', 'label' => 'Anggota', 'href' => '/admin/regio/anggota', 'sourceHref' => $baseUrl.'/', 'description' => 'Direktori organisasi anggota, profil lembaga, dan relasi simpul.'],
            ],
        ],
        [
            'key' => 'siar',
            'label' => 'SIAR',
            'href' => '/admin/siar',
            'sourceHref' => $baseUrl.'/siar/',
            'description' => 'Kelola kanal publikasi CEA: kabar, rilis, prakarsa, refleksi, dan referensi.',
            'children' => [
                ['key' => 'kabar', 'label' => 'Kabar', 'href' => '/admin/siar/kabar', 'sourceHref' => $baseUrl.'/siar/', 'description' => 'Artikel kabar terbaru dari kegiatan dan jejaring CEA.'],
                ['key' => 'rilis', 'label' => 'Rilis', 'href' => '/admin/siar/rilis', 'sourceHref' => $baseUrl.'/siar/', 'description' => 'Rilis pers, pernyataan solidaritas, dan respons kelembagaan.'],
                ['key' => 'prakarsa', 'label' => 'Prakarsa', 'href' => '/admin/siar/prakarsa', 'sourceHref' => $baseUrl.'/siar/', 'description' => 'Inisiatif, program, dan praktik kolaboratif dari simpul CEA.'],
                ['key' => 'refleksi', 'label' => 'Refleksi', 'href' => '/admin/siar/refleksi', 'sourceHref' => $baseUrl.'/siar/refleksi/', 'description' => 'Tulisan reflektif tentang ruang sipil, demokrasi, dan gerakan sosial.'],
                ['key' => 'referensi', 'label' => 'Referensi', 'href' => '/admin/siar/referensi', 'sourceHref' => $baseUrl.'/siar/', 'description' => 'Bahan bacaan, dokumen pengetahuan, dan rujukan riset.'],
            ],
        ],
        [
            'key' => 'aksi',
            'label' => 'AKSI',
            'href' => '/admin/aksi',
            'sourceHref' => $baseUrl.'/rencana-aksi-cea/',
            'description' => 'Kelola manifesto, kajian, gugus tugas, kaukus isu, dan diskursus publik CEA.',
            'children' => [
                ['key' => 'manifesto', 'label' => 'Manifesto', 'href' => '/admin/aksi/manifesto', 'sourceHref' => $baseUrl.'/rencana-aksi-cea/', 'description' => 'Narasi dasar, posisi gerakan, dan arah aksi CEA.'],
                ['key' => 'kajian-strategis', 'label' => 'Kajian Strategis', 'href' => '/admin/aksi/kajian-strategis', 'sourceHref' => $baseUrl.'/siar/', 'description' => 'Kajian strategis dan analisis isu prioritas aliansi.'],
                ['key' => 'gugus-tugas', 'label' => 'Gugus Tugas', 'href' => '/admin/aksi/gugus-tugas', 'sourceHref' => $baseUrl.'/struktur-gerak-cea/', 'description' => 'Kelompok kerja civic space dan civic engagement.'],
                ['key' => 'kaukus-isu', 'label' => 'Kaukus Isu', 'href' => '/admin/aksi/kaukus-isu', 'sourceHref' => 'https://menjadiindonesia.org', 'description' => 'Kaukus tematik dan kanal isu lintas sektor.'],
                ['key' => 'diskursus', 'label' => 'Diskursus', 'href' => '/admin/aksi/diskursus', 'sourceHref' => $baseUrl.'/', 'description' => 'Forum diskusi, percakapan publik, dan agenda pengetahuan.'],
            ],
        ],
        [
            'key' => 'koneksi',
            'label' => 'KONEKSI',
            'href' => '/admin/koneksi',
            'sourceHref' => $baseUrl.'/',
            'description' => 'Kelola koneksi ekosistem, platform kolaborasi, dan kanal mitra CEA.',
            'children' => [
                ['key' => 'lokadana', 'label' => 'Lokadana', 'href' => '/admin/koneksi/lokadana', 'sourceHref' => 'https://lokadana.lokadaya.id', 'description' => 'Platform hibah partisipatif dan mobilisasi sumber daya.'],
                ['key' => 'iwrf', 'label' => 'IWRF', 'href' => '/admin/koneksi/iwrf', 'sourceHref' => 'https://iwrf.id', 'description' => 'Koneksi ke ekosistem Indonesia Women Rights Forum.'],
                ['key' => 'idrf', 'label' => 'IDRF', 'href' => '/admin/koneksi/idrf', 'sourceHref' => 'https://idrf.id', 'description' => 'Koneksi ke ekosistem Indonesia Development Research Forum.'],
                ['key' => 'baku-dapa', 'label' => 'Baku-Dapa', 'href' => '/admin/koneksi/baku-dapa', 'sourceHref' => 'https://baku-dapa.id', 'description' => 'Ruang siar, radio komunitas, dan koneksi narasi bersama.'],
                ['key' => 'sociopath', 'label' => 'Sociopath', 'href' => '/admin/koneksi/sociopath', 'sourceHref' => 'https://sociopath.id', 'description' => 'Platform sosial dan kanal kolaborasi ekosistem gerakan.'],
            ],
        ],
        ['key' => 'kolektif', 'label' => 'KOLEKTIF', 'href' => '/admin/kolektif', 'sourceHref' => $baseUrl.'/', 'description' => 'Kelola narasi kolektif, testimoni simpul, dan arsip kolaborasi.'],
    ],
    'blog' => [
        ['id' => 1, 'title' => 'Scientists speculate that ours might not be held', 'img' => 'blog01.jpg', 'group' => 'blog', 'category' => 'Gaming', 'author' => 'miranda h.', 'date' => '25 April 2026'],
        ['id' => 2, 'title' => 'The Multiverse is the collection of alternate universes', 'img' => 'blog02.jpg', 'group' => 'blog', 'category' => 'Tech', 'author' => 'miranda h.', 'date' => '25 April 2026'],
        ['id' => 3, 'title' => 'That share a universal hierarchy a large variety of these', 'img' => 'blog03.jpg', 'group' => 'blog', 'category' => 'Movie', 'author' => 'miranda h.', 'date' => '25 April 2026'],
        ['id' => 4, 'title' => 'Universes were originated from another due to a major', 'img' => 'blog04.jpg', 'group' => 'blog', 'category' => 'Sports', 'author' => 'miranda h.', 'date' => '25 April 2026'],
        ['id' => 5, 'title' => 'A hypothetical collection of potentially diverse', 'img' => 'blog05.jpg', 'group' => 'blog', 'category' => 'Gaming', 'author' => 'miranda h.', 'date' => '25 April 2026'],
        ['id' => 6, 'title' => 'Stanford physicists Andrei Linde In a new study', 'img' => 'blog06.jpg', 'group' => 'blog', 'category' => 'Tech', 'author' => 'miranda h.', 'date' => '25 April 2026'],
    ],
];
