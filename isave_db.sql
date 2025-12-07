-- SQL for isave_db
CREATE DATABASE IF NOT EXISTS `isave_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `isave_db`;

CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `fullname` VARCHAR(255) DEFAULT NULL,
  `role` ENUM('user','admin','tech') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `repair_requests` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `asset_number` VARCHAR(100) NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `room` VARCHAR(100) DEFAULT NULL,
  `problem` TEXT,
  `warranty` ENUM('yes','no') NOT NULL DEFAULT 'no',
  `responsible_person` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('pending','approved','rejected','assigned','in_progress','completed') NOT NULL DEFAULT 'pending',
  `approved_by` INT UNSIGNED DEFAULT NULL,
  `approved_at` DATETIME DEFAULT NULL,
  `assigned_to` INT UNSIGNED DEFAULT NULL,
  `assigned_at` DATETIME DEFAULT NULL,
  `tech_signature` VARCHAR(255) DEFAULT NULL,
  `company_repaired_by` VARCHAR(255) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `audit_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `action` VARCHAR(255) NOT NULL,
  `metadata` JSON DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
