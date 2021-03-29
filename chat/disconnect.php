<?php
session_start();
    $_SESSION['name'] = null;
    $_SESSION['rank'] = null;

    header('Location: https://jam.shurisko.fr/');
?>
