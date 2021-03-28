<?php
session_start();

if(isset($_SESSION['name'])) {
    $text = $_POST['text'];

    echo $text;
    setlocale(LC_TIME, 'fra_fra');

    $fp = fopen("./log.html", 'a');
    fwrite($fp, "<div class='msgln'>(".strftime('%H:%M:%S').") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
}
?>
