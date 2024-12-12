<?php
include "db/db.php";
session_start();

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

// Zpracování formuláře pro přidání příspěvku
if (isset($_POST['uploadPost'])) {
    // Získání hodnot z formuláře
    $postTitle = isset($_POST['PostTitle']) ? $_POST['PostTitle'] : '';
    $postContent = isset($_POST['PostContent']) ? $_POST['PostContent'] : '';

    // Zajištění, že jsou vyplněny oba vstupy
    if (!empty($postTitle) && !empty($postContent)) {
        // Příprava SQL dotazu pro vložení příspěvku do databáze
        $sql_insert_post = "INSERT INTO posts (topic_id, user_id, title, content, created_at) 
                            VALUES (:topic_id, :user_id, :title, :content, NOW())";
        $stmt_insert_post = $db->prepare($sql_insert_post);
        $stmt_insert_post->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
        $stmt_insert_post->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT); // Předpokládáme, že uživatelské ID je uloženo v session
        $stmt_insert_post->bindParam(':title', $postTitle, PDO::PARAM_STR);
        $stmt_insert_post->bindParam(':content', $postContent, PDO::PARAM_STR);
        $stmt_insert_post->execute();

        // Přesměrování zpět na téma, aby se zobrazily nové příspěvky
        header("Location: topics.php?id=$topic_id");
        exit;
    } else {
        // Pokud nejsou vyplněné oba údaje
        $error_message = "Obě pole (název a obsah příspěvku) musí být vyplněná!";
    }
}

$postForm = null;
if(array_key_exists("AddPost", $_POST)) {
    $postForm = 
    "<div class='container'>
        <form method='POST'>
            <textarea name='PostTitle' placeholder='Název příspěvku' required></textarea>
            <textarea name='PostContent' placeholder='Napiš sem tvůj příspěvek' required></textarea>
            <button type='submit' name='uploadPost'>Uploadni příspěvek</button>
        </form>
    </div>";
} else {
    $postForm = "<div class='container'>
        <form method='post'>
            <button name='AddPost' class='btn btn-primary'>Přidej příspěvek</button>
        </form>
    </div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VencisForum - Téma: <?php echo htmlspecialchars($topic['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigace -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">VencisForum</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="index.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Odhlásit se</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php"><?php echo htmlspecialchars($username); ?></a>
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

    <!-- Formulář pro přidání příspěvku -->
    <?php echo $postForm; ?>

    <!-- Zobrazení informací o tématu -->
    <div class="container mt-4">
        <h1>Téma: <?php echo htmlspecialchars($topic['title']); ?></h1>
        <p><strong><?php echo htmlspecialchars($topic['username']); ?></strong> - Kategorie: <?php echo htmlspecialchars($topic['category_name']); ?> - Vytvořeno: <?php echo date('d.m.Y H:i', strtotime($topic['created_at'])); ?></p>
        
        <!-- Zobrazení obsahu tématu -->
        <div class="topic-content">
            <h3>Obsah tématu:</h3>
            <p><?php echo nl2br(htmlspecialchars($topic['content'])); ?></p>
        </div>

        <h3>Příspěvky v tomto tématu:</h3>

        <!-- Zobrazení příspěvků včetně jejich obsahu -->
        <?php if (!empty($posts)): ?>
            <div class="list-group">
                <?php foreach ($posts as $post): ?>
                    <div class="list-group-item">
                        <h4 class="mb-1"><?php echo htmlspecialchars($post['title']); ?></h4>
                        <h5 class="mb-1"><?php echo htmlspecialchars($post['username']); ?></h5>
                        <p class="mb-1"><?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?></p>
                        <!-- Přímo zobrazený obsah příspěvku -->
                        <div class="post-content mt-2">
                            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Žádné příspěvky v tomto tématu.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
