-- SQL Dump 
-- my_version: 0.1
-- 
-- База данных: `ijdb`
-- 
-- ------------------------
-- ------------------------
-- SQL Dump 
-- my_version: 0.1
-- 
-- База данных: `ijdb`
-- 
-- ------------------------
-- ------------------------

--
-- Структура таблицы: author
--
            DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(255) DEFAULT NULL,
  `author_email` varchar(255) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`author_id`),
  UNIQUE KEY `author_email` (`author_email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dump DB - table: author
--
            
INSERT INTO `author` VALUES("1","Кевин Янк","thatguy@kevin_yank.com","cf4031e33086538be631fb542512cddd") ,("2","Джоан Смит","jsmith@mail.com","aba0050decd05ae68b7fe09206fddadc") ,("3","Андрей Дарменко","andrej.darmenko@gmail.com","e6601b881e6d1a83ea0a204a8b492374") ;
("1","Кевин Янк","thatguy@kevin_yank.com","cf4031e33086538be631fb542512cddd") ,("2","Джоан Смит","jsmith@mail.com","aba0050decd05ae68b7fe09206fddadc") ,("3","Андрей Дарменко","andrej.darmenko@gmail.com","e6601b881e6d1a83ea0a204a8b492374") ;

--
-- Структура таблицы: author_role
--
            DROP TABLE IF EXISTS `author_role`;
CREATE TABLE `author_role` (
  `author_id` int(11) NOT NULL,
  `role_id` varchar(255) NOT NULL,
  PRIMARY KEY (`author_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump DB - table: author_role
--
            
INSERT INTO `author_role` VALUES("1","Администратор учётных записей") ,("2","Администратор сайта") ,("3","Администратор сайта") ,("3","Администратор учётных записей") ,("3","Редактор") ;
("1","Администратор учётных записей") ,("2","Администратор сайта") ,("3","Администратор сайта") ,("3","Администратор учётных записей") ,("3","Редактор") ;

--
-- Структура таблицы: category
--
            DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dump DB - table: category
--
            
INSERT INTO `category` VALUES("1","Без категории") ,("3","О д`Артаньяне") ,("4","Через дорогу") ,("5","Об адвокатах") ,("6","Новый Год") ,("7","О лампочке") ;
("1","Без категории") ,("3","О д`Артаньяне") ,("4","Через дорогу") ,("5","Об адвокатах") ,("6","Новый Год") ,("7","О лампочке") ;

--
-- Структура таблицы: joke_category
--
            DROP TABLE IF EXISTS `joke_category`;
CREATE TABLE `joke_category` (
  `joke_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`joke_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump DB - table: joke_category
--
            
INSERT INTO `joke_category` VALUES("1","5") ,("2","1") ,("3","6") ,("4","1") ,("5","4") ,("6","4") ,("6","5") ;
("1","5") ,("2","1") ,("3","6") ,("4","1") ,("5","4") ,("6","4") ,("6","5") ;

--
-- Структура таблицы: jokes
--
            DROP TABLE IF EXISTS `jokes`;
CREATE TABLE `jokes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joketext` text,
  `jokedate` date NOT NULL,
  `author_id` int(11) NOT NULL,
  `visible` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dump DB - table: jokes
--
            
INSERT INTO `jokes` VALUES("1","В Новый Год всё сбывается, даже то, что в другое время сбыть не удаётся.","2020-03-15","1","NO") ,("2","Хочешь петь - ПЕЙ!","2020-03-18","1","YES") ,("3","Если хочешь быть ЗДОРОВ, будь здоров!","2020-05-17","2","NO") ,("4","Шути - не шути, один хрен в конце концов, дошутишься.","2020-05-17","2","YES") ,("5","Зачем цыплёнок перешёл дорогу? Чтобы попасть на другую сторону.","2020-05-17","3","YES") ,("6","Адвокатом быть не легко. Легко бить адвоката.","2020-05-17","3","YES") ;
("1","В Новый Год всё сбывается, даже то, что в другое время сбыть не удаётся.","2020-03-15","1","NO") ,("2","Хочешь петь - ПЕЙ!","2020-03-18","1","YES") ,("3","Если хочешь быть ЗДОРОВ, будь здоров!","2020-05-17","2","NO") ,("4","Шути - не шути, один хрен в конце концов, дошутишься.","2020-05-17","2","YES") ,("5","Зачем цыплёнок перешёл дорогу? Чтобы попасть на другую сторону.","2020-05-17","3","YES") ,("6","Адвокатом быть не легко. Легко бить адвоката.","2020-05-17","3","YES") ;

--
-- Структура таблицы: role
--
            DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump DB - table: role
--
            
INSERT INTO `role` VALUES("Администратор сайта","Добавление, удаление и редактирование катерий") ,("Администратор учётных записей","Добавление, удаление и редактирование авторов") ,("Редактор","Добавление, удаление и редактирование шуток") ;
