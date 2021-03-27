
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="utf-8">
    <title>EpiChat (unlogged)</title>
    <meta property="og:site_name" content="Epitech'Jam Project" />
    <meta property="og:url" content="https://jam.shurisko.fr/" />
    <meta property="og:title" content="EpiChat" />
    <meta property="og:description" content="A Chat For meetup all people around the world!" />
    <meta property="og:color" content="A Chat For meetup all people around the world!" />
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#d02121">

    <meta name="twitter:site" content="@Epi_Chat" />
</head>

<body style="background-color: darkgray">

<?php
session_start();

if (isset($_SESSION['name'])) {
    header('Location: https://jam.shurisko.fr/testHtml');
    return;
}
$_SESSION = null;

if (isset($_POST['name'])) {
    if (strlen($_POST['name']) < 1) {
        $_POST == null;
        $_SESSION = null;
    } else {
        $_SESSION['name'] = $_POST['name'];
        header('Location: https://jam.shurisko.fr/testHtml');
        return;
    }
}

if (!isset($_SESSION['name'])) {
    echo '    <form action="./index.php" method="post">
                  <div class="form-group alert alert-dark" role="alert" style="margin: 150px auto; width: 500px;">
                    <label for="name" style="text-align: center; margin: 0 auto"> </label>
                    <input type="text" id="name" name="name" class="form-control" id="name" aria-describedby="usernameHelp" placeholder="Username" style="text-align: center">
                    <small id="usernameHelp" class="form-text text-muted" style="text-align:center; margin: 15px; font-size: large">Keep calm and chat</small>
                  <button type="submit" class="btn btn-success" style="width: 460px; margin: 0 auto">Connexion</button>
                  </div>
              </form>';
    return;
}
?>
</body>

