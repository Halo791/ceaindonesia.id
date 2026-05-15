ALTER TABLE `admin_pages`
  ADD COLUMN IF NOT EXISTS `title_en` varchar(255) DEFAULT NULL AFTER `title`,
  ADD COLUMN IF NOT EXISTS `menu_label_en` varchar(255) DEFAULT NULL AFTER `menu_label`,
  ADD COLUMN IF NOT EXISTS `subtitle_en` varchar(255) DEFAULT NULL AFTER `subtitle`,
  ADD COLUMN IF NOT EXISTS `body_en` longtext AFTER `body`;

ALTER TABLE `admin_updates`
  ADD COLUMN IF NOT EXISTS `title_en` varchar(255) DEFAULT NULL AFTER `title`,
  ADD COLUMN IF NOT EXISTS `category_en` varchar(80) DEFAULT NULL AFTER `category`,
  ADD COLUMN IF NOT EXISTS `excerpt_en` varchar(255) DEFAULT NULL AFTER `excerpt`,
  ADD COLUMN IF NOT EXISTS `body_en` longtext AFTER `body`;
