-- =========================================================
-- Haromi Energy - Admin modules provisioning patch
-- Safe to run multiple times. Brings the database in line
-- with the Partners (dealers), Finance Help (finance) and
-- Investors (investor) admin modules.
-- =========================================================

-- ---------------------------------------------------------
-- 1) Investor applications table (created if missing)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `su_investor_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `investor_type` enum('individual','company') NOT NULL DEFAULT 'individual',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `areas_of_interest` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('submitted','reviewing','approved','rejected') NOT NULL DEFAULT 'submitted',
  `assigned_to` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_investor_status` (`status`),
  KEY `idx_investor_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ---------------------------------------------------------
-- 2) Finance application columns (added if missing)
--    Uses a stored procedure so re-running is safe.
-- ---------------------------------------------------------
DROP PROCEDURE IF EXISTS `haromi_add_finance_columns`;
DELIMITER //
CREATE PROCEDURE `haromi_add_finance_columns`()
BEGIN
  IF NOT EXISTS (SELECT 1 FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'su_finance_applications' AND COLUMN_NAME = 'borrowed_amount') THEN
    ALTER TABLE `su_finance_applications` ADD COLUMN `borrowed_amount` decimal(12,2) DEFAULT NULL AFTER `monthly_income`;
  END IF;
  IF NOT EXISTS (SELECT 1 FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'su_finance_applications' AND COLUMN_NAME = 'id_document_path') THEN
    ALTER TABLE `su_finance_applications` ADD COLUMN `id_document_path` varchar(255) DEFAULT NULL AFTER `borrowed_amount`;
  END IF;
  IF NOT EXISTS (SELECT 1 FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'su_finance_applications' AND COLUMN_NAME = 'kra_pin_document_path') THEN
    ALTER TABLE `su_finance_applications` ADD COLUMN `kra_pin_document_path` varchar(255) DEFAULT NULL AFTER `id_document_path`;
  END IF;
  IF NOT EXISTS (SELECT 1 FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'su_finance_applications' AND COLUMN_NAME = 'consent_data_usage') THEN
    ALTER TABLE `su_finance_applications` ADD COLUMN `consent_data_usage` tinyint(1) NOT NULL DEFAULT 0 AFTER `kra_pin_document_path`;
  END IF;
  IF NOT EXISTS (SELECT 1 FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'su_finance_applications' AND COLUMN_NAME = 'agreed_terms') THEN
    ALTER TABLE `su_finance_applications` ADD COLUMN `agreed_terms` tinyint(1) NOT NULL DEFAULT 0 AFTER `consent_data_usage`;
  END IF;
END //
DELIMITER ;
CALL `haromi_add_finance_columns`();
DROP PROCEDURE IF EXISTS `haromi_add_finance_columns`;

-- ---------------------------------------------------------
-- 3) Permission for managing investor applications
--    Inserted only if the slug does not already exist.
-- ---------------------------------------------------------
INSERT INTO `su_permissions` (`name`, `slug`, `description`, `created_at`, `updated_at`)
SELECT 'View Investor Applications', 'view_investor_applications', 'Can view and manage investor applications', current_timestamp(), current_timestamp()
WHERE NOT EXISTS (SELECT 1 FROM `su_permissions` WHERE `slug` = 'view_investor_applications');

-- ---------------------------------------------------------
-- 4) Grant the new permission to all roles that already hold
--    the finance applications permission (typical admins).
--    Adjust to your needs if you use a different scheme.
-- ---------------------------------------------------------
INSERT INTO `su_role_permissions` (`role_id`, `permission_id`)
SELECT pr.`role_id`, (SELECT id FROM `su_permissions` WHERE slug = 'view_investor_applications' LIMIT 1)
FROM `su_role_permissions` pr
JOIN `su_permissions` p ON p.id = pr.`permission_id`
WHERE p.slug = 'view_finance_applications'
  AND NOT EXISTS (
    SELECT 1 FROM `su_role_permissions` x
    WHERE x.role_id = pr.role_id
      AND x.permission_id = (SELECT id FROM `su_permissions` WHERE slug = 'view_investor_applications' LIMIT 1)
  );
