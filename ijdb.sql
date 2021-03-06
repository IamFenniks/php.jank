-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 19 2020 г., 22:44
-- Версия сервера: 8.0.15
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ijdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `author`
--

CREATE TABLE `author` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `author_email` varchar(255) DEFAULT NULL,
  `password` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `author`
--

INSERT INTO `author` (`author_id`, `author_name`, `author_email`, `password`) VALUES
(1, 'Кевин Янк', 'thatguy@kevin_yank.com', 'cf4031e33086538be631fb542512cddd'),
(2, 'Джоан Смит', 'jsmith@mail.com', 'aba0050decd05ae68b7fe09206fddadc'),
(3, 'Андрей Дарменко', 'andrej.darmenko@gmail.com', 'e6601b881e6d1a83ea0a204a8b492374');

-- --------------------------------------------------------

--
-- Структура таблицы `author_role`
--

CREATE TABLE `author_role` (
  `author_id` int(11) NOT NULL,
  `role_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `author_role`
--

INSERT INTO `author_role` (`author_id`, `role_id`) VALUES
(1, 'Администратор учётных записей'),
(2, 'Администратор сайта'),
(3, 'Администратор сайта'),
(3, 'Администратор учётных записей'),
(3, 'Редактор');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(1, 'Без категории'),
(3, 'О д`Артаньяне'),
(4, 'Через дорогу'),
(5, 'Об адвокатах'),
(6, 'Новый Год'),
(7, 'О лампочке');

-- --------------------------------------------------------

--
-- Структура таблицы `jokes`
--

CREATE TABLE `jokes` (
  `id` int(11) NOT NULL,
  `joketext` text,
  `jokedate` date NOT NULL,
  `author_id` int(11) NOT NULL,
  `visible` enum('NO','YES') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jokes`
--

INSERT INTO `jokes` (`id`, `joketext`, `jokedate`, `author_id`, `visible`) VALUES
(1, 'В Новый Год всё сбывается, даже то, что в другое время сбыть не удаётся.', '2020-03-15', 1, 'NO'),
(2, 'Хочешь петь - ПЕЙ!', '2020-03-18', 1, 'YES'),
(3, 'Если хочешь быть ЗДОРОВ, будь здоров!', '2020-05-17', 2, 'NO'),
(4, 'Шути - не шути, один хрен в конце концов, дошутишься.', '2020-05-17', 2, 'YES'),
(5, 'Зачем цыплёнок перешёл дорогу? Чтобы попасть на другую сторону.', '2020-05-17', 3, 'YES'),
(6, 'Адвокатом быть не легко. Легко бить адвоката.', '2020-05-17', 3, 'YES');

-- --------------------------------------------------------

--
-- Структура таблицы `joke_category`
--

CREATE TABLE `joke_category` (
  `joke_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `joke_category`
--

INSERT INTO `joke_category` (`joke_id`, `category_id`) VALUES
(1, 5),
(2, 1),
(3, 6),
(4, 1),
(5, 4),
(6, 4),
(6, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
('Администратор сайта', 'Добавление, удаление и редактирование катерий'),
('Администратор учётных записей', 'Добавление, удаление и редактирование авторов'),
('Редактор', 'Добавление, удаление и редактирование шуток');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`),
  ADD UNIQUE KEY `author_email` (`author_email`);

--
-- Индексы таблицы `author_role`
--
ALTER TABLE `author_role`
  ADD PRIMARY KEY (`author_id`,`role_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `jokes`
--
ALTER TABLE `jokes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `joke_category`
--
ALTER TABLE `joke_category`
  ADD PRIMARY KEY (`joke_id`,`category_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `jokes`
--
ALTER TABLE `jokes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
