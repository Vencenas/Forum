<?php
include "db/db.php";
session_start();
try {
      if(array_key_exists("register", $_POST))
      {
        $userName = $_POST["name"];
        $userPassword = $_POST["password"];

          if(!empty($userName) && !empty($userPassword))
          {
            $checkStmt = $db->prepare("SELECT * FROM users WHERE username = :username");
            $checkStmt->bindParam(':username', $userName);
            $checkStmt->execute();

            if($checkStmt->fetchColumn() > 0){
              echo "Uživatel s tímto jménem existuje.";
            } else {
              $stmt = $db->prepare("INSERT INTO users (username, password, role_id) VALUES(:username, :password, :roleId)");
              $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
              $roleId = 1;
              $stmt->bindParam(':username', $userName);
              $stmt->bindParam(':password', $hashedPassword);
              $stmt->bindParam(':roleId', $roleId);

              if($stmt->execute()){
                echo "úspěšně ses zaregistroval";
              } else {
                echo "Došlo k chybě v registraci.";
              }
            }
          } else {
            echo "Prosím vypln všechna pole.";
          }
        }
    }catch (PDOException $e) {
  echo "Chyba připojení" . $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<style>
    .row {
        height: 100vh;
    }
    .form-check-input {
        border-color: blue;
    }
</style>
<body>
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col"></div>
            <div class="col">
                <form method="post">
                    <div class="mb-3">
                      <label  class="form-label">Přihlašovací jméno</label>
                      <input type="text" class="form-control" id="login" name="name">
                    </div>
                    <div class="mb-3">                   
                      <label for="InputPassword" class="form-label">Heslo</label>
                      <input type="password" class="form-control" id="password" name="password">
                    </div>                  
                      <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Souhlasím s podmínky užívání VencisForum</label>
                      </div>
                    <div class="mb-3">Už jsi zaregistrovaný? <a href="login.html">Přihlaš se zde.</a></div>                   
                    <button type="submit" class="btn btn-primary" id="register" name="register">Registrace</button>
                  </form>
            </div>
            <div class="col"></div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>