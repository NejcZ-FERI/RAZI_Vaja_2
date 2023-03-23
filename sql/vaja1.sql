SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `vaja1`
--
DROP DATABASE IF EXISTS `vaja1`;
CREATE DATABASE IF NOT EXISTS `vaja1` DEFAULT CHARACTER SET utf8 COLLATE UTF8_SLOVENIAN_CI;
USE `vaja1`;

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
     `id` INT(11) NOT NULL AUTO_INCREMENT,
     `username` TEXT COLLATE utf8_slovenian_ci NOT NULL,
     `password` TEXT COLLATE utf8_slovenian_ci NOT NULL,
     `email` TEXT COLLATE utf8_slovenian_ci NOT NULL,
     `name` TEXT COLLATE utf8_slovenian_ci NOT NULL,
     `surname` TEXT COLLATE utf8_slovenian_ci NOT NULL,
     `address` TEXT COLLATE utf8_slovenian_ci,
     `zipcode` TEXT COLLATE utf8_slovenian_ci,
     `phone_number` TEXT COLLATE utf8_slovenian_ci,
     PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `categorys`
--
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` TEXT COLLATE utf8_slovenian_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

INSERT INTO categories (title)
VALUES ('Hrana'), ('Dom'), ('Avto-moto'), ('Telefonija'), ('Šport'), ('Za otroke');

-- --------------------------------------------------------

--
-- Struktura tabele `ads`
--
DROP TABLE IF EXISTS `ads`;
CREATE TABLE IF NOT EXISTS `ads` (
     `id` INT(11) NOT NULL AUTO_INCREMENT,
     `title` TEXT COLLATE utf8_slovenian_ci NOT NULL,
     `description` TEXT COLLATE utf8_slovenian_ci NOT NULL,
     `views` INT(11) NOT NULL,
     `user_id` INT(11) NOT NULL,
     `published` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `ads_category`
--
DROP TABLE IF EXISTS `ads_categories`;
CREATE TABLE IF NOT EXISTS `ads_categories` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `ad_id` INT(11) NOT NULL,
    `category_id` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
COMMIT;


-- --------------------------------------------------------

--
-- Struktura tabele `images`
--
DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `ad_id` INT(11) NOT NULL,
    `image` LONGBLOB NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;