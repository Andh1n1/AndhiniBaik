-- ============================================================
-- DATABASE DUMP: 2526_22db
-- Sistem Kesiswaan - SMKN 2 Baleendah
-- ============================================================
-- Cara pakai:
-- 1. Buka phpMyAdmin
-- 2. Klik tab "Import"
-- 3. Pilih file ini lalu klik "Go"
-- ATAU jalankan via terminal:
--   mysql -u 2526_22 -p 2526_22db < 2526_22db.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS `2526_22db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `2526_22db`;

-- ============================================================
-- TABEL: users
-- Menyimpan akun login (admin & guru)
-- ============================================================
DROP TABLE IF EXISTS `pengurus`;  -- hapus pengurus dulu karena ada FK ke users
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id`       INT(11)                  NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50)              NOT NULL,
  `password` VARCHAR(255)             NOT NULL,  -- disimpan sebagai MD5 hash
  `role`     ENUM('admin','guru')     NOT NULL DEFAULT 'guru',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: pengurus
-- Menyimpan biodata lengkap pengurus kesiswaan
-- Relasi: pengurus.user_id -> users.id
-- ============================================================
CREATE TABLE `pengurus` (
  `id`           INT(11)      NOT NULL AUTO_INCREMENT,
  `user_id`      INT(11)      NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `NIP`          VARCHAR(18)  NOT NULL,
  `jabatan`      VARCHAR(50)  NOT NULL,
  `bidang`       VARCHAR(50)  NOT NULL,
  `masa_jabatan` TINYINT(2)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- DATA: 1 akun admin
-- username : admin
-- password : admin12345  (MD5 = 7488e331b8b64e5794da3fa4eb10ad5d)
-- ============================================================
INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin12345', 'admin');

-- Reset AUTO_INCREMENT agar data pengurus berikutnya mulai dari id yg sesuai
ALTER TABLE `users`    AUTO_INCREMENT = 2;
ALTER TABLE `pengurus` AUTO_INCREMENT = 1;

