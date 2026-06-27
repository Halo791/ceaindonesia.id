ALTER TABLE `admin_pages`
  ADD COLUMN `hero_video_path` varchar(255) DEFAULT NULL AFTER `image_path`,
  ADD COLUMN `header_logo_path` varchar(255) DEFAULT NULL AFTER `hero_video_path`;
