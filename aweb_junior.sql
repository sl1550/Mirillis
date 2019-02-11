-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Хост: aweb.mysql.ukraine.com.ua
-- Время создания: Июн 24 2018 г., 18:35
-- Версия сервера: 5.7.16-10-log
-- Версия PHP: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `aweb_junior`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `about` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `tel` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `vk` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fb` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `inst` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `about`, `tel`, `address`, `vk`, `fb`, `inst`, `img`) VALUES
(18, 'tester', 'tester@mail.ru', '$2y$10$nt054yIPxnSchctWqeBZa.tLkGMaZA7Qy/nSl3uzNOATgCfXIQURu', 'Меня зовут Сергей Левченко! Я учусь программированию на PHP, и это мой личный кабинет!', '', '', '', '', '', '/img/avatars/tester.jpg'),
(19, 'tester1', 'tester1@mail.ru', '$2y$10$e87k4mmVKM7zP2YhBpVwKeq9sKZvk5Nr1yW5fWCt0s/0xFEQgKiHK', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'tester2', 'tester2@mail.ru', '$2y$10$0XkCcMQuv89r4jwYHXTfQ.k2lu9FDK0aV5/261EgEHqI0RiR/beDK', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'tester3', 'tester3@mail.ru', '$2y$10$z0BjTpwro2.UNShG/b6wwO9iCd4UiYJRPO9Q0fVCxqEQydDcBCCQ2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'tester4', 'tester4@mail.ru', '$2y$10$hpXkLui3bSriN8NzH0G91.3zWgs0Z/6YJy1xvdscXmssczNIBkQjG', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'tester5', 'tester5@mail.ru', '$2y$10$xCWR5cIAwxN.cOVpwr07pea2mYiuEwnLqU8UOG4EhtMNrbnh1CHqK', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '111111', 'alex@alex.com', '$2y$10$xNZFIPXtrmm97psxrQkMr.X6aLMcMc07wOl58u2npFhvQF7EO2.16', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'tester10', 'tester10@mail.ru', '$2y$10$WLXlIsuXuwIz.zs4M3Wb5OeFOZOkZ.DxSQjwgtZQ0lF.47XhLfFoG', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'tester11', 'tester11@mail.ru', '$2y$10$dR8JoC9TBsELBQmVt2pvKOnnH2yStwr1X96x4/V7DMBvVqGoF1yf.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'tester15', 'tester15@mail.ru', '$2y$10$ySWWMqgWCOE.CychZW7snOWrzf3iFhmPZ9m4TgUEYVaL79h3UMG6i', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'tester24', 'tester24@mail.ru', '$2y$10$hHsR0uNFtOw9mqRtDpHj3u8dvSeRdd8u6hB8EldJ68F.1iNLKugQ2', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
