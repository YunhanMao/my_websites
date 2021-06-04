
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `yunhanm_todo_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `yunhanm_todo_db`;


DROP TABLE IF EXISTS `account_info`;
CREATE TABLE `account_info` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `account_info_id` int(11) NOT NULL,
  `urgency_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `urgency`;
CREATE TABLE `urgency` (
  `id` int(11) NOT NULL,
  `level` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `urgency` (`id`, `level`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5');

ALTER TABLE `account_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

ALTER TABLE `events`
  ADD PRIMARY KEY (`id`,`account_info_id`,`urgency_id`),
  ADD KEY `fk_events_account_info_idx` (`account_info_id`),
  ADD KEY `fk_events_urgency1_idx` (`urgency_id`);


ALTER TABLE `urgency`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `account_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

ALTER TABLE `urgency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_account_info` FOREIGN KEY (`account_info_id`) REFERENCES `account_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_urgency1` FOREIGN KEY (`urgency_id`) REFERENCES `urgency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
