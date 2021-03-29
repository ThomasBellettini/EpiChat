<?php
session_start();

if (isset($_SESSION['name'])) {
    header('Location: https://jam.shurisko.fr/chat/');
}

if (isset($_POST['username'])) {
    $name = $_POST['username'];
    $name_password = $_POST['password'];

    $name_pur = str_replace(' ', '', $name);
    $name_password_pur = str_replace(' ', '', $name_password);

    if (strlen($name_password_pur) <= 3) {
        header('Location: https://jam.shurisko.fr/register/index.php?error=2');
    } else if (strlen($name_pur) <= 3 || strlen($name_pur) >= 16) {
        header('Location: https://jam.shurisko.fr/register/index.php?error=1');
    } else  {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=web;charset=utf8', 'web_api', '123456789',
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            if ($pdo) {
                $hasAccount = false;

                $requests = $pdo->prepare("SELECT * FROM jam_account WHERE username='" . $name_pur . "'");
                $requests->execute(array($name_pur));
                while ($donner = $requests->fetch()) {
                    $hasAccount = true;
                }

                if ($hasAccount == false) {
                    $request = "INSERT INTO jam_account (Username, Password, Rank, Ip_adresse) VALUES ('" . $name_pur . "', '" . sha1($name_password_pur) . "', '0', '" . $_SERVER['REMOTE_ADDR'] . "')";
                    $pdo->exec($request);
                    $_SESSION['name'] = $name_pur;
                    header('Location: https://jam.shurisko.fr/chat/');
                } else {
                    header('Location: https://jam.shurisko.fr/register/index.php?error=3');
                }
            }
        } catch (PDOException $e) {
            echo $pdo . "<br>" . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../chat/ressource/favicon.ico" />
    <title>Epichat - registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="#" method="post" class="login-form">
    <h1>Create account</h1>
    <?php
    if (isset($_GET['error'])) {
        $errors = $_GET['error'];
        if ($errors == 1) {
            echo '<h3 style="text-align: center; margin: 10px 0; font-size: 20px">Le Pseudo doit être compris entre 3 et 16 charactères !</h3>';
        } else if ($errors == 2) {
            echo '<h3 style="text-align: center; margin: 10px 0; font-size: 20px">Le mot de passe doit être supérieur à 3 charactère !</h3>';
        } else if ($errors == 3) {
            echo '<h3 style="text-align: center; margin: 10px 0; font-size: 20px">Nom d\'utilisateur déjà utilisé !</h3>';
        }
    }
    ?>
    <div class="textb">
        <label>
            <input type="text" required placeholder="Username" name="username" id="username">
        </label>
    </div>

    <div class="textb">
        <label>
            <input type="password" required placeholder="Password" name="password" id="password">
        </label>
        <div class="show-password fas fa-eye-slash"></div>
    </div>


    <button class="btn fas fa-arrow-right" disabled type="submit"></button>

</form>

<script>
    var fields = document.querySelectorAll(".textb input");
    var btn = document.querySelector(".btn");
    function check(){
        btn.disabled = !(fields[0].value !== "" && fields[1].value !== "");
    }

    fields[0].addEventListener("keyup",check);
    fields[1].addEventListener("keyup",check);

    document.querySelector(".show-password").addEventListener("click",function(){
        if(this.classList[2] === "fa-eye-slash"){
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
            fields[1].type = "text";
        }else{
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
            fields[1].type = "password";
        }
    });
</script>
</body>
</html>