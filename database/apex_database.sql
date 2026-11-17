-- =====================================================================
-- APEX Events & Competitions — Complete Database Schema
-- MySQL 5.7+ / MariaDB 10.3+ · InnoDB · utf8mb4
-- Import this file through phpMyAdmin or: mysql -u user -p apex_db < apex_database.sql
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS `apex_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `apex_db`;

-- =====================================================================
-- Admins & Access Control
-- =====================================================================
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(190) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin','admin','editor') NOT NULL DEFAULT 'admin',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login_at` DATETIME NULL,
  `failed_login_count` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `locked_until` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `admin_activity_logs`;
CREATE TABLE `admin_activity_logs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` INT UNSIGNED NULL,
  `action` VARCHAR(80) NOT NULL,
  `entity_type` VARCHAR(80) NULL,
  `entity_id` INT UNSIGNED NULL,
  `description` VARCHAR(400) NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_admin` (`admin_id`),
  KEY `idx_created` (`created_at`),
  CONSTRAINT `fk_log_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Site Settings, Pages, Navigation, Social
-- =====================================================================
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `setting_type` ENUM('text','textarea','number','email','url','bool','image') NOT NULL DEFAULT 'text',
  `setting_group` VARCHAR(60) NOT NULL DEFAULT 'general',
  `label` VARCHAR(160) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_group` (`setting_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `title` VARCHAR(200) NOT NULL,
  `meta_title` VARCHAR(200) NULL,
  `meta_description` VARCHAR(300) NULL,
  `content` MEDIUMTEXT NULL,
  `is_published` TINYINT(1) NOT NULL DEFAULT 1,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `navigation_items`;
CREATE TABLE `navigation_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(100) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `location` ENUM('header','footer','footer_company','footer_services','footer_for','footer_card') NOT NULL DEFAULT 'header',
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `is_cta` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_location` (`location`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `social_links`;
CREATE TABLE `social_links` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `platform` VARCHAR(50) NOT NULL,
  `label` VARCHAR(60) NULL,
  `url` VARCHAR(255) NOT NULL,
  `icon` VARCHAR(80) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Team
-- =====================================================================
DROP TABLE IF EXISTS `team_members`;
CREATE TABLE `team_members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `role` VARCHAR(120) NOT NULL,
  `bio` VARCHAR(400) NULL,
  `photo` VARCHAR(255) NULL,
  `email` VARCHAR(190) NULL,
  `linkedin` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Categories (competitions & events)
-- =====================================================================
DROP TABLE IF EXISTS `competition_categories`;
CREATE TABLE `competition_categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `slug` VARCHAR(140) NOT NULL UNIQUE,
  `description` VARCHAR(400) NULL,
  `icon` VARCHAR(80) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `event_categories`;
CREATE TABLE `event_categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `slug` VARCHAR(140) NOT NULL UNIQUE,
  `description` VARCHAR(400) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Competitions (Calendar / Upcoming)
-- =====================================================================
DROP TABLE IF EXISTS `competitions`;
CREATE TABLE `competitions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `category_id` INT UNSIGNED NULL,
  `description` TEXT NULL,
  `eligibility` VARCHAR(400) NULL,
  `level` VARCHAR(80) NULL,
  `team_size` VARCHAR(80) NULL,
  `event_date` DATE NULL,
  `event_end_date` DATE NULL,
  `registration_deadline` DATE NULL,
  `venue` VARCHAR(200) NULL,
  `city` VARCHAR(80) NULL,
  `entry_fee` VARCHAR(80) NULL,
  `prizes` VARCHAR(400) NULL,
  `registration_status` ENUM('open','closing_soon','closed','coming_soon') NOT NULL DEFAULT 'open',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `cover_image` VARCHAR(255) NULL,
  `rules_pdf` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`),
  KEY `idx_date` (`event_date`),
  KEY `idx_status` (`registration_status`),
  CONSTRAINT `fk_comp_cat` FOREIGN KEY (`category_id`) REFERENCES `competition_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Event Services (Events page)
-- =====================================================================
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `category_id` INT UNSIGNED NULL,
  `headline` VARCHAR(200) NULL,
  `description` TEXT NULL,
  `deliverables` TEXT NULL,
  `ideal_for` VARCHAR(300) NULL,
  `icon` VARCHAR(80) NULL,
  `cover_image` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_evt_cat` (`category_id`),
  CONSTRAINT `fk_evt_cat` FOREIGN KEY (`category_id`) REFERENCES `event_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Institutions
-- =====================================================================
DROP TABLE IF EXISTS `institutions`;
CREATE TABLE `institutions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `type` ENUM('School','College','University','Academy','Institute','Corporate','NGO','Other') NOT NULL DEFAULT 'School',
  `city` VARCHAR(80) NULL,
  `email` VARCHAR(190) NULL,
  `phone` VARCHAR(30) NULL,
  `contact_person` VARCHAR(120) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_name_city` (`name`,`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Competition Registrations
-- =====================================================================
DROP TABLE IF EXISTS `event_registrations`;
CREATE TABLE `event_registrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` INT UNSIGNED NOT NULL,
  `institution_name` VARCHAR(200) NOT NULL,
  `institution_type` VARCHAR(80) NULL,
  `city` VARCHAR(80) NULL,
  `coordinator_name` VARCHAR(140) NOT NULL,
  `coordinator_role` VARCHAR(140) NULL,
  `coordinator_email` VARCHAR(190) NOT NULL,
  `coordinator_phone` VARCHAR(30) NOT NULL,
  `team_name` VARCHAR(140) NULL,
  `team_size` TINYINT UNSIGNED NULL,
  `category_level` VARCHAR(60) NULL,
  `participants_json` TEXT NULL,
  `notes` TEXT NULL,
  `consent_given` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('new','confirmed','contacted','rejected','cancelled') NOT NULL DEFAULT 'new',
  `admin_notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_comp` (`competition_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created` (`created_at`),
  CONSTRAINT `fk_reg_comp` FOREIGN KEY (`competition_id`) REFERENCES `competitions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `participants`;
CREATE TABLE `participants` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `registration_id` INT UNSIGNED NOT NULL,
  `full_name` VARCHAR(140) NOT NULL,
  `class_grade` VARCHAR(40) NULL,
  `age` TINYINT UNSIGNED NULL,
  `email` VARCHAR(190) NULL,
  `phone` VARCHAR(30) NULL,
  PRIMARY KEY (`id`),
  KEY `idx_reg` (`registration_id`),
  CONSTRAINT `fk_part_reg` FOREIGN KEY (`registration_id`) REFERENCES `event_registrations`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Portfolio / Past events
-- =====================================================================
DROP TABLE IF EXISTS `portfolio_items`;
CREATE TABLE `portfolio_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `category` VARCHAR(80) NOT NULL,
  `institution` VARCHAR(200) NULL,
  `city` VARCHAR(80) NULL,
  `event_date` DATE NULL,
  `summary` TEXT NULL,
  `brief` TEXT NULL,
  `what_we_did` TEXT NULL,
  `result_text` TEXT NULL,
  `participants_count` INT UNSIGNED NULL,
  `teams_count` INT UNSIGNED NULL,
  `cover_image` VARCHAR(255) NULL,
  `video_url` VARCHAR(255) NULL,
  `results_json` TEXT NULL,
  `quote_text` VARCHAR(600) NULL,
  `quote_by` VARCHAR(160) NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_published` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_cat_date` (`category`, `event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `portfolio_images`;
CREATE TABLE `portfolio_images` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `portfolio_id` INT UNSIGNED NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(200) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_folio` (`portfolio_id`),
  CONSTRAINT `fk_img_folio` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolio_items`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Partners
-- =====================================================================
DROP TABLE IF EXISTS `partner_categories`;
CREATE TABLE `partner_categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(60) NOT NULL UNIQUE,
  `name` VARCHAR(140) NOT NULL,
  `description` VARCHAR(400) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `partners`;
CREATE TABLE `partners` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `category_id` INT UNSIGNED NULL,
  `city` VARCHAR(80) NULL,
  `description` VARCHAR(500) NULL,
  `logo` VARCHAR(255) NULL,
  `website` VARCHAR(255) NULL,
  `discount` VARCHAR(140) NULL,
  `since_year` VARCHAR(10) NULL,
  `is_card_partner` TINYINT(1) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_cat` (`category_id`),
  KEY `idx_city` (`city`),
  CONSTRAINT `fk_partner_cat` FOREIGN KEY (`category_id`) REFERENCES `partner_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Sponsorship
-- =====================================================================
DROP TABLE IF EXISTS `sponsorship_tiers`;
CREATE TABLE `sponsorship_tiers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `tagline` VARCHAR(200) NULL,
  `price` VARCHAR(80) NULL,
  `benefits` TEXT NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `sponsorship_applications`;
CREATE TABLE `sponsorship_applications` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(200) NOT NULL,
  `contact_person` VARCHAR(140) NOT NULL,
  `designation` VARCHAR(140) NULL,
  `email` VARCHAR(190) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `tier_id` INT UNSIGNED NULL,
  `interests` VARCHAR(500) NULL,
  `budget` VARCHAR(80) NULL,
  `message` TEXT NULL,
  `status` ENUM('new','in_progress','contacted','resolved','rejected') NOT NULL DEFAULT 'new',
  `admin_notes` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_sponsor_tier` FOREIGN KEY (`tier_id`) REFERENCES `sponsorship_tiers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- APEX Card
-- =====================================================================
DROP TABLE IF EXISTS `apex_card_types`;
CREATE TABLE `apex_card_types` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  `tagline` VARCHAR(200) NULL,
  `price` VARCHAR(80) NULL,
  `description` TEXT NULL,
  `benefits` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `apex_card_applications`;
CREATE TABLE `apex_card_applications` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `card_type_id` INT UNSIGNED NULL,
  `card_type_name` VARCHAR(80) NULL,
  `student_name` VARCHAR(140) NOT NULL,
  `date_of_birth` DATE NULL,
  `institution_name` VARCHAR(200) NULL,
  `class_year` VARCHAR(60) NULL,
  `guardian_name` VARCHAR(140) NULL,
  `phone` VARCHAR(30) NOT NULL,
  `email` VARCHAR(190) NULL,
  `city` VARCHAR(80) NOT NULL,
  `delivery_address` TEXT NOT NULL,
  `photo` VARCHAR(255) NULL,
  `consent_given` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('new','pending_payment','approved','printed','delivered','rejected') NOT NULL DEFAULT 'new',
  `admin_notes` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_card_type` FOREIGN KEY (`card_type_id`) REFERENCES `apex_card_types`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- Enquiries / messages / trips
-- =====================================================================
DROP TABLE IF EXISTS `proposal_enquiries`;
CREATE TABLE `proposal_enquiries` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(140) NOT NULL,
  `designation` VARCHAR(140) NULL,
  `institution_name` VARCHAR(200) NOT NULL,
  `institution_type` VARCHAR(80) NULL,
  `email` VARCHAR(190) NULL,
  `phone` VARCHAR(30) NOT NULL,
  `event_type` VARCHAR(150) NULL,
  `interests` VARCHAR(500) NULL,
  `expected_date` DATE NULL,
  `city_venue` VARCHAR(200) NULL,
  `participants` VARCHAR(60) NULL,
  `budget` VARCHAR(80) NULL,
  `source` VARCHAR(80) NULL,
  `message` TEXT NULL,
  `consent_given` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('new','in_progress','contacted','resolved','rejected') NOT NULL DEFAULT 'new',
  `admin_notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(140) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `phone` VARCHAR(30) NULL,
  `subject` VARCHAR(200) NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('new','read','replied','archived') NOT NULL DEFAULT 'new',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `trip_enquiries`;
CREATE TABLE `trip_enquiries` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `institution_name` VARCHAR(200) NOT NULL,
  `contact_name` VARCHAR(140) NOT NULL,
  `email` VARCHAR(190) NULL,
  `phone` VARCHAR(30) NOT NULL,
  `trip_type` VARCHAR(80) NULL,
  `destination` VARCHAR(200) NULL,
  `expected_date` DATE NULL,
  `participants` VARCHAR(60) NULL,
  `age_group` VARCHAR(80) NULL,
  `notes` TEXT NULL,
  `status` ENUM('new','in_progress','contacted','resolved','rejected') NOT NULL DEFAULT 'new',
  `admin_notes` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- FAQs, testimonials, subscribers, media
-- =====================================================================
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(400) NOT NULL,
  `answer` TEXT NOT NULL,
  `category` VARCHAR(80) NOT NULL DEFAULT 'General',
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_cat` (`category`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `quote` TEXT NOT NULL,
  `author_name` VARCHAR(140) NOT NULL,
  `author_role` VARCHAR(140) NULL,
  `author_institution` VARCHAR(200) NULL,
  `photo` VARCHAR(255) NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE `subscribers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(190) NOT NULL UNIQUE,
  `source` VARCHAR(80) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_path` VARCHAR(255) NOT NULL,
  `original_name` VARCHAR(255) NOT NULL,
  `mime_type` VARCHAR(80) NULL,
  `file_size` INT UNSIGNED NULL,
  `collection` VARCHAR(80) NOT NULL DEFAULT 'general',
  `alt_text` VARCHAR(200) NULL,
  `uploaded_by` INT UNSIGNED NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_collection` (`collection`),
  CONSTRAINT `fk_media_admin` FOREIGN KEY (`uploaded_by`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- INITIAL DATA
-- =====================================================================

-- Default admin: email admin@apex.local · password: ApexAdmin!2026
-- (bcrypt hash below — change the password from Dashboard > Settings on first login)
INSERT INTO `admins` (`name`,`email`,`password_hash`,`role`,`is_active`) VALUES
('APEX Administrator','admin@apex.local','$2y$10$8tqTIjVneRKaMLnt0noajep28F1cj20e32dfO2RbgM2sKzS7YCWDm','super_admin',1);

-- Site settings
INSERT INTO `site_settings` (`setting_key`,`setting_value`,`setting_type`,`setting_group`,`label`,`sort_order`) VALUES
('site_name','APEX Events & Competitions','text','general','Site name',1),
('site_tagline','Creating Experiences. Managing Competitions. Celebrating Excellence.','text','general','Tagline',2),
('site_description','APEX Events & Competitions plans and manages events and competitions for schools, colleges, universities and educational institutions — inter-school and inter-college competitions, sports championships, ceremonies, festivals, exhibitions and seminars.','textarea','general','Site description',3),
('contact_email','info@apex.local','email','contact','Contact email',10),
('contact_phone','+92 XXX XXXXXXX','text','contact','Contact phone',11),
('contact_whatsapp','+92 XXX XXXXXXX','text','contact','WhatsApp number',12),
('contact_address','[Street Address, City]','textarea','contact','Office address',13),
('contact_hours','Monday – Saturday, 9:00 am – 6:00 pm','text','contact','Office hours',14),
('admin_notify_email','admin@apex.local','email','notifications','Admin notification email',20),
('smtp_host','','text','email','SMTP host',30),
('smtp_port','587','number','email','SMTP port',31),
('smtp_user','','text','email','SMTP username',32),
('smtp_pass','','text','email','SMTP password',33),
('smtp_from','info@apex.local','email','email','From email',34),
('smtp_from_name','APEX Events & Competitions','text','email','From name',35),
('smtp_encryption','tls','text','email','Encryption (tls/ssl/none)',36),
('response_time','one working day','text','general','Response time',40),
('apex_card_renewal','12 months','text','card','APEX Card validity',50),
('digital_card_days','2','text','card','Digital card arrival (days)',51),
('printed_card_days','7–10','text','card','Printed card arrival (days)',52);

-- Navigation (header)
INSERT INTO `navigation_items` (`label`,`url`,`location`,`sort_order`,`is_active`,`is_cta`) VALUES
('Home','index.php','header',1,1,0),
('Competitions','competitions.php','header',2,1,0),
('Events','events.php','header',3,1,0),
('APEX Card','apex-card.php','header',4,1,0),
('For Schools','schools.php','header',5,1,0),
('For Colleges','colleges.php','header',6,1,0),
('Portfolio','portfolio.php','header',7,1,0),
('About','about.php','header',8,1,0),
('Contact','contact.php','header',9,1,0),
('Request a Proposal','contact.php','header',10,1,1),
('About Us','about.php','footer_company',1,1,0),
('Portfolio','portfolio.php','footer_company',2,1,0),
('FAQ','faq.php','footer_company',3,1,0),
('Contact','contact.php','footer_company',4,1,0),
('Academic Competitions','competitions.php','footer_services',1,1,0),
('Sports','events.php','footer_services',2,1,0),
('Ceremonies','events.php','footer_services',3,1,0),
('Culture','events.php','footer_services',4,1,0),
('Exhibitions','events.php','footer_services',5,1,0),
('Seminars','events.php','footer_services',6,1,0),
('Picnics & Tours','educational-trips.php','footer_services',7,1,0),
('Production','events.php','footer_services',8,1,0),
('Schools','schools.php','footer_for',1,1,0),
('Colleges','colleges.php','footer_for',2,1,0),
('Universities','colleges.php','footer_for',3,1,0),
('Institutions','contact.php','footer_for',4,1,0),
('Benefits','apex-card.php','footer_card',1,1,0),
('Apply','apex-card.php#apply','footer_card',2,1,0),
('Partner Directory','partners.php','footer_card',3,1,0),
('Become a Partner','partners.php#join','footer_card',4,1,0),
('Card Terms','apex-card.php#terms','footer_card',5,1,0);

-- Social links
INSERT INTO `social_links` (`platform`,`label`,`url`,`icon`,`sort_order`,`is_active`) VALUES
('facebook','Facebook','https://facebook.com/','facebook',1,1),
('instagram','Instagram','https://instagram.com/','instagram',2,1),
('linkedin','LinkedIn','https://linkedin.com/','linkedin',3,1),
('youtube','YouTube','https://youtube.com/','youtube',4,1),
('whatsapp','WhatsApp','https://wa.me/','whatsapp',5,1);

-- Competition categories
INSERT INTO `competition_categories` (`name`,`slug`,`description`,`sort_order`,`is_active`) VALUES
('Academic & Knowledge','academic-knowledge','Test what students know and how fast they think. General Knowledge, Science, Current Affairs, Islamiyat & Pakistan Studies, Maths & Science Olympiads, English Olympiad, Spelling Bee, Mental Maths & Abacus, Essay Writing, Creative Writing.',1,1),
('Speaking & Debate','speaking-debate','Build confident speakers and sharp thinkers. English Debate, Urdu Debate (Mubahisa), Parliamentary Debate, Declamation, Extempore, Poetry Recitation, Qirat & Naat, Storytelling, Model United Nations (MUN).',2,1),
('Science, Technology & Innovation','science-technology','Turn curiosity into projects, prototypes and ideas. Science Fair, Model Making, Robotics, Coding & Programming, Hackathon, App & Web Design, STEM Challenge, Innovation & Startup Pitch.',3,1),
('Sports & Games','sports-games','Teamwork, discipline and fair play on the field. Cricket, Football & Futsal, Hockey, Basketball, Volleyball, Badminton, Table Tennis, Athletics, Tug of War, Chess, E-sports.',4,1),
('Arts & Creativity','arts-creativity','A canvas for every kind of talent. Drawing & Painting, Calligraphy, Poster Making, Handwriting, Photography, Craft & Clay Modelling, Short Film.',5,1),
('Performing Arts & Culture','performing-arts','Give students the spotlight they deserve. Talent Hunt, Singing, Instrumental Music, Drama & Theatre, Tableau, Skits & Comedy, Cultural Dress Show.',6,1),
('Junior & Early Years','junior','Gentle, joyful first competitions for young learners. Show & Tell, Rhyme Recitation, Colouring, Fancy Dress, Junior Spelling Bee, Storytelling.',7,1),
('Life Skills & Leadership','life-skills','Real-world skills, learned by doing. Business Plan & Entrepreneurship, Bake Sale Challenge, No-Flame Cooking, Green & Environment Challenge, Leadership Challenge, Treasure Hunt.',8,1),
('Corporate Competitions','corporate','Healthy rivalry that builds stronger teams. Corporate Cricket & Futsal Leagues, Corporate Quiz Nights, Innovation & Pitch Challenges, Team-Building Challenges, Family Day Games, Corporate E-sports.',9,1);

-- Event categories
INSERT INTO `event_categories` (`name`,`slug`,`description`,`sort_order`,`is_active`) VALUES
('Academic Competitions','academic','Quiz, debate, spelling bee, MUN, science fairs, robotics, coding.',1,1),
('Sports Tournaments & Days','sports','Sports galas, inter-school and inter-college tournaments.',2,1),
('Annual Days & Convocations','ceremonies','Annual days, prize distributions, graduations, convocations.',3,1),
('Cultural Festivals & Talent Shows','culture','Cultural weeks, talent hunts, drama, music, art competitions.',4,1),
('Exhibitions & Education Expos','exhibitions','Science and art exhibitions, career fairs, open days, education expos.',5,1),
('Seminars, Orientations & Workshops','seminars','Orientation weeks, parent sessions, teacher training, education conferences.',6,1),
('Educational Trips','trips','Supervised school picnics, field trips and study tours.',7,1),
('Event Planning & Production','production','Concept, stage, sound, lighting, branding, trophies and on-the-day management.',8,1);

-- Event services (Events page content from PDF)
INSERT INTO `events` (`name`,`slug`,`category_id`,`headline`,`description`,`deliverables`,`ideal_for`,`sort_order`,`is_active`) VALUES
('APEX Minds — Academic Competitions','apex-minds',1,'Academic Competitions','Competitions of the mind demand absolute fairness. We design formats, question banks and judging systems that students trust and audiences enjoy.','Inter-school and inter-college quiz competitions|Debates, declamations and public-speaking contests|Spelling bees, maths and science olympiads|Model United Nations (MUN) conferences|Science fairs, robotics, coding contests and hackathons|Essay, creative writing, Qirat & Naat and poetry recitation|Secure question papers, adjudicator briefing and certified results','schools, colleges, universities, student societies and education boards.',1,1),
('APEX Sports — Sports Tournaments & Sports Days','apex-sports',2,'Sports Tournaments & Sports Days','Great tournaments are won on the field and organised off it. We handle everything that keeps play safe, fair and on schedule.','Annual sports days and sports galas|Inter-school, inter-college and inter-university tournaments|Fixtures, draws, team registration and age verification|Qualified referees, umpires and officials|Venue, equipment, first aid and medical cover|Opening ceremonies, march-pasts, finals and medal presentations','schools, colleges, universities, school networks and sports departments.',2,1),
('APEX Ceremonies — Annual Days, Convocations & Ceremonies','apex-ceremonies',3,'Annual Days, Convocations & Ceremonies','Some days define an institution''s year. We help you deliver them with dignity, organisation and pride.','Annual days and parents'' days|Prize distributions and result ceremonies|Graduation ceremonies and convocations|Founder''s days, anniversaries and inaugurations|Chief guest, protocol and VIP management|Gowns, stage, seating plans and rehearsals','schools, colleges, universities and institutional head offices.',3,1),
('APEX Culture — Cultural Festivals & Talent Shows','apex-culture',4,'Cultural Festivals & Talent Shows','Music, drama, art and tradition give students another way to shine. We produce cultural events full of colour, energy and safety.','Cultural weeks and heritage festivals|Talent hunts and inter-school cultural competitions|Drama, music, dance and art competitions|Food stalls, family fun fairs and carnivals|Performer and guest artist management|Crowd management, security and permissions','schools, colleges, universities, student councils and societies.',4,1),
('APEX Expo — Exhibitions & Education Expos','apex-expo',5,'Exhibitions & Education Expos','Showcase student work and open your doors to the community with exhibitions people remember.','Science, art and project exhibitions|Career fairs and university admission expos|Open days and admission campaigns|Stall layout, booth design and exhibitor management|Judging panels and awards for best projects|Signage, printing and visitor flow','schools, colleges, universities, education networks and admission offices.',5,1),
('APEX Forum — Seminars, Orientations & Workshops','apex-forum',6,'Seminars, Orientations & Workshops','Learning events need to run as smoothly as any classroom. We organise sessions that inform, inspire and stay on time.','Orientation weeks and welcome events|Parent-teacher sessions and awareness seminars|Teacher training and professional development workshops|Education conferences and leadership summits|Speaker coordination, registration and certificates|Venue, audio-visual and live streaming','schools, colleges, universities, education boards, academies and NGOs.',6,1),
('APEX Tours — Educational Trips','apex-tours',7,'Educational Trips','Supervised picnics, field trips and study tours for schools and colleges, planned with the same care for safety as our events.','School picnics and one-day outings|Educational field trips to museums and science centres|Multi-day study tours and camps|College recreational trips and departmental tours|Female staff for girls'' groups, first aid and headcounts|Parent consent, itineraries and regular updates','schools, colleges, student societies and departments.',7,1),
('APEX Production — Event Planning, Production & Management','apex-production',8,'Event Planning, Production & Management','Need the full package, or expert hands on one part? Our production team covers every stage of the event.','Concept, theme and creative direction|Budgeting, scheduling and vendor management|Venue sourcing and campus site planning|Stage, sound, lighting, LED screens and live streaming|Branding, banners, certificates, trophies and medals|Participant registration and invitations|Photography, videography and highlight reels|On-the-day management and post-event reporting','any institution that wants a single, accountable team managing the whole event.',8,1);

-- Example upcoming competitions (clearly marked as unconfirmed placeholders)
INSERT INTO `competitions` (`name`,`slug`,`category_id`,`description`,`eligibility`,`level`,`team_size`,`event_date`,`registration_deadline`,`venue`,`city`,`entry_fee`,`prizes`,`registration_status`,`is_featured`) VALUES
('APEX Quiz Championship 2026','apex-quiz-championship-2026',1,'Inter-school and inter-college general knowledge and science quiz, with qualifying rounds and a live stage final.','Schools, colleges and universities','Senior','2 students per team','2026-12-15','2026-12-01','[Venue, City]','[City]','[PKR ___]','Trophies, medals, certificates, scholarships','open',1),
('APEX Debate Cup — Parliamentary Format','apex-debate-cup-2026',2,'English and Urdu debating championship with parliamentary and classic formats and expert adjudicators.','Secondary and higher secondary','Senior','3 students per team','2026-12-20','2026-12-10','[Venue, City]','[City]','[PKR ___]','Trophies, medals, certificates','open',1),
('APEX Science & Robotics Challenge','apex-science-robotics-2026',3,'Science projects, robotics and coding categories judged by subject experts.','Grades 6–12','Middle, Senior','2–4 students per team','2027-01-18','2027-01-04','[Venue, City]','[City]','[PKR ___]','Trophies, medals, certificates','open',1),
('APEX Inter-School Football League','apex-football-league-2026',4,'Inter-school football and futsal league with fixtures, standings and finals.','Schools and colleges','Senior','Squad of 15','2027-02-10','2027-01-25','[Venue, City]','[City]','[PKR ___]','Trophies, medals, certificates','coming_soon',0),
('APEX Spelling Bee','apex-spelling-bee-2026',1,'Junior and senior spelling bee, building from school rounds to a grand final.','Grades 3–10','Junior, Middle','Individual','2027-02-24','2027-02-10','[Venue, City]','[City]','[PKR ___]','Trophies, medals, certificates','coming_soon',0),
('APEX Talent Hunt','apex-talent-hunt-2026',6,'Singing, poetry recitation, Qirat & Naat, drama and art, with a showcase final for the winners.','Schools and colleges','All levels','Individual','2027-03-15','2027-03-01','[Venue, City]','[City]','[PKR ___]','Trophies, medals, certificates','coming_soon',0);

-- Example portfolio items (clearly marked as unconfirmed placeholders per PDF rules)
INSERT INTO `portfolio_items` (`name`,`slug`,`category`,`institution`,`city`,`event_date`,`summary`,`brief`,`what_we_did`,`result_text`,`participants_count`,`teams_count`,`cover_image`,`is_featured`,`is_published`) VALUES
('[Inter-School Quiz Competition]','sample-quiz-2026','Academic & Quiz','[Institution Name]','[City]','2026-10-15','One or two sentences on what the event was, what APEX delivered, and what made it special. — replace with real event summary from your records.','[One or two sentences on what the institution needed.]','[Services — e.g. format and rules, judges, venue, stage and sound, registrations, trophies and certificates.]','[Real outcomes — participating institutions, students, attendance, feedback.]',120,24,NULL,1,1),
('[Annual Sports Gala]','sample-sports-gala','Sports','[Institution Name]','[City]','2026-09-20','One or two sentences on what the event was, what APEX delivered, and what made it special. — replace with real event summary from your records.','[One or two sentences.]','[Services provided.]','[Results and feedback.]',600,32,NULL,1,1),
('[Convocation Ceremony]','sample-convocation','Ceremonies','[Institution Name]','[City]','2026-08-28','One or two sentences on what the event was, what APEX delivered, and what made it special. — replace with real event summary from your records.','[One or two sentences.]','[Services provided.]','[Results and feedback.]',250,NULL,NULL,0,1);

-- Partner categories
INSERT INTO `partner_categories` (`slug`,`name`,`description`,`sort_order`) VALUES
('institution','Partner Institutions','Schools, colleges and universities that host and take part in APEX competitions.',1),
('sponsor','Sponsors','Organisations that sponsor APEX championships, awards and scholarships.',2),
('card','APEX Card Partners','Academies, stores and services offering discounts to APEX Card holders.',3),
('media','Media Partners','Newspapers, channels and pages that cover and promote APEX events.',4),
('service','Venue & Production Partners','Venues, sound and stage, printing, trophies, catering and transport partners.',5),
('expert','Knowledge & Judging Partners','Organisations and experts who set questions and judge APEX competitions.',6);

-- Sample placeholder partners (clearly marked; per PDF: do NOT display fabricated genuine partnerships)
INSERT INTO `partners` (`name`,`category_id`,`city`,`description`,`website`,`discount`,`since_year`,`is_card_partner`,`is_active`,`sort_order`) VALUES
('[Partner School Name]',1,'[City]','[One line on how this institution works with APEX.]','',NULL,'[Year]',0,1,1),
('[Partner University Name]',1,'[City]','[One line on how this institution works with APEX.]','',NULL,'[Year]',0,1,2),
('[Sponsor Name]',2,'[City]','[Title sponsor of the APEX Quiz Championship.]','',NULL,'[Year]',0,1,3),
('[Academy Name]',3,'[City]','[What the academy offers.]','','[X]% off tuition fees',NULL,1,1,4),
('[Bookstore Name]',3,'[City]','[What the store offers.]','','[X]% off books & stationery',NULL,1,1,5),
('[Media Partner Name]',4,'[City]','[Official media partner for the APEX Debate Cup.]','',NULL,'[Year]',0,1,6),
('[Sound & Stage Company]',5,'[City]','[Stage, sound and lighting partner.]','',NULL,'[Year]',0,1,7),
('[Judging Partner Name]',6,'[City]','[Question-setting and adjudication partner for APEX quiz events.]','',NULL,'[Year]',0,1,8);

-- Sponsorship tiers
INSERT INTO `sponsorship_tiers` (`name`,`tagline`,`price`,`benefits`,`is_featured`,`sort_order`,`is_active`) VALUES
('Title Sponsor','Headline recognition across the championship','[PKR ___]','Championship named after sponsor|Logo lock-up on all branding, stage, certificates|Prime stage time at opening and finals|Dedicated media release and social campaign|VIP seating and chief guest slot|Access to winner data and participating institutions (where consented)',1,1,1),
('Gold Sponsor','Strong presence on stage and off','[PKR ___]','Logo on main backdrop, banners and certificates|Branded prize category at the finals|Speaking slot at opening ceremony|Social media features and press mentions|VIP invitations to the finals',0,2,1),
('Silver Sponsor','A visible, respected partner','[PKR ___]','Logo on event banners and backdrop|Shared stage branding|Social media mentions|Invitations to the finals',0,3,1),
('Category Sponsor','Own one competition category','[PKR ___]','Logo and category naming for your competition|Branding at all rounds in that category|Winner certificates in your name|Social media feature',0,4,1),
('In-Kind Partner','Contribute a product or service','Negotiable','Recognition appropriate to contribution|Logo visibility proportional to the deliverable|Social media thank-you',0,5,1);

-- APEX Card types
INSERT INTO `apex_card_types` (`name`,`tagline`,`price`,`description`,`benefits`,`sort_order`,`is_active`) VALUES
('Student Card','For one student, from junior school to university','[PKR ___ / year]','Includes all cardholder benefits and a digital card.','Up to [X]% off APEX competition registration|Discounts at partner academies and tuition centres|Savings on books, stationery, uniforms|Reduced fees on online courses and workshops|Priority registration for Signature Championships|Scholarship draws and members-only rewards',1,1),
('Family Card','For up to [3] children in one family','[PKR ___ / year]','One card per child at a lower price per student.','Same benefits as Student Card for every child|Household savings on competitions, tuition and books|Family invitations to selected APEX events',2,1),
('Institution Card','Bulk cards for a whole school, college or university','[Custom price]','Bulk cards plus extra discounts on APEX events for the institution.','Bulk cardholder benefits for all students|Extra discounts on APEX events for the institution|Institutional branding opportunities|Priority slots for inter-school and championship rounds',3,1);

-- FAQs from the PDF, verbatim
INSERT INTO `faqs` (`question`,`answer`,`category`,`sort_order`,`is_active`) VALUES
('What types of events does APEX manage?','We manage academic competitions, sports tournaments and sports days, annual days, convocations and ceremonies, cultural festivals and talent shows, exhibitions and education expos, and seminars and workshops. We also arrange supervised educational trips.','General',1,1),
('Can you run the event on our own campus?','Yes. Most of our events take place on the institution''s own campus. We can also arrange an external venue such as a hall, auditorium or sports ground.','General',2,1),
('How early should we contact you?','For annual days, convocations, tournaments and inter-school competitions we recommend 6–8 weeks. Smaller events can often be arranged in 2–3 weeks. We plan around your exam schedule and academic calendar.','Planning',3,1),
('How much does it cost?','Every event is different, so we prepare a tailored, itemised proposal based on student numbers, venue, format and production needs. We offer options for school and college budgets and can help you find sponsors.','Planning',4,1),
('How do you keep students safe?','We agree a safety plan with your administration before every event: supervised areas, controlled entry, trained staff, first aid on site, emergency contacts and clear arrival and pick-up arrangements for younger students.','Safety',5,1),
('How do you make sure competitions are fair?','We publish rules in advance, use independent and briefed judges, structured score sheets and secure question papers, keep records of every round and share results transparently with all participating institutions.','Competitions',6,1),
('Do participants receive certificates?','Yes. Every participant can receive a certificate, and winners receive trophies or medals. We can also add your institution''s logo and signatures.','Competitions',7,1),
('Can our student society work with you?','Absolutely. We regularly support student societies with planning, budgets, sponsorship, vendors and on-the-day management, with faculty approval.','Planning',8,1),
('What is the APEX Card?','The APEX Card is a yearly education discount card. Cardholders save on APEX competition fees, partner academies, books, stationery, courses and workshops, and get priority registration for APEX championships. Student, Family and Institution cards are available.','APEX Card',9,1),
('How do I get an APEX Card?','Apply online on the APEX Card page. Students under 18 apply through a parent, guardian or their school. Your digital card arrives within [2] working days and the printed card within [7–10] days.','APEX Card',10,1),
('Do you also organise school trips?','Yes. Alongside competitions and events, we arrange supervised picnics, field trips and study tours. See the Educational Trips page for details.','General',11,1),
('Do you work outside our city?','Yes. We manage events in [City] and other cities. Travel and logistics are shown transparently in your proposal.','General',12,1);

-- Pages (content fallback)
INSERT INTO `pages` (`slug`,`title`,`meta_title`,`meta_description`,`is_published`) VALUES
('home','Home','APEX | School & College Event and Competition Management','Inter-school quiz, debate, science and sports competitions, plus annual days, convocations and festivals — organised and judged by APEX.',1),
('about','About Us','About APEX | Education Event Management Specialists','APEX Events & Competitions helps schools, colleges and institutions run safe, well-organised events and fair, inspiring competitions.',1),
('competitions','Competitions','Inter-School & Inter-College Competitions | APEX','Quiz, debate, olympiads, robotics, sports, arts and talent competitions for schools and colleges — fair judging, certificates and trophies.',1),
('events','Events','School & College Event Management Services | APEX','Academic competitions, sports tournaments, annual days, convocations, exhibitions, cultural festivals and full event production for educational institutions.',1),
('schools','For Schools','School Event & Competition Management | APEX','Annual days, sports days, prize distributions, quiz and spelling bee competitions and inter-school events — safe, organised and stress-free.',1),
('colleges','For Colleges & Universities','College & University Event Management | APEX','Convocations, orientation weeks, inter-university championships, debates, MUNs, hackathons and festivals managed by APEX.',1),
('apex-card','APEX Card','APEX Card | Education Discount Card for Students','Save on competition fees, tuition, books, courses and more with the APEX Card — for students, families and institutions.',1),
('educational-trips','Educational Trips','Educational Trips & Study Tours | APEX','Supervised school picnics, field trips and study tours arranged by APEX for schools and colleges.',1),
('portfolio','Portfolio','Our School & College Events | APEX Portfolio','See the competitions, ceremonies, tournaments and festivals APEX has managed for schools, colleges and universities.',1),
('faq','FAQ','FAQ | APEX Events & Competitions','Budgets, timelines, student safety, judging, certificates and registrations — answers for principals, coordinators and parents.',1),
('contact','Contact','Contact APEX | Request an Event Proposal','Tell us about your school or college event and receive a tailored proposal from the APEX team.',1),
('calendar','Calendar','APEX Calendar | Upcoming Competitions','Browse upcoming APEX competitions and championships by date, category and city.',1),
('partners','Partners','Our Partners | APEX Events & Competitions','APEX partner institutions, sponsors, APEX Card discount partners, media, venue and production partners.',1),
('sponsorship','Sponsorship','Sponsor APEX Championships | Sponsorship Opportunities','Sponsor APEX championships, cups and leagues — title, gold, silver and category sponsorship tiers for schools, colleges and universities.',1),
('links','Quick Links','APEX Links | All APEX Pages','Quick access to every APEX page — Calendar, Past Events, Partners, Sponsorship, APEX Card, Request a Proposal.',1);
