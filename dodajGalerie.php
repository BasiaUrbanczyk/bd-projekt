<?php
    session_start();
?>

<!doctype html>
<html lang="pl">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<title>Eksponaty</title>
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

<div class="box">
        <h1 class="h1-text">Dane dodawanej galerii: </h1>
        <form class="box" action="./dodajGaleriePom.php" method="post">
            <label for="nazwaGalerii">Nazwa galerii:</label>
            <input type="text" value="" name="nazwaGalerii" class="login-input" required>
            <label for="ileSal">Ile sal:</label>
            <input  type ="text" value="" name="ileSal" class="login-input" required>
            <input type="submit"  class="btn" value="Dodaj"/> 
        </form>
    </div>
    <?php
        if(isset($_SESSION['galeriaJuzIstnieje'])) {
            echo $_SESSION['galeriaJuzIstnieje'];
            unset($_SESSION['galeriaJuzIstnieje']);}
        else if(isset($_SESSION['dodanoGalerie'])){
            echo $_SESSION['dodanoGalerie'];
            unset($_SESSION['dodanoGalerie']);
        }
        ?>


</body>
</html>