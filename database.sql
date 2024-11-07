CREATE DATABASE forum COLLATE utf8_czech_ci;

CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `role_id` INT UNSIGNED,
  `username` varchar(255),
  `password` varchar(255),
  `created_at` timestamp
);

CREATE TABLE `categories` (
    `id` iNT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255),
    `created_at` TIMESTAMP
);

CREATE TABLE `topics` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED,
    `category_id` INT UNSIGNED,
    `title` VARCHAR(255),
    `created_at` TIMESTAMP
);

CREATE TABLE `likes` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED,
    `post_id` INT UNSIGNED,
    `created_at` timestamp
);

CREATE TABLE `posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED,
  `topic_id` INT UNSIGNED,
  `content` TEXT,
  `created_at` timestamp
);

CREATE TABLE `role` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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

-- Vytvoreni rolí

INSERT INTO `role` (`name`, `level`) VALUES
("Admin", 1),
("User", 0);

-- Vytvoření USERŮ

INSERT INTO `users` (`role_id`, `username`, `password`, `created_at`) VALUES
(1,"Vencis", "test123", NOW()),
(2,"Jacketaj", "SQL123", NOW()),
(2,"Random1", "111", NOW()),
(2,"Random2", "132", NOW());


--- vytvoření kategorií
INSERT INTO `categories` (`name`, `created_at`) VALUES
("Gaming", NOW()),
("Vaření", NOW()),
("Coding", NOW());

-- vytvorení topics - témat
INSERT INTO `topics` (`user_id`, `category_id`, `title`, `created_at`) VALUES
(1, 1, "Hraní Hogwartz Legacy", NOW());

INSERT INTO `topics` (`user_id`, `category_id`, `title`, `created_at`) VALUES
(3, 2, "Sack Boy", NOW()),
(2, 3, "Progromování databáze mě zabije", NOW()),
(1, 3, "Project s Jirkou", NOW()),
(1, 1, "League of Legends", NOW());

-- vytvoření posts 

INSERT INTO `posts` (`user_id`, `topic_id`, `content`, `created_at`) VALUES
(3, 8, "Hraní Sackboye bylo zajímavé ale ještě není finished. Lorem100", NOW());

INSERT INTO `posts` (`user_id`, `topic_id`, `content`, `created_at`) VALUES
(2, 7, "Ono to nebylo na konec až tak strašný:D", NOW()),
(1, 7, "Tak Jirko doufám že si čteš tuhle zprávou, večeře byla dobrá, ale checknuli jsme ještě JoJo, příští post bude s lorem 400 abych otestoval velikost zprávy.", NOW()),
(1, 7, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. In alias, obcaecati perspiciatis voluptas quo illum consequatur. Recusandae commodi minus ea aspernatur quo velit asperiores aut nemo deleniti explicabo. Esse assumenda quasi, aperiam dicta soluta, maxime cumque officiis amet nisi quia labore repellendus quaerat aliquid minus. Culpa, iure nobis asperiores accusamus, non, vero dolorem molestiae id voluptatibus nemo aliquid facere nam! Amet saepe earum in cumque cum, a laborum similique quisquam doloribus! Saepe distinctio, dolorem ullam reiciendis debitis sed vitae minus culpa blanditiis suscipit ex omnis dignissimos eligendi, libero reprehenderit dolore illo vel fuga at quaerat quidem aliquid. Doloremque tenetur quam nihil alias, porro blanditiis repudiandae provident adipisci in libero sint et sed deleniti unde voluptate vero cupiditate assumenda saepe totam facilis dolorum. Fuga quae, veniam blanditiis provident explicabo accusamus nam molestiae sed reiciendis? Iusto debitis doloribus odio officiis ex voluptates suscipit, vitae sapiente ratione vero corporis aliquid itaque neque repellendus nihil doloremque! Sunt velit ipsa incidunt dolor, sint ut aperiam excepturi impedit similique voluptates natus minima ullam aspernatur, harum maxime? Dignissimos iure fuga nihil ipsa? Porro unde delectus consectetur aut accusamus veniam magnam ab placeat architecto veritatis culpa ducimus, perferendis voluptate id! Sint at voluptatibus quidem libero deserunt asperiores dolor!Lorem ipsum dolor sit amet consectetur, adipisicing elit. In alias, obcaecati perspiciatis voluptas quo illum consequatur. Recusandae commodi minus ea aspernatur quo velit asperiores aut nemo deleniti explicabo. Esse assumenda quasi, aperiam dicta soluta, maxime cumque officiis amet nisi quia labore repellendus quaerat aliquid minus. Culpa, iure nobis asperiores accusamus, non, vero dolorem molestiae id voluptatibus nemo aliquid facere nam! Amet saepe earum in cumque cum, a laborum similique quisquam doloribus! Saepe distinctio, dolorem ullam reiciendis debitis sed vitae minus culpa blanditiis suscipit ex omnis dignissimos eligendi, libero reprehenderit dolore illo vel fuga at quaerat quidem aliquid. Doloremque tenetur quam nihil alias, porro blanditiis repudiandae provident adipisci in libero sint et sed deleniti unde voluptate vero cupiditate assumenda saepe totam facilis dolorum. Fuga quae, veniam blanditiis provident explicabo accusamus nam molestiae sed reiciendis? Iusto debitis doloribus odio officiis ex voluptates suscipit, vitae sapiente ratione vero corporis aliquid itaque neque repellendus nihil doloremque! Sunt velit ipsa incidunt dolor, sint ut aperiam excepturi impedit similique voluptates natus minima ullam aspernatur, harum maxime? Dignissimos iure fuga nihil ipsa? Porro unde delectus consectetur aut accusamus veniam magnam ab placeat architecto veritatis culpa ducimus, perferendis voluptate id! Sint at voluptatibus quidem libero deserunt asperiores dolor!", NOW());

-- lajkovaní postů
-- 3 z 4 lajků pro pust user_id= 16 
INSERT INTO `likes` (`user_id`, `post_id`, `created_at`) VALUES
(1, 23, NOW()),
(2, 23, NOW()),
(3, 23, NOW());

INSERT INTO `likes` (`user_id`, `post_id`, `created_at`) VALUES
(1, 25, NOW()),
(2, 25, NOW()),
(3, 25, NOW()),
(4, 25, NOW());

SELECT COUNT(*) FROM users WHERE username = :username