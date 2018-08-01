-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2018 at 10:53 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mundial`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `fname` tinytext NOT NULL,
  `email` varchar(64) NOT NULL,
  `passw` varchar(32) NOT NULL,
  `org_id` tinyint(3) UNSIGNED NOT NULL,
  `city_id` tinyint(3) UNSIGNED NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `auth_key` varchar(32) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fname`, `email`, `passw`, `org_id`, `city_id`, `updated`, `auth_key`) VALUES
(1, 'Ssss Kkkk', 'mask@inbox.ru', '3d38f243bec37fa43a0d51dcd60c18c8', 1, 0, '2018-05-31 17:08:42', '4d69d76aa6e47155104bedace3e89b5a');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` tinytext NOT NULL COMMENT 'название мероприятия',
  `descr` varchar(8191) DEFAULT NULL COMMENT 'описание мероприятия',
  `org_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id организации',
  `lang_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id языка',
  `dt` datetime NOT NULL COMMENT 'дата и время мероприятия',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'статус мероприятия: -1 отменено, 0 не подтверждено, 1 подтверждено',
  `game_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id типа мероприятия',
  `city_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id города мероприятия',
  `addr` tinytext NOT NULL COMMENT 'адрес проведения',
  `map` tinytext COMMENT 'ссылка на карту места проведения',
  `price` smallint(5) UNSIGNED NOT NULL COMMENT 'стоимость',
  `count_min` smallint(5) UNSIGNED NOT NULL COMMENT 'минимальное количество билетов',
  `count_max` smallint(5) UNSIGNED NOT NULL COMMENT 'максимальное количество билетов',
  `count_free` smallint(5) UNSIGNED NOT NULL COMMENT 'количество бесплатных билетов',
  `count_paid` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество оплаченных билетов',
  `link` tinytext COMMENT 'ссылка на отчет о мероприятии',
  `upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата изменения записи',
  `admin_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id администратора, который добавил мероприятие',
  `img_ext` varchar(8) DEFAULT NULL COMMENT 'расширение файл с картинкой. если отсутствует, значит нет картинки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `descr`, `org_id`, `lang_id`, `dt`, `status`, `game_id`, `city_id`, `addr`, `map`, `price`, `count_min`, `count_max`, `count_free`, `count_paid`, `link`, `upd`, `admin_id`, `img_ext`) VALUES
(1, 'арпавпрвапрваЭ"', 'првапрвапрвапрвапрвапр', 1, 2, '2018-05-27 18:22:18', 1, 0, 1, '', NULL, 456, 12, 13, 3, 0, '', '2018-05-27 11:34:48', 0, NULL),
(5, 'sdgsdfgsd fgsdfg', 'sdfgsdgsdfgsdfg', 1, 1, '2018-05-30 23:55:00', 0, 2, 5, 'Москва, ул. Нагорная, д. 27, корп. 4', NULL, 123, 21, 123, 1, 0, '', '2018-05-27 15:35:53', 1, 'jpg'),
(6, 'sdgsdfgsd fgsdfg', '<div class="input-group mb-3">\n  <div class="input-group-prepend">\n    <span class="input-group-text">Upload</span>\n  </div>\n  <div class="custom-file">\n    <input type="file" class="custom-file-input" id="inputGroupFile01">\n    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>\n  </div>\n</div>\n\n<div class="input-group mb-3">\n  <div class="custom-file">\n    <input type="file" class="custom-file-input" id="inputGroupFile02">\n    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>\n  </div>\n  <div class="input-group-append">\n    <span class="input-group-text" id="">Upload</span>\n  </div>\n</div>\n\n<div class="input-group mb-3">\n  <div class="input-group-prepend">\n    <button class="btn btn-outline-secondary" type="button">Button</button>\n  </div>\n  <div class="custom-file">\n    <input type="file" class="custom-file-input" id="inputGroupFile03">\n    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>\n  </div>\n</div>\n\n<div class="input-group">\n  <div class="custom-file">\n    <input type="file" class="custom-file-input" id="inputGroupFile04">\n    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>\n  </div>\n  <div class="input-group-append">\n    <button class="btn btn-outline-secondary" type="button">Button</button>\n  </div>\n</div>', 1, 8, '2018-05-27 23:55:00', 1, 0, 4, '', NULL, 123, 21, 123, 1, 0, '', '2018-05-26 23:18:22', 1, NULL),
(13, 'vvvvvvvvvvvvvvvvvvvvvvvvvvvv', 'cccccccccccccccccccccccc', 1, 2, '2018-06-01 17:55:00', 0, 0, 11, '', NULL, 17, 5, 20, 3, 0, '', '2018-05-20 23:17:45', 1, 'jpg'),
(14, 'vvvvvvvvvvvvvvvvvvvvvvvvvvvv', 'ccccccccccccccccccccccccc', 1, 2, '2018-06-01 17:55:00', 0, 0, 11, '', NULL, 17, 5, 20, 3, 0, '', '2018-05-20 23:17:45', 1, NULL),
(15, 'Квиз по Стартреку', 'Самый интереsgdfgds gsdfgсный квиз', 1, 1, '2018-06-01 19:40:00', 0, 2, 1, 'sdfgsdfgsdfgsd', 'sdfgsdfgsdfg', 1000, 50, 100, 2, 0, 'sfgadsfsdgsdfgsd', '2018-05-26 23:27:41', 1, NULL),
(16, 'аывпвап1!"№;%', 'вапр ва.юбь.бью.ь', 1, 4, '2018-05-27 01:47:00', 0, 3, 1, 'zzzzzzzzzzzz', 'xxxxxxxxxxxxxxxxx', 123, 534, 3456, 234, 0, '', '2018-05-21 12:22:41', 1, 'png'),
(17, 'hghfhdfhdfghdfh', 'dsfgsdfgsdfgsdg', 1, 1, '2018-05-30 22:02:00', 0, 0, 4, '', NULL, 234, 11, 234, 11, 0, '', '2018-05-27 15:38:27', 1, 'jpeg'),
(21, 'роп лорплорп лорплр лоалпа шг ещшгр шлдодр лордл рзэжщохзщхгшх', 'Иудеи-христиане, иудеохристиане[1][2], иудейско-христианская секта, и иногда также христиано-иудеи — ранние христиане из евреев, продолжавшие и после принятия христианства соблюдать основные предписания иудаизма.[2]\r\n\r\nХристианство воспринималось иудеями как одно из многих мессианских движений внутри иудаизма. Соответственно, первые последователи Христа были в основном евреями, рассматривавшими новое учение частью иудаизма.[2] Иудео-христиане считали себя иудеями и, помимо крещения и веры в то, что Иисус был Мессией, исполняли заповеди иудаизма (кашрут, обрезание, соблюдение Шаббата и др.) и даже видели в Иерусалимском Храме свой религиозный и духовный центр. Критика Иисусом Христом происходившего в Бейт а-Микдаше не отрицала значения Иерусалимского Храма в качестве духовного центра, а касалась деяний людей в нём (например; денежные менялы). Римляне видели в иудео-христианах (а позже в христианах) течение или секту внутри иудаизма. Запреты и разрешения касавшиеся иудеев распространялись и на иудеев-христиан.', 1, 2, '2018-05-31 14:20:00', 0, 4, 7, 'Москва, ул. Нагорная, д. 27, корп. 4', NULL, 12, 17, 30, 2, 0, '', '2018-05-20 23:17:45', 1, 'jpg'),
(22, 'gfhfdhgfdghdfgh', 'fghdfgh dfghdfgh dfghdfg hdfgh dfghdfghfgh', 1, 8, '2018-05-28 19:19:00', 0, 1, 11, 'h dfghdfgh dfghdfgh dfghdfgh dfhgdfgh', 'sdfgsdfg sdfgsdfg sdgdfg sdfg', 5, 17, 35, 2, 0, '', '2018-05-27 15:32:08', 1, 'jpg'),
(23, 'fgsdfgsdfgsdfgsdfg', 'sdfgsdfgsdfgdsfgsdfgsdfgsd', 1, 1, '2018-06-05 00:00:00', 1, 1, 5, 'fsdfgs dfgsdf', 'gsdfgsdfgsdf', 100, 1, 13, 2, 10, NULL, '2018-05-27 13:44:54', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `tg_id` bigint(20) UNSIGNED NOT NULL COMMENT 'id Телеграм-юзера',
  `dt` date NOT NULL COMMENT 'дата, которую указал пользователь',
  `city_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id города проведения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`tg_id`, `dt`, `city_id`) VALUES
(1000, '2018-05-27', 2),
(1000, '2018-05-28', 11),
(1000, '2018-06-01', 1),
(1000, '2018-05-26', 5),
(1000, '2018-06-20', 9),
(1000, '2018-05-29', 8),
(1000, '2018-05-22', 113);

-- --------------------------------------------------------

--
-- Table structure for table `tg_admins`
--

CREATE TABLE `tg_admins` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `uname` varchar(32) NOT NULL,
  `org_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `city_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tg_admins`
--

INSERT INTO `tg_admins` (`id`, `uname`, `org_id`, `city_id`) VALUES
(162, 'qqq', 1, 4),
(163, 'www', 1, 4),
(164, 'eee', 1, 4),
(165, 'rrr', 1, 10),
(166, 'ttt', 1, 10),
(167, 'yyy', 1, 10),
(168, 'uuu', 1, 6),
(169, 'iii', 1, 6),
(170, 'ooo', 1, 6),
(171, 'sss', 1, 11),
(172, 'ddd', 1, 11),
(173, 'fff', 1, 11),
(174, 'ggg', 1, 1),
(175, 'hhh', 1, 1),
(176, 'jjj', 1, 1),
(177, 'kkk', 1, 9),
(178, 'lll', 1, 9),
(179, 'zzz', 1, 9),
(180, 'xxx', 1, 5),
(181, 'vvv', 1, 5),
(182, 'bbb', 1, 8),
(183, 'nnn', 1, 8),
(184, 'mmm', 1, 8),
(185, '111', 1, 2),
(186, '222', 1, 2),
(187, '333', 1, 2),
(188, '444', 1, 7),
(189, '555', 1, 7),
(190, '666', 1, 7),
(191, '777', 1, 3),
(192, '888', 1, 3),
(193, '999', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tg_users`
--

CREATE TABLE `tg_users` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'id Телеграма',
  `uname` varchar(64) NOT NULL COMMENT 'имя пользователя Телеграма',
  `fname` tinytext NOT NULL COMMENT 'Полное имя',
  `langs` tinyint(3) UNSIGNED NOT NULL COMMENT 'Битовая маска языков мероприятий',
  `lang_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id языка интерфейса',
  `city_def` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Город по-умолчанию',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата и время создания'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tg_users`
--

INSERT INTO `tg_users` (`id`, `uname`, `fname`, `langs`, `lang_id`, `city_def`, `ts`) VALUES
(1000, 'zxcvb', 'sdfasfasbxcvbxcvbx', 9, 0, 113, '2018-05-29 12:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id билета',
  `event_id` int(10) UNSIGNED NOT NULL COMMENT 'id события',
  `tg_id` bigint(10) UNSIGNED NOT NULL COMMENT 'id Телеграм-юзера',
  `t_buy` varchar(32) CHARACTER SET ascii DEFAULT NULL COMMENT 'транзакция покупки',
  `t_refund` varchar(32) CHARACTER SET ascii DEFAULT NULL COMMENT 'транзакция возврата',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'статус билета. 0 - нормальный билет, 1 - погашенный, -1 возврат',
  `t_code` varchar(20) CHARACTER SET ascii DEFAULT NULL COMMENT 'внутренний код билета',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'дата и время добавления строки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `event_id`, `tg_id`, `t_buy`, `t_refund`, `status`, `t_code`, `ts`) VALUES
(17, 23, 1000, '8218-0830', NULL, 0, '912312', '2018-05-31 10:03:44'),
(18, 23, 1000, '912312', NULL, 0, '2756-7546', '2018-05-31 10:04:29'),
(19, 23, 1000, '912312', NULL, 0, '71106-60539', '2018-05-31 10:06:38'),
(20, 23, 1000, '912312', NULL, 1, '18811-38283', '2018-05-31 22:43:27'),
(21, 23, 1000, '912312', NULL, 1, '34981-60059', '2018-05-31 15:29:28'),
(22, 23, 1000, '912312', '912312111', -1, '95351-96579', '2018-05-31 15:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `fname` tinytext,
  `email` tinytext CHARACTER SET ascii NOT NULL,
  `passw` varchar(32) CHARACTER SET ascii NOT NULL,
  `bday` date DEFAULT NULL,
  `dt_in` date DEFAULT NULL,
  `dt_out` date DEFAULT NULL,
  `phone` varchar(16) CHARACTER SET ascii DEFAULT NULL,
  `sms` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `scn` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `fb_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `vk_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `confirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `auth_key` varchar(32) CHARACTER SET armscii8 NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ts` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `email`, `passw`, `bday`, `dt_in`, `dt_out`, `phone`, `sms`, `scn`, `fb_id`, `vk_id`, `confirmed`, `auth_key`, `updated`, `ts`) VALUES
(74, 'Иванов Иван', 'mask@inbox.ru', '2af9b1ba42dc5eb01743e6b3759b6e4b', '2000-12-01', '2018-12-03', '2017-11-11', '123456', 1, 0, 0, 0, 0, 'e0e86e63cf1495cb9609518a80976a40', '2018-05-02 12:21:30', '2018-04-26 22:30:53'),
(78, 'Mary Albefjfcebefh Thurnson', 'mggtqpkycd_1524217955@tfbnw.net', 'd21144d143a386d1031e6a05d2f94023', '2012-01-02', '2013-01-13', '2017-12-12', NULL, 1, 1, 101297964067082, 0, 0, '5d73af954533558d1feb34268c4e39e3', '2018-04-30 21:21:20', '2018-04-30 20:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `users_data`
--

CREATE TABLE `users_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `u_param` varchar(12) CHARACTER SET ascii NOT NULL,
  `p_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_data`
--

INSERT INTO `users_data` (`id`, `user_id`, `u_param`, `p_id`) VALUES
(1085, 78, 'u_countries', 30),
(1086, 78, 'u_langs', 44),
(1087, 78, 'u_champs', 63),
(1120, 74, 'u_champs', 3),
(1121, 74, 'u_countries', 4),
(1122, 74, 'u_countries', 21),
(1123, 74, 'u_langs', 3),
(1124, 74, 'u_matches', 1),
(1125, 74, 'u_matches', 2),
(1126, 74, 'u_matches', 4),
(1127, 74, 'u_matches', 5),
(1128, 74, 'u_matches', 13),
(1129, 74, 'u_matches', 15),
(1130, 74, 'u_matches', 16),
(1131, 74, 'u_matches', 18),
(1132, 74, 'u_matches', 23),
(1133, 74, 'u_matches', 25),
(1134, 74, 'u_matches', 26),
(1135, 74, 'u_matches', 27),
(1136, 74, 'u_matches', 32),
(1137, 74, 'u_matches', 33),
(1138, 74, 'u_matches', 34),
(1139, 74, 'u_matches', 37),
(1140, 74, 'u_matches', 40),
(1141, 74, 'u_matches', 43),
(1142, 74, 'u_matches', 44),
(1143, 74, 'u_matches', 46),
(1144, 74, 'u_matches', 59),
(1145, 74, 'u_matches', 60),
(1146, 74, 'u_matches', 61),
(1147, 74, 'u_matches', 62),
(1148, 74, 'u_matches', 63);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `auth_key` (`auth_key`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `lang_id` (`lang_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `status` (`status`),
  ADD KEY `dt` (`dt`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD KEY `city_id` (`city_id`),
  ADD KEY `d` (`dt`),
  ADD KEY `tg_id` (`tg_id`);

--
-- Indexes for table `tg_admins`
--
ALTER TABLE `tg_admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `tg_users`
--
ALTER TABLE `tg_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`tg_id`),
  ADD KEY `code` (`t_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fb_id` (`fb_id`),
  ADD KEY `vk_id` (`vk_id`);
ALTER TABLE `users` ADD FULLTEXT KEY `email` (`email`);

--
-- Indexes for table `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `p_id` (`p_id`);
ALTER TABLE `users_data` ADD FULLTEXT KEY `param` (`u_param`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tg_admins`
--
ALTER TABLE `tg_admins`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id билета', AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `users_data`
--
ALTER TABLE `users_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1149;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
