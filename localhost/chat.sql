-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 03 2023 г., 16:49
-- Версия сервера: 5.7.39
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cgroup`
--

CREATE TABLE `cgroup` (
  `msg_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `outgoing_chat_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `file` longblob NOT NULL,
  `file_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `file` longblob NOT NULL,
  `file_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `file`, `file_type`) VALUES
(1, 1422956794, 1414519463, '😑😑😑', '', ''),
(2, 1422956794, 1414519463, '', 0x313638353730343336375f70686f746f5f323032332d30352d33305f30302d30352d35312e6a7067, 'image/jpeg'),
(3, 1422956794, 1414519463, '', 0x313638353730343534315f7472616e736c6174696f6e20707261637469636520766f636162756c617279792d312e646f63, 'application/msword'),
(4, 1422956794, 1414519463, '', 0x313638353730343739325fd181d0bbd0bed0b2d0b0d180d18c2e646f63, 'application/msword'),
(5, 1422956794, 1414519463, '😱😱😱😱', '', ''),
(6, 1422956794, 1414519463, '', 0x313638353730383636355f53637265656e73686f745f312e706e67, 'image/png'),
(7, 1414519463, 1422956794, 'ывфыв', '', ''),
(8, 117745176, 1422956794, 'dhfgh', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `usrnm` varchar(255) NOT NULL,
  `gmail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `muted_status` varchar(255) NOT NULL,
  `mute_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `name`, `usrnm`, `gmail`, `password`, `status`, `muted_status`, `mute_time`) VALUES
(98, 1422956794, 'Dima Syhuta', 'DmSy', 'DmSy@gmail.com', 'DmSy', 'Неактивний зараз', '', 0),
(101, 1414519463, 'Kostya', 'KN', 'KN@gmail.com', 'KN', 'Неактивний зараз', 'Не заглушено', 0),
(133, 1159407827, 'Микола', 'Myk', 'Myk@gmail.com', 'Myk', 'Неактивний зараз', 'Не заглушено', 0),
(134, 465095757, 'Taras', 'Taras', 'Taras@gmail.com', 'Taras', 'Неактивний зараз', 'Не заглушено', 0),
(135, 568683503, 'Anita', 'Anita', 'Anita@gmail.com', 'Anita', 'Неактивний зараз', 'Не заглушено', 0),
(136, 1388887580, 'Aleksey', 'Aleksey', 'Aleksey@gmail.com', 'Aleksey', 'Неактивний зараз', 'Не заглушено', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cgroup`
--
ALTER TABLE `cgroup`
  ADD PRIMARY KEY (`msg_id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cgroup`
--
ALTER TABLE `cgroup`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
