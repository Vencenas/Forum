<?php

$servername = "localhost";
$username = "root";
$password = file_get_contents('./db_key.txt');
$dbname = "forum";

$db = new PDO(
  "mysql:host=$servername;dbname=$dbname;charset=utf8",
  $username,
  $password, // heslo
  array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ),
);

 
