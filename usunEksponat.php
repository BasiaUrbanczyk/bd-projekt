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
    $link = pg_connect("host='localhost' port='5432' user='postgres' password='Lola1906' dbname='muzeum'");
    $result = pg_query($link, "select ideksponatu, tworca.idtworcy, imie, nazwisko, tytul, typ, wysokosc, szerokosc, masa from eksponat left join tworca on tworca.idtworcy=eksponat.idtworcy where ideksponatu = $id");
    $numrows = pg_num_rows($result);


    $row = pg_fetch_array($result, 0);
    $ideksponatu = $row["ideksponatu"];
    $idtworcy = $row["idtworcy"];
    $idinstytucji = pg_query($link, "select idinstytucji from wypozyczenie where ideksponatu = $id");

    $eksponatyTworcy = pg_query($link, "select ideksponatu from eksponat where idtworcy = $idtworcy");
    $numrowsET = pg_num_rows($eksponatyTworcy);

    if($numrowsET == 1){ //ostatni eksponat tworcy, trzeba usunac
        $wynik0 = pg_query($link, "DELETE FROM tworca WHERE idtworcy = $idtworcy");
    }


    $wynik = pg_query($link, "DELETE FROM eksponat WHERE ideksponatu = $ideksponatu");
    $wynik1 = pg_query($link, "DELETE FROM ekspozycja WHERE ideksponatu = $ideksponatu");
    $wynik2 = pg_query($link, "DELETE FROM wypozyczenie WHERE ideksponatu = $ideksponatu");



    $_SESSION['eksponatUsuniety'] = '<h1 class="error-text">Eksponat został usunięty</h1>';
    header('Location: eksponatyPracownik.php');

    pg_close($link);
?>



</body>
</html>