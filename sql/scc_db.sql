



-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'users'
-- 
-- ---

DROP TABLE IF EXISTS `users`;
		
CREATE TABLE `users` (
  `id` INTEGER AUTO_INCREMENT DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(100) DEFAULT NULL,
  `twitter` VARCHAR(20) DEFAULT NULL,
  `title` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'helpers'
-- 
-- ---

DROP TABLE IF EXISTS `helpers`;
		
CREATE TABLE `helpers` (
  `id` INTEGER AUTO_INCREMENT DEFAULT NULL,
  `carer_id` INTEGER DEFAULT NULL,
  `helper_id` INTEGER DEFAULT NULL,
  `requested_by_id` INTEGER DEFAULT NULL,
  `status` INTEGER DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'help_msg'
-- 
-- ---

DROP TABLE IF EXISTS `help_msg`;
		
CREATE TABLE `help_msg` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `when` DATETIME NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `is_open` INTEGER NULL DEFAULT NULL,
  `sent_at` TIMESTAMP NULL DEFAULT NULL,
  `body` MEDIUMTEXT NULL DEFAULT NULL,
  `helper_group_id` INTEGER NULL DEFAULT NULL,
  `assinged_to_helper_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'help_type'
-- 
-- ---

DROP TABLE IF EXISTS `help_type`;

CREATE TABLE `help_type` (
  `id` INTEGER AUTO_INCREMENT DEFAULT NULL,
  `carer_id` INTEGER DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'preferences'
-- 
-- ---

DROP TABLE IF EXISTS `preferences`;
		
CREATE TABLE `preferences` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `user_id` INTEGER NULL DEFAULT NULL,
  `is_active` INTEGER NULL DEFAULT NULL,
  `use_email` INTEGER NULL DEFAULT NULL,
  `day` INTEGER NULL DEFAULT NULL,
  `use_txt` INTEGER NULL DEFAULT NULL,
  `use_twitter` INTEGER NULL DEFAULT NULL,
  `start_time` TIME NULL DEFAULT NULL,
  `end_time` TIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'helper_groups'
-- 
-- ---

DROP TABLE IF EXISTS `helper_groups`;
		
CREATE TABLE `helper_groups` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `user_id` INTEGER NULL DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'logins'
-- 
-- ---

DROP TABLE IF EXISTS `logins`;
		
CREATE TABLE `logins` (
  `user_id` INTEGER NULL DEFAULT NULL,
  `username` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `salt` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
);

-- ---
-- Table 'helper_in_group'
-- 
-- ---

DROP TABLE IF EXISTS `helper_in_group`;
		
CREATE TABLE `helper_in_group` (
  `helper_group_id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `helper_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`helper_group_id`)
);

-- ---
-- Table 'help_msg_type'
-- 
-- ---

DROP TABLE IF EXISTS `help_msg_type`;
		
CREATE TABLE `help_msg_type` (
  `help_msg_id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `help_type_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`help_msg_id`)
);

-- ---
-- Table 'pref_help_type'
-- 
-- ---

DROP TABLE IF EXISTS `pref_help_type`;
		
CREATE TABLE `pref_help_type` (
  `pref_id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `help_type_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`pref_id`)
);

-- ---
-- Foreign Keys 
-- ---


-- ---
-- Table Properties
-- ---

ALTER TABLE `users` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `helpers` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `help_msg` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `help_type` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `preferences` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `helper_groups` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `logins` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `helper_in_group` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `help_msg_type` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `pref_help_type` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


