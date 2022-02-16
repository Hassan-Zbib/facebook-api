SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blocks` (`id`, `user_id`, `friend_id`, `created_at`) VALUES
(2, 6, 1, '2022-02-16 15:42:39'),
(3, 1, 13, '2022-02-17 00:07:18');

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `request` varchar(25) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `request`, `created_at`) VALUES
(3, 1, 3, 'accepted', '2022-02-16 21:41:43'),
(4, 14, 9, 'accepted', '2022-02-16 21:53:51'),
(5, 1, 7, 'accepted', '2022-02-16 23:36:04'),
(6, 3, 1, 'pending', '2022-02-17 00:43:34'),
(8, 1, 6, 'pending', '2022-02-17 01:20:32'),
(9, 1, 7, 'pending', '2022-02-17 01:20:54'),
(10, 1, 9, 'pending', '2022-02-17 01:21:13');

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `likes` (`id`, `user_id`, `status_id`, `created_at`) VALUES
(82, 1, 10, '2022-02-16 01:19:09');

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `statuses` (`id`, `user_id`, `content`, `likes_count`, `created_at`, `updated_at`) VALUES
(6, 7, 'fdgdfhdshsdfgyahedrfyha', -46, '2022-02-14 12:13:15', '2022-02-17 00:03:52'),
(8, 7, 'fdgdfhdshsdfgyahedrfyha', -9, '2022-02-14 12:13:30', '2022-02-16 00:30:14'),
(9, 7, 'fdgdfhdshsdfgyahedrfyha', 8, '2022-02-14 12:13:31', '2022-02-16 01:48:01'),
(10, 7, 'fdgdfhdshsdfgyahedrfyha', -8, '2022-02-14 13:24:33', '2022-02-16 01:19:09'),
(11, 3, 'jklhfvhkzxgffdljfvyhlkjc', -9, '2022-02-14 18:45:38', '2022-02-16 01:03:11'),
(15, 1, 'ewrtfewqrtfewtrftrdfsgtsrfgsgffsg', 0, '2022-02-15 22:52:44', '2022-02-16 14:46:19'),
(16, 1, 'dfgdg', 0, '2022-02-16 01:23:09', '2022-02-16 01:23:09'),
(20, 14, 'ghsdghgh', 0, '2022-02-16 21:50:08', '2022-02-16 21:50:08');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` longblob DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `picture`, `created_at`, `updated_at`) VALUES
(1, 'Hassan Zbib', 'hassan.zbib01@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2022-02-12 19:40:44', '2022-02-16 23:50:14'),
(3, 'Hala Zbib', 'Halazbib22@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, '2022-02-12 19:42:09', '2022-02-12 19:42:19'),
(6, 'test', 'HAssan.zbib02@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, '2022-02-13 03:20:20', '2022-02-13 03:20:20'),
(7, 'testttt', 'test@test.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, '2022-02-14 06:41:55', '2022-02-14 06:41:55'),
(8, 'testttt', 'tes5t@test.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, '2022-02-15 09:09:58', '2022-02-15 09:09:58'),
(9, 'test Last', 'test@last.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2022-02-16 17:12:23', '2022-02-16 17:12:23'),
(10, 'test2 test2last', 'dsffdsaf@email.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2022-02-16 17:14:03', '2022-02-16 17:14:03'),
(11, 'testt test3', 'example@test.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2022-02-16 17:14:44', '2022-02-16 17:14:44'),
(12, 'test4 pleaseWork', 'pleaseWork@test.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2022-02-16 17:15:41', '2022-02-16 17:15:41'),
(13, 'sdf sdfg', 'sdf@fegh.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2022-02-16 17:15:55', '2022-02-16 17:15:55'),
(14, 'hassan  zbib', 'HASSANZBIB@GMAIL.COM', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2022-02-16 21:46:27', '2022-02-16 21:46:27');


ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blocker_id` (`user_id`),
  ADD KEY `blocked_id` (`friend_id`);

ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `friend_id` (`friend_id`);

ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `liked_user_id` (`user_id`);

ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `blocks`
  ADD CONSTRAINT `blocked_id` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blocker_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `friends`
  ADD CONSTRAINT `friend_id` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `likes`
  ADD CONSTRAINT `liked_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `status_id` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `statuses`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
