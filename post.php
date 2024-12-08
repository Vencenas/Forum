<?php
    include "db/db.php";
    session_start();

// Získání ID příspěvku z URL
    $postId = isset($_GET['id']) ? $_GET['id'] : null;

    // SQL dotaz pro získání konkrétního příspěvku
    $sql = "SELECT p.*, t.title AS topic_title, u.username 
    FROM posts p
    JOIN topics t ON p.topic_id = t.id
    JOIN users u ON p.user_id = u.id
    WHERE p.id = :postId"; // Filtrace podle ID příspěvku

    // Příprava a exekuce dotazu
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->execute();

    // Získání výsledku
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Pokud příspěvek neexistuje
    if (!$post) {
        echo "Příspěvek nebyl nalezen.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail příspěvku</title>
</head>
<body>
    <h1>Detail příspěvku</h1>

    <h2><?php echo htmlspecialchars($post['topic_title']); ?></h2>
    <p><strong><?php echo htmlspecialchars($post['username']); ?></strong> - <?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?></p>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    
    <a href="index.php">Zpět na seznam příspěvků</a>
</body>
</html>
