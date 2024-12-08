<?php
include "db/db.php";
session_start();

// Získání ID tématu z URL
$topic_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Pokud ID tématu není platné, přesměrujeme na domovskou stránku
if ($topic_id <= 0) {
    header('Location: index.php');
    exit;
}

// SQL dotaz pro získání informací o tématu
$sql_topic = "SELECT t.*, c.name AS category_name, u.username 
              FROM topics t
              JOIN categories c ON t.category_id = c.id
              JOIN users u ON t.user_id = u.id
              WHERE t.id = :topic_id";
$stmt_topic = $db->prepare($sql_topic);
$stmt_topic->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
$stmt_topic->execute();
$topic = $stmt_topic->fetch(PDO::FETCH_ASSOC);

// SQL dotaz pro získání příspěvků tohoto tématu
$sql_posts = "SELECT p.*, u.username 
              FROM posts p
              JOIN users u ON p.user_id = u.id
              WHERE p.topic_id = :topic_id
              ORDER BY p.created_at DESC"; // Seřadit podle data vytvoření příspěvku
$stmt_posts = $db->prepare($sql_posts);
$stmt_posts->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
$stmt_posts->execute();
$posts = $stmt_posts->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VencisForum - Téma: <?php echo htmlspecialchars($topic['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Navigace -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">VencisForum</a> <!-- Odkaz na homepage -->
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Téma: <?php echo htmlspecialchars($topic['title']); ?></h1>
        <p><strong><?php echo htmlspecialchars($topic['username']); ?></strong> - Kategorie: <?php echo htmlspecialchars($topic['category_name']); ?> - Vytvořeno: <?php echo date('d.m.Y H:i', strtotime($topic['created_at'])); ?></p>

        <h3>Příspěvky v tomto tématu:</h3>

        <!-- Zobrazení příspěvků -->
        <?php if (!empty($posts)): ?>
            <div class="list-group">
                <?php foreach ($posts as $post): ?>
                    <a href="post.php?id=<?php echo $post['id']; ?>" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?php echo htmlspecialchars($post['username']); ?></h5>
                        <p class="mb-1"><?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Žádné příspěvky v tomto tématu.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
