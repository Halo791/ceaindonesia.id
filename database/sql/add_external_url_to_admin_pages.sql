ALTER TABLE `admin_pages`
  ADD COLUMN `external_url` varchar(255) DEFAULT NULL AFTER `image_path`;
