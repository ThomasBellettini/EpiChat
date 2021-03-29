<?php

    session_start();
    if (!isset($_SESSION))
        header('Location: https://jam.shurisko.Fr');
    else if ($_SESSION['rank'] != 1)
        header('Location: https://jam.shurisko.fr/');

    $myFile = "log.html";
    $fh = fopen($myFile, 'w') or die("can't open file");
    fwrite($fh, "");
    fclose($fh);
?>