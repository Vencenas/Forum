<?php
// Začneme session a připojíme se k databázi
include "db/db.php";
session_start();

// Ověříme, že je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    // Pokud není uživatel přihlášen, přesměrujeme ho na přihlašovací stránku
    header('Location: login.php');
    exit;
}

// Načteme ID uživatele z session
$userId = $_SESSION['user_id'];

// SQL dotaz pro získání údajů o uživateli
$sql_user = "SELECT username, created_at FROM users WHERE id = ?";
$stmt_user = $db->prepare($sql_user);
$stmt_user->execute([$userId]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Pokud uživatel neexistuje (nebyl nalezen v databázi)
if (!$user) {
    // Odhlásíme uživatele a přesměrujeme na přihlášení
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - VencisForum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Navigační panel -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">VencisForum</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (isset($user['username'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i> Odhlásit se
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">
                                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($user['username']); ?>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Přihlásit se</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Obsah profilu -->
    <div class="container mt-4">
        <h1>Profil: <?php echo htmlspecialchars($user['username']); ?></h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Základní údaje</h5>
                <p><strong>Uživatelské jméno:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <!-- <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p> -->
                <p><strong>Datum registrace:</strong> <?php echo date('d.m.Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
