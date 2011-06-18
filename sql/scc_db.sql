



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
  `id` INTEGER AUTO_INCREMENT NOT NULL,
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
  `carer_id` INTEGER NOT NULL,
  `helper_id` INTEGER NOT NULL,
  `requested_by_id` INTEGER NOT NULL,
  `status` INTEGER NOT NULL DEFAULT 0,
  PRIMARY KEY (`carer_id`,`helper_id`)
);

-- ---
-- Table 'help_msg'
-- 
-- ---

DROP TABLE IF EXISTS `help_msg`;
		
CREATE TABLE `help_msg` (
  `id` INTEGER AUTO_INCREMENT NOT NULL,
  `when` DATETIME NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `carer_id` INTEGER NOT NULL,
  `is_open` INTEGER NULL DEFAULT NULL,
  `sent_at` TIMESTAMP NULL DEFAULT NULL,
  `body` MEDIUMTEXT NOT NULL,
  `helper_group_id` INTEGER NULL DEFAULT NULL,
  `assigned_to_helper_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'help_type'
-- 
-- ---

DROP TABLE IF EXISTS `help_type`;

CREATE TABLE `help_type` (
  `id` INTEGER AUTO_INCREMENT NOT NULL,
  `carer_id` INTEGER NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'preferences'
-- 
-- ---

DROP TABLE IF EXISTS `preferences`;
		
CREATE TABLE `preferences` (
  `id` INTEGER AUTO_INCREMENT NOT NULL,
  `user_id` INTEGER NOT NULL,
  `is_active` INTEGER NOT NULL DEFAULT true,
  `use_email` INTEGER NOT NULL DEFAULT true,
  `day` INTEGER NULL DEFAULT NULL,
  `use_txt` INTEGER NOT NULL DEFAULT true,
  `use_twitter` INTEGER NOT NULL DEFAULT true,
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
  `id` INTEGER AUTO_INCREMENT NOT NULL,
  `user_id` INTEGER NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'logins'
-- 
-- ---

DROP TABLE IF EXISTS `logins`;
		
CREATE TABLE `logins` (
  `user_id` INTEGER NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`)
);

-- ---
-- Table 'helper_in_group'
-- 
-- ---

DROP TABLE IF EXISTS `helper_in_group`;
		
CREATE TABLE `helper_in_group` (
  `helper_group_id` INTEGER NOT NULL,
  `helper_id` INTEGER NOT NULL,
  PRIMARY KEY (`helper_group_id`,`helper_id`)
);

-- ---
-- Table 'help_msg_type'
-- 
-- ---

DROP TABLE IF EXISTS `help_msg_type`;
		
CREATE TABLE `help_msg_type` (
  `help_msg_id` INTEGER NOT NULL,
  `help_type_id` INTEGER NOT NULL,
  PRIMARY KEY (`help_msg_id`,`help_type_id`)
);

-- ---
-- Table 'pref_help_type'
-- 
-- ---

DROP TABLE IF EXISTS `pref_help_type`;
		
CREATE TABLE `pref_help_type` (
  `pref_id` INTEGER NOT NULL ,
  `help_type_id` INTEGER NOT NULL,
  PRIMARY KEY (`pref_id`,`help_type_id`)
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


