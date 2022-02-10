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

    <!-- <link rel="stylesheet" href="./styles/styles.css"> -->

</head>

<body>
    <?php

        $nazwa = $_POST['nazwaGalerii'];
        $sale = $_POST['ileSal'];
        $nazwa = ucfirst($nazwa);

        $link = pg_connect("host='localhost' port='5432' user='postgres' password='Lola1906' dbname='muzeum'");
        $result = pg_query($link, "select * from galeria where nazwa like '$nazwa'");
        $numrows = pg_num_rows($result);

        if($numrows == 0){ //mozna dodac galerie
            $result = pg_query($link, "select max(idgalerii) from galeria");
            $row = pg_fetch_array($result, 0);
            $indeks = $row["max"] + 1;
            unset($_SESSION['galeriaJuzIstnieje']);
            $wynik = pg_query($link,
                  "INSERT INTO galeria VALUES ('" . 
                  pg_escape_string($indeks) . 
                  "','" . pg_escape_string($sale) . 
                  "','" . $nazwa . "')"); 
            $_SESSION['dodanoGalerie'] = '<h1 class="error-text">Udało się dodać galerię!</h1>';
            header('Location: dodajGalerie.php');
        }

        else{
            unset($_SESSION['dodanoGalerie']);
            $_SESSION['galeriaJuzIstnieje'] = '<h1 class="error-text">Galeria juz istnieje ;(</h1>';
            header('Location: dodajGalerie.php');
        }

    ?>


</body>
</html>