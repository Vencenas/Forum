<?php
include "db/db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
  // Pokud není přihlášen, přesměrujeme ho na login stránku
  header('Location: login.php');
  exit;
}

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];

  // SQL dotaz pro získání uživatelského jména
  $sql_user = "SELECT username FROM users WHERE id = ?";
  $stmt_user = $db->prepare($sql_user);
  $stmt_user->execute([$userId]);
  $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

  // Uložení jména do proměnné
  $username = $user ? $user['username'] : null;
}
// SQL dotaz pro získání kategorií
$sql_categories = "SELECT id, name FROM categories ORDER BY name ASC";
$stmt_categories = $db->prepare($sql_categories);
$stmt_categories->execute();
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

// SQL dotaz pro získání témat (topics)
$sql_topics = "SELECT t.*, c.name AS category_name, u.username 
               FROM topics t
               JOIN categories c ON t.category_id = c.id
               JOIN users u ON t.user_id = u.id
               ORDER BY t.created_at DESC"; // Seřazeno podle data vytvoření témat (novější první)
$stmt_topics = $db->prepare($sql_topics);
$stmt_topics->execute();

// Výběr všech témat do pole
$topics = $stmt_topics->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VencisForum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">VencisForum</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategorie
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categories as $category): ?>
                            <li><a class="dropdown-item" href="category.php?id=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>

            <!-- Uživatelská ikona a jméno -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($username)): ?>
                    <!-- Tlačítko pro odhlášení -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Odhlásit se
                        </a>
                    </li>
                    <!-- Uživatelská ikona a jméno -->
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($username); ?>
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



    <div class="container mt-4">
        <h1>Témata</h1>

        <?php if (!empty($topics)): ?>
            <div class="topics">
                <?php foreach ($topics as $topic): ?>
                    <div class="topic">
                        <h3><a href="topics.php?id=<?php echo $topic['id']; ?>"><?php echo htmlspecialchars($topic['title']); ?></a></h3>
                        <p><strong><?php echo htmlspecialchars($topic['username']); ?></strong> - Kategorie: <?php echo htmlspecialchars($topic['category_name']); ?> - <?php echo date('d.m.Y H:i', strtotime($topic['created_at'])); ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Žádná témata nebyla nalezena.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
