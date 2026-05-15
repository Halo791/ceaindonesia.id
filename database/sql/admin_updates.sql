CREATE TABLE IF NOT EXISTS `admin_updates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `owner_section_key` varchar(100) NOT NULL,
  `owner_item_key` varchar(150) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `category` varchar(80) NOT NULL DEFAULT 'Berita',
  `excerpt` varchar(255) DEFAULT NULL,
  `body` longtext,
  `image_path` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_updates_slug_unique` (`slug`),
  KEY `admin_updates_owner_index` (`owner_section_key`, `owner_item_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
