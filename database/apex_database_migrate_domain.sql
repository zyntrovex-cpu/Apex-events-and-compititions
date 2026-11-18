-- =====================================================================
-- APEX — migration: switch default email/URL fields to apexcompetitions.org
-- Run this ONLY if you already imported the earlier SQL (with @apex.local emails).
-- It will not change admin passwords; it only renames email defaults
-- and inserts the site_url setting if it is missing.
--
-- Import via phpMyAdmin → select u599227834_apex_db → Import → this file.
-- =====================================================================

UPDATE `admins`
  SET `email` = 'admin@apexcompetitions.org'
  WHERE `email` = 'admin@apex.local';

UPDATE `site_settings` SET `setting_value` = 'info@apexcompetitions.org'
  WHERE `setting_key` = 'contact_email'  AND `setting_value` = 'info@apex.local';
UPDATE `site_settings` SET `setting_value` = 'admin@apexcompetitions.org'
  WHERE `setting_key` = 'admin_notify_email' AND `setting_value` = 'admin@apex.local';
UPDATE `site_settings` SET `setting_value` = 'info@apexcompetitions.org'
  WHERE `setting_key` = 'smtp_from'       AND `setting_value` = 'info@apex.local';

INSERT INTO `site_settings` (`setting_key`,`setting_value`,`setting_type`,`setting_group`,`label`,`sort_order`)
  SELECT 'site_url','https://apexcompetitions.org','url','general','Website URL',4
  WHERE NOT EXISTS (SELECT 1 FROM `site_settings` WHERE `setting_key` = 'site_url');
