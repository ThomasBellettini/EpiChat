<?php
session_start();

if(isset($_SESSION['name'])) {
    $text = $_POST['text'];

    echo $text;
    setlocale(LC_TIME, 'fra_fra');

    $fp = fopen("./log.html", 'a');

    if ($_SESSION['rank'] == 1) {
        fwrite($fp, "<div class='msgln'>(" . strftime('%H:%M:%S') . ") <span class=\"badge rounded-pill bg-danger\">Administrateur</span> <b>" . $_SESSION['name'] . " </b>: " . stripslashes(htmlspecialchars($text)) . "<br></div>");
    } else if ($_SESSION['rank'] == 2) {
        fwrite($fp, "<div class='msgln'>(" . strftime('%H:%M:%S') . ") <span class=\"badge rounded-pill bg-danger\">Administrateur</span> <b>" . $_SESSION['name'] . " </b>: " . stripslashes(htmlspecialchars($text)) . "<br></div>");
    } else {
        fwrite($fp, "<div class='msgln'>(".strftime('%H:%M:%S').") <span class=\"badge rounded-pill bg-warning text-dark\">Warning</span> <b>".$_SESSION['name']." </b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    }
    fclose($fp);
}
?>
