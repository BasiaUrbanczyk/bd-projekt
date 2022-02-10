<?php
    session_start();
?>


<!doctype html>

<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Strona Bazy Danych</title>
    <meta name="description" content="Opis contentu">
    <meta name="author" content="SitePoint">

    <meta property="og:title" content="A Basic HTML5 Template">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.websiteurl.com">
    <meta property="og:description" content="Opis contentu">
    <meta property="og:image" content="image.png">

    <link rel="icon" href="assets/favicon.ico">
    <link rel="icon" href="assets/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="assets/apple-touch-icon.png">

    <link rel="stylesheet" href="./styles/styles.css">

</head>

<body>
    <?php

        $login = $_POST['login'];
        $password = $_POST['password'];


        if($login == "basia" and $password == "123"){
            unset($_SESSION['error']);
            header('Location: pracownik.php');
        }
        else{
            $_SESSION['error'] = '<h1 class="error-text">Nieprawidłowy login lub hasło</h1>';
            header('Location: login.php');
        }

    ?>


</body>
</html>