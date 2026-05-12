CREATE TABLE IF NOT EXISTS `admin_contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section_key` varchar(100) NOT NULL,
  `item_key` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `body` longtext,
  `image_path` varchar(255) DEFAULT NULL,
  `source_href` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'draft',
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_contents_section_item_unique` (`section_key`, `item_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin_contents` (`section_key`, `item_key`, `title`, `subtitle`, `body`, `image_path`, `source_href`, `status`, `created_at`, `updated_at`) VALUES
('profil', '', 'Pooling Fund - KSO', 'Platform mandat kolektif antar CSO untuk menghimpun dan menyalurkan dana kemanusiaan secara bersama.', 'Perubahan besar tidak lahir dari satu lembaga, tapi dari ekosistem yang terhubung.

Pooling Fund - KSO adalah platform mandat kolektif antar CSO untuk menghimpun dan menyalurkan dana kemanusiaan secara bersama, berbasis kebutuhan komunitas dan kepemimpinan lokal, tanpa membentuk badan hukum baru.

Tagline: Menguatkan Lokal, Memperluas Dampak.', '/assets/img/cea/campur.png', 'https://ceaindonesia.id/riwayat/', 'active', NOW(), NOW()),
('profil', 'riwayat', 'Profil Pooling Fund - KSO', 'Platform kerja sama operasional yang menghubungkan simpul kekuatan sipil di berbagai wilayah Indonesia.', 'Pooling Fund - KSO bukanlah sebuah entitas tunggal yang hierarkis, melainkan infrastruktur bersama yang menghubungkan simpul-simpul kekuatan sipil di berbagai wilayah Indonesia.

Sebagai platform kerja sama operasional, struktur ini didesain untuk menjaga kedaulatan setiap organisasi anggota sambil memperkuat daya tawar kolektif dalam pengelolaan sumber daya kemanusiaan.

KSO bergerak melalui tujuh simpul regional yang bersifat otonom dan independen, namun terikat dalam satu nafas visi yang sama: mewujudkan kepemimpinan lokal yang berkeadilan.', '/assets/img/cea/campur.png', 'https://ceaindonesia.id/riwayat/', 'active', NOW(), NOW()),
('profil', 'mandat-visi-nilai', 'Mandat, Visi, Misi KSO-Pooling Fund', 'Satu mandat kolektif untuk kepemimpinan lokal dan respon kemanusiaan yang berkeadilan.', 'Mandat PF-KSO adalah memperkuat kepemimpinan lokal, membangun ekosistem kolaborasi sosial, dan mendorong respon kemanusiaan yang adil, inklusif, serta berakar pada komunitas.

Visi: Satu mandat kolektif untuk kepemimpinan lokal dan respon kemanusiaan yang berkeadilan.

Misi: memperkuat kepemimpinan lokal dan peran komunitas dalam respon sosial dan kemanusiaan; membangun ekosistem kolaborasi multipihak yang inklusif, setara, dan berbasis kepercayaan; mengembangkan pendekatan pooling fund dan pengelolaan sumber daya bersama yang transparan dan akuntabel; mendorong pertukaran pengetahuan, penguatan kapasitas, dan pembelajaran kolektif antar komunitas dan organisasi; serta memastikan respon kemanusiaan dan pembangunan sosial lebih adil, partisipatif, dan berpihak pada kelompok rentan.

Tujuan pembentukan KSO-Pooling Fund adalah menghimpun dan mengelola dana kemanusiaan secara cepat, transparan, dan akuntabel; membagi risiko dan tanggung jawab operasional serta tata kelola secara kolektif; memperkuat local leadership dalam respon bencana kemanusiaan; mengurangi fragmentasi respon; menjadi satu pintu komunikasi ke donor dan publik sekaligus instrumen kepercayaan; serta menjadi model transisi menuju kelembagaan pooling fund yang lebih mapan.

Prinsip dan karakter KSO-Pooling Fund meliputi kesetaraan antar anggota, satu CSO satu suara, berbasis kebutuhan komunitas, kecepatan sebagai nilai utama, transparansi sebagai aset strategis, akuntabilitas kolektif, serta local leadership dan local first.', '/assets/img/cea/pomelli_bdna_image_0510%20%285%29.png', 'https://ceaindonesia.id/mandat-visi-nilai-cea/', 'active', NOW(), NOW()),
('profil', 'struktur-gerak', 'Arsitektur Mandat Kolektif', 'Tujuh simpul regional yang otonom, independen, dan terhubung dalam satu visi kepemimpinan lokal.', 'Pooling Fund KSO bukanlah entitas tunggal yang hierarkis, melainkan infrastruktur bersama yang menghubungkan simpul-simpul kekuatan sipil di berbagai wilayah Indonesia.

Arsitektur ini menjaga kedaulatan setiap organisasi anggota sambil memperkuat daya tawar kolektif dalam pengelolaan sumber daya kemanusiaan. Setiap simpul regional bekerja secara otonom dan independen, namun terikat pada visi yang sama.

Prinsip gerak kami mencakup mandat kolektif melalui Forum Anggota dengan prinsip one organization, one vote; pemisahan peran antara fungsi strategis Forum dan Komite dengan fungsi operasional Administrator; serta ketahanan ekosistem melalui pertukaran pembelajaran, risiko, dan tanggung jawab antar simpul regional.', '/assets/img/cea/struktur_gerak.png', 'https://ceaindonesia.id/struktur-gerak-cea/', 'active', NOW(), NOW()),
('profil', 'sumber-daya', 'Tata Kelola Sumber Daya', 'Sumber daya ditempatkan sebagai mandat kolektif untuk memperkuat ekosistem kemanusiaan dan kepemimpinan lokal.', 'KSO menempatkan sumber daya bukan sebagai aset lembaga, melainkan mandat kolektif untuk memperkuat ekosistem kemanusiaan dan kepemimpinan lokal.

Pengambilan keputusan dilakukan oleh mereka yang paling dekat dengan krisis, sehingga dana dikelola secara transparan demi kedaulatan serta ketangguhan komunitas di setiap wilayah.

Pendekatan ini memperkuat kecepatan respon, akuntabilitas kolektif, serta kepercayaan donor dan publik terhadap kerja kemanusiaan yang dipimpin dari lokal.', '/assets/img/cea/tatakelola.png', 'https://ceaindonesia.id/tata-kelola-sumber-daya-cea/', 'active', NOW(), NOW()),
('regio', 'simpul', 'Sebaran Region Simpul KSO-Pooling Fund', 'Daftar simpul regional dan anggota KSO-Pooling Fund di berbagai wilayah Indonesia.', '1. KSO-Pooling Fund SUMBAGSEL (Sumatera Bagian Selatan) "Tangguh"
Anggota:
1. Yayasan Peduli Kemandirian Masyarakat (YAPEMMAS) Medan
2. Yayasan Fajar Sejahtera Indonesia (YAFSI)-Medan
3. WALHI Sumbar
4. WALHI SUMUT
5. FLOWER Aceh
6. Yayasan Perempuan dan Anak Negeri (YPANBA) Aceh

2. KSO-Pooling Fund SUMBAGSEL (Sumatera Bagian Selatan) "Pulih dan Lestari"
Anggota:
1. WALHI Lampung
2. LBH Bandar Lampung
3. PKBI Lampung
4. WALHI Bengkulu
5. YKWS Lampung

3. KSO-Pooling Fund Region Papua (KSO Tanah Papua)
Anggota:
1. LEKAT Jayapura
2. KIPRA Jayapura
3. YAPMI Jayapura
4. GEMAPALA Fakfak
5. YAPARI Sorong
6. PERDU Manokwari
7. KOMPAK Nabire
8. HUMI INANE Wamena

4. KSO-Pooling Fund Region Kalimantan (Solidaritas Kemanusiaan Borneo)
Anggota:
1. WALHI Kalbar
2. WALHI Kalsel
3. WALHI Kalteng
4. WALHI Kaltim
5. ELPAGAR KalBar
6. BORNEO Institute Kalteng
7. PIONIR Bulungan Kaltara

5. KSO-Pooling Fund Region Jawa
Anggota:
1. WALHI Jatim
2. WALHI Jogjakarta
3. LBH Semarang
4. LBH Surabaya
5. LBH Jogjakarta
6. Yayasan EPIK
7. KPI Jabar

6. KSO-Pooling Fund Region Sulawesi

7. KSO-Pooling Fund Region Bali Nusra', '/assets/img/cea/campur.png', 'https://ceaindonesia.id/', 'active', NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `title` = VALUES(`title`),
  `subtitle` = VALUES(`subtitle`),
  `body` = VALUES(`body`),
  `image_path` = VALUES(`image_path`),
  `source_href` = VALUES(`source_href`),
  `status` = VALUES(`status`),
  `updated_at` = NOW();
