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

<?php
        $id=$_GET["id"];
        $link = './dodajEkspPom.php?id='.$id;
?>

<?php
    $link2 = './eksponatPracownik.php?id='.$id;
    $wroc = "Wróć do strony eksponatu.";
    echo "<a href='".$link2."'> $wroc </a> ";
?>

    <div class="box">
        <h1 class="h1-text">Dane dodawanej ekspozycji: </h1>
        <form class="box" action= <?php  echo $link ?>  method="post">
            <label for="poczatek">Początek ('YYYYMMDD'):</label>
            <input type="text" value="" name="poczatek" class="login-input" required>
            <label for="koniec">Koniec ('YYYYMMDD'):</label>
            <input  type ="text" value="" name="koniec" class="login-input" required>
            <label for="nazwa">Nazwa galerii:</label>
            <input type="text" value="" name="nazwa" class="login-input" required>
            <label for="sala">Sala (int):</label>
            <input type="text" value="" name="sala" class="login-input" required>
            <input type="submit"  class="btn" value="Dodaj"/> 
        </form>
    </div>
    <?php
        if(isset($_SESSION['terminZajetyEksp'])) {
            echo $_SESSION['terminZajetyEksp'];
            unset($_SESSION['terminZajetyEksp']);}
        else if(isset($_SESSION['dodanoEksp'])){
            echo $_SESSION['dodanoEksp'];
            unset($_SESSION['dodanoEksp']);
        }
        else if(isset($_SESSION['zleDaneEksp'])){
            echo $_SESSION['zleDaneEksp'];
            unset($_SESSION['zleDaneEksp']);
        }
        else if(isset($_SESSION['nieMaGalerii'])){
            echo $_SESSION['nieMaGalerii'];
            unset($_SESSION['nieMaGalerii']);
        }
        ?>






</body>
</html>