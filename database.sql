CREATE DATABASE forum COLLATE utf8_czech_ci;

CREATE TABLE `users` (
  `id` INT UNSIGNED PRIMARY KEY,
  `role_id` INT UNSIGNED,
  `username` varchar(255),
  `password` varchar(255),
  `created_at` timestamp
);

CREATE TABLE `categories` (
    `id` iNT UNSIGNED PRIMARY KEY,
    `name` VARCHAR(255),
    `created_at` TIMESTAMP
);

CREATE TABLE `topics` (
    `id` INT UNSIGNED PRIMARY KEY,
    `user_id` INT UNSIGNED,
    `category_id` INT UNSIGNED,
    `title` VARCHAR(255),
    `created_at` TIMESTAMP
);

CREATE TABLE `likes` (
    `id` INT UNSIGNED PRIMARY KEY,
    `user_id` INT UNSIGNED,
    `post_id` INT UNSIGNED,
    `created_at` timestamp
);

CREATE TABLE `posts` (
  `id` INT UNSIGNED PRIMARY KEY,
  `user_id` INT UNSIGNED,
  `topic_id` INT UNSIGNED,
  `content` varchar(255),
  `created_at` timestamp
);

CREATE TABLE `role` (
  `id` INT UNSIGNED PRIMARY KEY,
  `name` varchar(255),
  `level` INT UNSIGNED
);

/*  Pridani vztahu */



-- tabulka users bere pro sloupec role_id klíč z role->id
ALTER TABLE `users` ADD FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

-- tabulka likes bere pro sloupec user_id klíč z users->id

ALTER TABLE `likes` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

-- tabulka likes bere pro sloupec post_id klíč z posts->id
ALTER TABLE `likes` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);



-- tabulka posts bere pro sloupec topic_id klíč z topics->id

ALTER TABLE `posts` ADD FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

-- tabulka posts bere pro sloupec user_id klíč z users->id
ALTER TABLE `posts` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--  Tabulka topics bere pro sloupec user_id klíč z users -> id
ALTER TABLE `topics` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

-- Tabulka topics bere pro sloupec category_id klíč z categories->id
ALTER TABLE `topics` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);