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
