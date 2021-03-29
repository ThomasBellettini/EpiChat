
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="utf-8">
    <title>EpiChat (unlogged)</title>
    <meta property="og:site_name" content="Epitech's Jam Project" />
    <meta property="og:url" content="https://jam.shurisko.fr/" />
    <meta property="og:title" content="EpiChat" />
    <meta property="og:description" content="A Chat For meetup all people around the world!" />
    <meta property="og:color" content="A Chat For meetup all people around the world!" />
    <meta property="og:type" content="website">
    <meta property="og:image" content="chat/ressource/EpiChat.png">
    <meta name="theme-color" content="#0EF1F1">

    <meta name="twitter:site" content="@Epi_Chat" />
</head>

<body style="background-color: darkgray">

<?php
session_start();

$list_quote = array("Keep calm and chat",
              "Que la Force soit avec toi.",
              "Plif plouf être méchant c'est pas ouf",
              "Chassez le naturel, il reviendra au galop.",
              "C'est pas gentil d'être méchant, soit gentil, pas méchant.",
              "We never really grow up, we only learn how to act in public.",
              "Celui qui n'a pas d'objectifs ne risque pas de les atteindre.",
              "My opinions may have changed, but not the fact that I’m right.",
              "De quoi vivrait l'Eglise, si ce n'est du péché de ses fidèles ?",
              "Education is learning what you didn’t even know you didn’t know.",
              "Je ne reviens jamais sur ma parole, c’est ça pour moi être un ninja !",
              "Gardez vos amis près de vous, mais gardez vos ennemis encore plus près.",
              "Faire couler le sang au nom de la paix il n'y a que les humains pour faire ça.",
              "Il ne faut jamais vendre la peau de l'ours avant de l'avoir enculé ... euhhh tué.",
              "Si être intelligent signifie abandonner ces amis, je préfère être bête toute ma vie.",
              "Analyzing humor is like dissecting a frog. Few people are interested and it die in the process.");

$random_quote = array_rand($list_quote, 1);


if (isset($_SESSION['name'])) {
    header('Location: https://jam.shurisko.fr/chat');
    return;
}
$_SESSION = null;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $pdo = new PDO('mysql:host=localhost;dbname=web;charset=utf8', 'web_api', '123456789',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    if ($pdo) {
        $requests = $pdo->prepare("SELECT * FROM jam_account WHERE username='" . $name . "'");
        $requests->execute(array($name));

        $pass = "";
        $rank = 0;
        while ($donner = $requests->fetch()) {
            $pass = $donner['Password'];
            $rank = $donner['Rank'];
        }
        if ($pass == sha1($password)) {
            $_SESSION['name'] = $name;
            $_SESSION['rank'] = $rank;
            header('Location: https://jam.shurisko.fr/chat');
        } else {
            header('Location: https://jam.shurisko.fr/index.php?error=1');
        }
        $requests->closeCursor();
    }
}

if (!isset($_SESSION['name'])) {
    echo '    <form action="./index.php" method="post">
                  <div class="form-group alert alert-dark" role="alert" style="margin: 150px auto; width: 500px;">
                    <p for="name" style="text-align: center">';
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 1) {
            echo 'Mauvais compte/mot de passe';
        }
    }

    echo '</p>
                    <input type="text" id="name" name="name" class="form-control" id="name" aria-describedby="usernameHelp" placeholder="Username" style="text-align: center; margin: 10px 0;">
                    <input type="password" id="password" name="password" class="form-control" aria-describedby="usernameHelp" placeholder="Password" style="text-align: center; margin: 10px 0;">
                    <small id="usernameHelp" class="form-text text-muted" style="text-align:center; margin: 15px; font-size: large">';
    echo $list_quote[$random_quote];
    echo '</small>
                  <button type="submit" class="btn btn-success" style="width: 460px; margin: 0 auto">Connexion</button>
                  <a href="https://jam.shurisko.fr/register"><button type="submit" class="btn btn-success" style="width: 460px; margin: 10px auto">Créer un compte</button></a>
                  </div>
              </form>';
    return;
}
?>
</body>

