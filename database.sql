CREATE DATABASE forum COLLATE utf8_czech_ci;


CREATE TABLE users (
    id INT UNSIGNED PRIMARY KEY,
    role_id INT,
    username VARCHAR(255),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE role (
    id INT UNSIGNED PRIMARY KEY,
    name VARCHAR(255),
    level INT
);

CREATE TABLE topics (
    id INT UNSIGNED PRIMARY KEY,
    user_id INT,
    category_id INT,
    title varchar(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE likes (
    id INT UNSIGNED PRIMARY KEY,
    user_id INT,
    post_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT UNSIGNED PRIMARY KEY,
    user_id INT,
    topic_id INT,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT UNSIGNED PRIMARY KEY,
    name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
