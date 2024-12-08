<?php
include "db/db.php";
session_start();

// Získání ID kategorie z URL
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Pokud není id, nastavíme ho na 0

// Pokud ID kategorie není platné, přesměrujeme na domovskou stránku
if ($category_id <= 0) {
    header('Location: index.php'); // Předpokládáme, že máš domovskou stránku index.php
    exit;
}

// SQL dotaz pro získání příspěvků pro danou kategorii
$sql = "SELECT p.*, t.title AS topic_title, u.username, c.name AS category_name 
        FROM posts p
        JOIN topics t ON p.topic_id = t.id
        JOIN users u ON p.user_id = u.id
        JOIN categories c ON t.category_id = c.id
        WHERE c.id = :category_id
        ORDER BY p.created_at DESC"; // Seřadíme příspěvky podle data

$stmt = $db->prepare($sql);
$stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt->execute();

// Výběr příspěvků do pole
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Načteme název kategorie pro titulní stránku
$sql_category_name = "SELECT name FROM categories WHERE id = :category_id";
$stmt_category_name = $db->prepare($sql_category_name);
$stmt_category_name->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt_category_name->execute();
$category = $stmt_category_name->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VencisForum - Kategorie: <?php echo htmlspecialchars($category['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">VencisForum</a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Výpis příspěvků pro kategorii: <?php echo htmlspecialchars($category['name']); ?></h1>

        <?php if (!empty($posts)): ?>
            <div class="posts">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <h3><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['topic_title']); ?></a></h3>
                        <p><strong><?php echo htmlspecialchars($post['username']); ?></strong> - <?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>V této kategorii nejsou žádné příspěvky.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
