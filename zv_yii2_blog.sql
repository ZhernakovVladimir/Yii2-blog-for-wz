-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 14 2016 г., 01:03
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `zv_yii2_blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1023) NOT NULL,
  `url` varchar(255) NOT NULL,
  `subscribtion` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  `published_at` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `annoncement` text NOT NULL,
  `preview` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `name`, `url`, `subscribtion`, `published`, `published_at`, `category_id`, `annoncement`, `preview`) VALUES
(1, 'a1', 'a1', 'sa1', 1, '2016-10-13', 2, 'aa1', 'pa1'),
(2, 'a2', 'a2', 'a2', 1, '2016-10-12', 1, 'a2', 'a2');

-- --------------------------------------------------------

--
-- Структура таблицы `article_tag`
--

CREATE TABLE IF NOT EXISTS `article_tag` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `article_id` (`article_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `article_tag`
--

INSERT INTO `article_tag` (`article_id`, `tag_id`) VALUES
(1, 1),
(1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `categtories`
--

CREATE TABLE IF NOT EXISTS `categtories` (
  `name` varchar(1023) NOT NULL,
  `url` varchar(255) NOT NULL,
  `subscribtion` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  `published_at` date NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `categtories`
--

INSERT INTO `categtories` (`name`, `url`, `subscribtion`, `published`, `published_at`, `id`) VALUES
('Cat1', 'cat1', 'subscat1', 1, '2016-10-11', 1),
('cat2', 'cat2', 'subcat2', 1, '2016-10-11', 2),
('cat3', 'cat3', 'subcat3', 1, '2016-10-11', 3),
('невидимка', 'invisible', 'subinv', 0, '2016-10-11', 4),
('Опубликуем в следующем году', 'next-year', 'subny', 1, '2017-01-01', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `commentators`
--

CREATE TABLE IF NOT EXISTS `commentators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `commentators`
--

INSERT INTO `commentators` (`id`, `name`, `email`) VALUES
(1, 'n1', 'n1@n1.n1'),
(2, 'SEDFSA', 'n1@n1.n1'),
(3, 'dfgdsvczxcz', 'asd@dsfs.rgt');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentator_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commentator_id` (`commentator_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `commentator_id`, `content`, `article_id`) VALUES
(1, 2, 'FSDASFASFADSFAS', 1),
(2, 3, 'gdssfsdfgaesgd', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1023) NOT NULL,
  `url` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `name`, `url`, `published`) VALUES
(1, 'tag1', 'tag1', 1),
(2, 'tag2', 'tag2', 1),
(3, 'tag3', 'tag3', 1),
(4, 'невидимка', 'invisible', 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categtories` (`id`);

--
-- Ограничения внешнего ключа таблицы `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `article_tag_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`commentator_id`) REFERENCES `commentators` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
