<?php
include "db/db.php";

session_start();

if (isset($_POST['login']) && isset($_POST['password'])) {
    // Získání hodnot z formuláře
    $userName = $_POST['login'];
    $password = $_POST['password'];

    // Příprava SQL dotazu pro ověření uživatelského jména a hesla
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $userName);
    $stmt->execute();

    // Získání uživatelského záznamu
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Přihlášení úspěšné, uložit informace do session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login'] = $user['username'];
        header("Location: index.php"); // Přesměrování na dashboard nebo jinou stránku
        exit();
    } else {
        // Chybová hláška při nesprávných údajích
        $error = "Nesprávné uživatelské jméno nebo heslo.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    .row {
        height: 100vh;
    }
</style>
<body>
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col"></div>
            <div class="col">
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                <form method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Přihlašovací jméno</label>
                      <input type="text" class="form-control" id="login" aria-describedby="emailHelp" name="login">
                    </div>
                    <div class="mb-3">                   
                      <label for="InputPassword" class="form-label">Heslo</label>
                      <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3"><a href="register.html">Nejsi registrovaný? </a></div>                   
                    <button type="submit" class="btn btn-primary" >Příhlasit se</button>
                  </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>