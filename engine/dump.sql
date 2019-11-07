-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "multiselect" ----------------------------------
CREATE TABLE `multiselect` ( 
	`last_id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`from_table` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`data_table` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`value` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`row_id` Int( 11 ) NULL DEFAULT NULL,
	PRIMARY KEY ( `last_id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- -------------------------------------------------------------


-- CREATE TABLE "categorys" ------------------------------------
CREATE TABLE `categorys` ( 
	`last_id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`title` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`sort` Int( 11 ) NULL DEFAULT NULL,
	`_lng` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`action` Blob NULL DEFAULT NULL,
	`enable` Int( 11 ) NULL DEFAULT 0,
	PRIMARY KEY ( `last_id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 4;
-- -------------------------------------------------------------


-- CREATE TABLE "news" -----------------------------------------
CREATE TABLE `news` ( 
	`last_id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`category` Int( 11 ) NULL DEFAULT NULL,
	`title` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`content` Text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`sort` Int( 11 ) NULL DEFAULT NULL,
	`_lng` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`action` Blob NULL DEFAULT NULL,
	`enable` Int( 11 ) NULL DEFAULT 0,
	PRIMARY KEY ( `last_id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 5;
-- -------------------------------------------------------------


-- CREATE TABLE "elfinder_files" -------------------------------
CREATE TABLE `elfinder_files` ( 
	`id_file` Int( 255 ) AUTO_INCREMENT NOT NULL,
	`type` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`file` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`min_image` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	PRIMARY KEY ( `id_file` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- -------------------------------------------------------------


-- CREATE TABLE "__object__" -----------------------------------
CREATE TABLE `__object__` ( 
	`key` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`object` Blob NULL DEFAULT NULL,
	PRIMARY KEY ( `key` ),
	CONSTRAINT `key_UNIQUE` UNIQUE( `key` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB;
-- -------------------------------------------------------------


-- CREATE TABLE "__auth__helper" -------------------------------
CREATE TABLE `__auth__helper` ( 
	`id_auth` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`type` VarChar( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`remote_ip` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`key_access` VarChar( 400 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	`object` Blob NULL DEFAULT NULL,
	PRIMARY KEY ( `id_auth` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 22;
-- -------------------------------------------------------------


-- Dump data of "multiselect" ------------------------------
-- ---------------------------------------------------------


-- Dump data of "categorys" --------------------------------
INSERT INTO `categorys`(`last_id`,`title`,`sort`,`_lng`,`action`,`enable`) VALUES 
( '1', 'Категория1', '1', NULL, '', '1' ),
( '2', 'Категория 2', '2', NULL, '', '1' ),
( '3', 'Категория 3', '3', NULL, '', '1' );
-- ---------------------------------------------------------


-- Dump data of "news" -------------------------------------
INSERT INTO `news`(`last_id`,`category`,`title`,`content`,`sort`,`_lng`,`action`,`enable`) VALUES 
( '1', '2', 'Новость 1', '    фывфывв', '1', NULL, '', '1' ),
( '2', '1', 'Новость 2', '    фвфывфывфыв', '2', NULL, '', '1' ),
( '3', NULL, 'Новость 3', 'ываывавыа', '3', NULL, '', '1' ),
( '4', NULL, 'Новость 4', 'фывфывыв', '4', NULL, '', '1' );
-- ---------------------------------------------------------


-- Dump data of "elfinder_files" ---------------------------
-- ---------------------------------------------------------


-- Dump data of "__object__" -------------------------------
INSERT INTO `__object__`(`key`,`object`) VALUES 
( 'adminmenu_config', 0x5B5B7B226E6176223A22222C226F6E6C79726F6F74223A66616C73652C227469746C65223A22647366736466736466222C2268726566223A22323133313233222C2269636F6E223A22313233323133222C227375625F6C696E6B73223A5B7B226E6176223A22323334333234222C226F6E6C79726F6F74223A66616C73652C227469746C65223A22313232313233313233222C2268726566223A22313233323133222C2269636F6E223A22323334323334227D5D7D5D5D ),
( 'admins', 0x5B7B226C6F67696E223A2274657374222C2273616C74223A22614F6C6F3262434D222C2270617373776F7264223A223731386164313263643035303030616366646138316536373633653065393339313932346635376166653732373962326337306130343932623866303138353164313161306161643761346337353131616130373461343230323835363731313766376635316432363561313663663639393334383062636530333539356138222C22616363657373223A5B22666F726D735F32225D7D5D ),
( 'admin_access', 0x5B5D ),
( 'cache_config', 0x5B7B22737461747573223A317D5D ),
( 'phpmailer_config', 0x5B7B2274797065223A2273656E646D61696C222C2272756E5F74797065223A227374616E64617274222C22686F7374223A226C6F63616C686F7374222C22706F7274223A3132333231332C22656D61696C223A22617364617364406173646173642E636F6D222C2270617373776F7264223A22617364617364736164222C22656E6372797074696F6E223A226E6F6E65227D5D );
-- ---------------------------------------------------------


-- Dump data of "__auth__helper" ---------------------------
INSERT INTO `__auth__helper`(`id_auth`,`type`,`remote_ip`,`key_access`,`object`) VALUES 
( '21', 'backend', '::1', '4Yur61G6VECm93v6_Kbwioi84h-sIY4M', 0x7B2261646D696E5F69735F726F6F74223A747275652C2261646D696E5F69735F6C6F67696E223A747275652C2261646D696E5F6C6F67696E223A2261646D696E222C2261646D696E5F70617373776F7264223A2261646D696E227D );
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


