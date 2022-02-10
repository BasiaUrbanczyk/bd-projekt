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
        $link = './dodajWypPom.php?id='.$id;
?>

<?php
    $link2 = './eksponatPracownik.php?id='.$id;
    $wroc = "Wróć do strony eksponatu.";
    echo "<a href='".$link2."'> $wroc </a> ";
?>

    <div class="box">
        <h1 class="h1-text">Dane dodawanego wypozyczenia: </h1>
        <form class="box" action= <?php  echo $link ?>  method="post">
            <label for="poczatek">Początek ('YYYYMMDD'):</label>
            <input type="text" value="" name="poczatek" class="login-input" required>
            <label for="koniec">Koniec ('YYYYMMDD'):</label>
            <input  type ="text" value="" name="koniec" class="login-input" required>
            <label for="nazwa">Nazwa instytucji:</label>
            <input type="text" value="" name="nazwa" class="login-input" required>
            <label for="miasto">Miasto:</label>
            <input type="text" value="" name="miasto" class="login-input" required>
            <input type="submit"  class="btn" value="Dodaj"/> 
        </form>
    </div>
    <?php
        if(isset($_SESSION['terminZajetyWyp'])) {
            echo $_SESSION['terminZajetyWyp'];
            unset($_SESSION['terminZajetyWyp']);}
        else if(isset($_SESSION['dodanoWyp'])){
            echo $_SESSION['dodanoWyp'];
            unset($_SESSION['dodanoWyp']);
        }
        else if(isset($_SESSION['zleDaneWyp'])){
            echo $_SESSION['zleDaneWyp'];
            unset($_SESSION['zleDaneWyp']);
        }
        ?>
</body>
</html>