-- =====================================================================
-- APEX — migration to the November 2026 TT Leagues content update.
-- Safe to run on an already-live database — only updates placeholder
-- phone numbers. Does not touch admin accounts, submissions or other
-- settings you may have edited.
-- =====================================================================

-- Contact numbers from the new league poster
UPDATE `site_settings`
  SET `setting_value` = '0320 2051914'
  WHERE `setting_key` = 'contact_phone'
    AND (`setting_value` IS NULL OR `setting_value` = '' OR `setting_value` LIKE '%XXXXXX%' OR `setting_value` LIKE '%XXXXXXX%' OR `setting_value` = '+92 XXX XXXXXXX');

UPDATE `site_settings`
  SET `setting_value` = '0325 2804916'
  WHERE `setting_key` = 'contact_whatsapp'
    AND (`setting_value` IS NULL OR `setting_value` = '' OR `setting_value` LIKE '%XXXXXX%' OR `setting_value` LIKE '%XXXXXXX%' OR `setting_value` = '+92 XXX XXXXXXX');

-- Keep site_mode on 'minimal' (no-op if already set)
INSERT INTO `site_settings` (`setting_key`,`setting_value`,`setting_type`,`setting_group`,`label`,`sort_order`)
  SELECT 'site_mode','minimal','text','general','Site mode (minimal / full)',5
  WHERE NOT EXISTS (SELECT 1 FROM `site_settings` WHERE `setting_key`='site_mode');
