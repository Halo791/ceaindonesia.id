-- Default login setelah import:
-- Super admin: admin / Admin@2026
-- Semua akun anggota simpul: username masing-masing / Simpul@2026
-- Re-import file ini tidak akan menimpa password yang sudah diganti.

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'member',
  `section_key` varchar(100) DEFAULT NULL,
  `item_key` varchar(150) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin_users` (`name`, `username`, `password_hash`, `role`, `section_key`, `item_key`, `is_active`, `created_at`, `updated_at`) VALUES
('Super Admin', 'admin', '$2y$10$MwS6hiVoYPuAbuzHZhtWOudSfCOwG1TTh19L5S3EqGCl5wdUYBdFS', 'super_admin', NULL, NULL, 1, NOW(), NOW()),
('Yayasan Peduli Kemandirian Masyarakat (YAPEMMAS) Medan', 'yapemmas-medan', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-tangguh/yayasan-peduli-kemandirian-masyarakat-yapemmas-medan', 1, NOW(), NOW()),
('Yayasan Fajar Sejahtera Indonesia (YAFSI)-Medan', 'yafsi-medan', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-tangguh/yayasan-fajar-sejahtera-indonesia-yafsi-medan', 1, NOW(), NOW()),
('WALHI Sumbar', 'walhi-sumbar', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-tangguh/walhi-sumbar', 1, NOW(), NOW()),
('WALHI SUMUT', 'walhi-sumut', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-tangguh/walhi-sumut', 1, NOW(), NOW()),
('FLOWER Aceh', 'flower-aceh', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-tangguh/flower-aceh', 1, NOW(), NOW()),
('Yayasan Perempuan dan Anak Negeri (YPANBA) Aceh', 'ypanba-aceh', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-tangguh/yayasan-perempuan-dan-anak-negeri-ypanba-aceh', 1, NOW(), NOW()),
('WALHI Lampung', 'walhi-lampung', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-pulih-lestari/walhi-lampung', 1, NOW(), NOW()),
('LBH Bandar Lampung', 'lbh-bandar-lampung', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-pulih-lestari/lbh-bandar-lampung', 1, NOW(), NOW()),
('PKBI Lampung', 'pkbi-lampung', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-pulih-lestari/pkbi-lampung', 1, NOW(), NOW()),
('WALHI Bengkulu', 'walhi-bengkulu', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-pulih-lestari/walhi-bengkulu', 1, NOW(), NOW()),
('YKWS Lampung', 'ykws-lampung', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/sumbagsel-pulih-lestari/ykws-lampung', 1, NOW(), NOW()),
('LEKAT Jayapura', 'lekat-jayapura', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/lekat-jayapura', 1, NOW(), NOW()),
('KIPRA Jayapura', 'kipra-jayapura', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/kipra-jayapura', 1, NOW(), NOW()),
('YAPMI Jayapura', 'yapmi-jayapura', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/yapmi-jayapura', 1, NOW(), NOW()),
('GEMAPALA Fakfak', 'gemapala-fakfak', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/gemapala-fakfak', 1, NOW(), NOW()),
('YAPARI Sorong', 'yapari-sorong', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/yapari-sorong', 1, NOW(), NOW()),
('PERDU Manokwari', 'perdu-manokwari', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/perdu-manokwari', 1, NOW(), NOW()),
('KOMPAK Nabire', 'kompak-nabire', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/kompak-nabire', 1, NOW(), NOW()),
('HUMI INANE Wamena', 'humi-inane-wamena', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/tanah-papua/humi-inane-wamena', 1, NOW(), NOW()),
('WALHI Kalbar', 'walhi-kalbar', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/kalimantan-borneo/walhi-kalbar', 1, NOW(), NOW()),
('WALHI Kalsel', 'walhi-kalsel', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/kalimantan-borneo/walhi-kalsel', 1, NOW(), NOW()),
('WALHI Kalteng', 'walhi-kalteng', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/kalimantan-borneo/walhi-kalteng', 1, NOW(), NOW()),
('WALHI Kaltim', 'walhi-kaltim', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/kalimantan-borneo/walhi-kaltim', 1, NOW(), NOW()),
('ELPAGAR KalBar', 'elpagar-kalbar', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/kalimantan-borneo/elpagar-kalbar', 1, NOW(), NOW()),
('BORNEO Institute Kalteng', 'borneo-institute-kalteng', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/kalimantan-borneo/borneo-institute-kalteng', 1, NOW(), NOW()),
('PIONIR Bulungan Kaltara', 'pionir-bulungan-kaltara', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/kalimantan-borneo/pionir-bulungan-kaltara', 1, NOW(), NOW()),
('WALHI Jatim', 'walhi-jatim', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/jawa/walhi-jatim', 1, NOW(), NOW()),
('WALHI Jogjakarta', 'walhi-jogjakarta', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/jawa/walhi-jogjakarta', 1, NOW(), NOW()),
('LBH Semarang', 'lbh-semarang', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/jawa/lbh-semarang', 1, NOW(), NOW()),
('LBH Surabaya', 'lbh-surabaya', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/jawa/lbh-surabaya', 1, NOW(), NOW()),
('LBH Jogjakarta', 'lbh-jogjakarta', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/jawa/lbh-jogjakarta', 1, NOW(), NOW()),
('Yayasan EPIK', 'yayasan-epik', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/jawa/yayasan-epik', 1, NOW(), NOW()),
('KPI Jabar', 'kpi-jabar', '$2y$10$GGziwYpS/6pBXy44itkuR.0DydW5dcPmh/BINFmsvyonaq10aWkzm', 'member', 'regio', 'simpul/jawa/kpi-jabar', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `role` = VALUES(`role`),
  `section_key` = VALUES(`section_key`),
  `item_key` = VALUES(`item_key`),
  `is_active` = VALUES(`is_active`),
  `updated_at` = NOW();
