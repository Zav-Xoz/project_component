-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 17 2021 г., 13:20
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `verified` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `resettable` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` int UNSIGNED NOT NULL DEFAULT '0',
  `registered` int UNSIGNED NOT NULL,
  `last_login` int UNSIGNED DEFAULT NULL,
  `force_logout` mediumint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`) VALUES
(1, 'johndoe@gmail.com', '$2y$10$hz8IkEb9acTjvO2oBImCuOeQtH98ZCVZDm0YIEGurNey0bAWbl/Qy', 'John Doe', 0, 1, 1, 0, 1611122995, 1611409894, 1),
(3, 'dicaprio@gmail.com', '$2y$10$paAU3.clO1PY5Ka91A8kUeBmF1dRWk58VcuyTpRNy2o9Ztdg1vXca', 'Di', 0, 1, 1, 0, 1611123231, NULL, 1),
(25, 'Qqq@qq.qq', '$2y$10$LLYAw.2hrrqp0tvzuPBgfuIyQ/uiyH0J8yZbawSGqHjvrQn3fvq8S', 'Q', 0, 1, 1, 0, 1634465239, NULL, 0),
(26, 'supermen@ya.ru', '$2y$10$LlG0Wz1WMjD6BQcmMESDPOMWLG2cp/cSVvDiIitKDpkjqZitmVi0C', 'SuperMen', 0, 1, 1, 0, 1634465330, NULL, 0),
(24, 'Serg@ya.ru', '$2y$10$Z3RdxKybwX4x0PTFMq4j2OvR9uIhTYJTfmk12hvxSr/YtwwXKJX9O', 'Serg', 0, 1, 1, 0, 1634465158, NULL, 0),
(23, 'sky@in.is', '$2y$10$eJyavrq9sNTfE/POmR/J/O8AvKfWMlDyQrRfnVqMqdOVgx3ciqMyW', 'Sky', 0, 1, 1, 0, 1634465042, NULL, 0),
(22, 'webzavhoz@gmail.com', '$2y$10$hioVb1Ddwy8ID8kQ6ugPFOMI7jLguLxnwgOkO.f9d7JGNl6kFaMIO', 'ZavXoz', 0, 1, 1, 1, 1634462659, 1634463698, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_confirmations`
--

CREATE TABLE `users_confirmations` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_data`
--

CREATE TABLE `users_data` (
  `id` int NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `job` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'img/demo/avatars/avatar-m.png',
  `status` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'online',
  `vk` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `telegram` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `instagram` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_data`
--

INSERT INTO `users_data` (`id`, `email`, `username`, `job`, `address`, `phone`, `avatar`, `status`, `vk`, `telegram`, `instagram`) VALUES
(1, 'johndoe@gmail.com', 'John Doe', 'Administrator', 'Irkutsk, Russia', '+7 234 345 23 12', 'upload/avatars/6007c948a9439.png', 'online', NULL, NULL, NULL),
(3, 'dicaprio@gmail.com', 'Leonardo Dicaprio', 'Wolf from Wall Street', 'Leonardo Dicaprio', '+7 435 562 54 21', 'upload/avatars/6007ca1fc328a.jpg', 'afk', 'vkontakte', '3454566', 'instagram'),
(22, 'webzavhoz@gmail.com', 'ZavXoz', 'Google', 'Silicon Valley', '+2424242424', 'upload/avatars/616bec206d889.JPG', 'online', 'google.com', 'google.com', 'google.com'),
(23, 'sky@in.is', 'Sky', 'Sky', 'Israel', '+45673883', 'upload/avatars/616bf512f30f4.png', 'afk', '', '', ''),
(24, 'Serg@ya.ru', 'Serg', 'it', 'Moskow', '+5656565477', 'upload/avatars/616bf586ce27d.JPG', 'online', '', '', ''),
(25, 'Qqq@qq.qq', 'Q', 'no vork', 'Kiev', '+12345', 'upload/avatars/616bf5d750032.JPG', 'busy', '', '', ''),
(26, 'supermen@ya.ru', 'SuperMen', 'World', 'World', '+123', 'upload/avatars/616bf632d47d9.JPG', 'online', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users_remembered`
--

CREATE TABLE `users_remembered` (
  `id` bigint UNSIGNED NOT NULL,
  `user` int UNSIGNED NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_resets`
--

CREATE TABLE `users_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `user` int UNSIGNED NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_throttling`
--

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float UNSIGNED NOT NULL,
  `replenished_at` int UNSIGNED NOT NULL,
  `expires_at` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `email_expires` (`email`,`expires`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users_resets`
--
ALTER TABLE `users_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user_expires` (`user`,`expires`);

--
-- Индексы таблицы `users_throttling`
--
ALTER TABLE `users_throttling`
  ADD PRIMARY KEY (`bucket`),
  ADD KEY `expires_at` (`expires_at`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users_resets`
--
ALTER TABLE `users_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
