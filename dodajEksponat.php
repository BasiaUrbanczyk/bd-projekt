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
        <h1 class="h1-text">Dane dodawanego eksponatu: </h1>
        <?php
    $link2 = './eksponatyPracownik.php';
    $wroc = "Wróć do poprzedniej strony.";
    echo "<a href='".$link2."'> $wroc </a> ";
?>

        <form class="box" action="./dodajEksponatPom.php" method="post">
            <label for="tytul">Tytuł:</label>
            <input type="text" value="" name="tytul" class="login-input" required>
            <label for="typ">Typ:</label>
            <input  type ="text" value="" name="typ" class="login-input" required>
            <label for="wysokosc">Wysokość (int):</label>
            <input  type ="text" value="" name="wysokosc" class="login-input" required>
            <label for="szerokosc">Szerokość (int):</label>
            <input  type ="text" value="" name="szerokosc" class="login-input" required>
            <label for="masa">Masa (int):</label>
            <input  type ="text" value="" name="masa" class="login-input" required>
            <label for="wypozyczalne">Czy wypozyczalny (tak/nie):</label>
            <input  type ="text" value="" name="wypozyczalne" class="login-input" required>
            <label for="imie">Imię twórcy:</label>
            <input  type ="text" value="" name="imie" class="login-input">
            <label for="nazwisko">Nazwisko twórcy:</label>
            <input  type ="text" value="" name="nazwisko" class="login-input">
            <label for="dataurodzenia">Rok urodzenia (int):</label>
            <input  type ="text" value="" name="dataurodzenia" class="login-input">
            <label for="datasmierci">Rok śmierci (int):</label>
            <input  type ="text" value="" name="datasmierci" class="login-input">
            <input type="submit"  class="btn" value="Dodaj"/> 
        </form>
    </div>
    <?php
        if(isset($_SESSION['zledane'])) {
            echo $_SESSION['zledane'];
            unset($_SESSION['zledane']);}
        else if(isset($_SESSION['dodanoEksponat'])){
            echo $_SESSION['dodanoEksponat'];
            unset($_SESSION['dodanoEksponat']);
        }
        else if(isset($_SESSION['eksponatJuzIstnieje'])){
            echo $_SESSION['eksponatJuzIstnieje'];
            unset($_SESSION['eksponatJuzIstnieje']);
        }
        ?>


</body>
</html>