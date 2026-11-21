-- =====================================================================
-- APEX — migration: switch to minimal site (TT Leagues only).
-- Run this on an already-imported database to:
--   1. Add the site_mode setting (default: minimal)
--   2. Deactivate every nav item except Home, Competition, About, Contact
--   3. Rename the "Competitions" nav label to the singular "Competition"
--   4. Deactivate all footer nav items (the minimal footer renders
--      its own four links)
--
-- Nothing is deleted — every nav row is still there with is_active=0,
-- so you can restore the full site later by running:
--     UPDATE site_settings SET setting_value='full' WHERE setting_key='site_mode';
--     UPDATE navigation_items SET is_active=1;
--
-- Import this file via phpMyAdmin → select u599227834_apex_db → Import.
-- =====================================================================

-- 1. site_mode setting
INSERT INTO `site_settings` (`setting_key`,`setting_value`,`setting_type`,`setting_group`,`label`,`sort_order`)
  SELECT 'site_mode','minimal','text','general','Site mode (minimal / full)',5
  WHERE NOT EXISTS (SELECT 1 FROM `site_settings` WHERE `setting_key`='site_mode');

-- 2. Normalise the "Competitions" label to "Competition"
UPDATE `navigation_items`
  SET `label`='Competition'
  WHERE `location`='header' AND `label`='Competitions';

-- 3. Keep only the four core header items active
UPDATE `navigation_items`
  SET `is_active`=0
  WHERE `location`='header'
    AND `label` NOT IN ('Home','Competition','About','Contact');

UPDATE `navigation_items`
  SET `is_active`=1,`is_cta`=0
  WHERE `location`='header'
    AND `label` IN ('Home','Competition','About','Contact');

-- 4. Hide all footer nav rows — the minimal footer prints its own links
UPDATE `navigation_items`
  SET `is_active`=0
  WHERE `location` IN ('footer_company','footer_services','footer_for','footer_card');
