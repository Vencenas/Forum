<?php
session_start();
session_destroy(); // Ukončení session
header("Location: login.php"); // Přesměrování na přihlašovací stránku
exit();
?>