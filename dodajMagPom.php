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

    $poczatek = $_POST['poczatek'];
    $koniec = $_POST['koniec'];

    $linkdalszy = 'dodajMagazynowanie.php?id='.$id;

    if(intval($poczatek) > intval($koniec)){
        $_SESSION['zleDaneMag'] = '<h1 class="error-text">Proszę podać poprawne daty!</h1>';
        header('Location: '.$linkdalszy);
    }
    else{
        $resultEkspozycja = pg_query($link, "select * from (select idekspozycji, poczatek, koniec, eksponat.ideksponatu, idgalerii, sala from eksponat left join ekspozycja on ekspozycja.ideksponatu=eksponat.ideksponatu where eksponat.ideksponatu = $id and poczatek <= (TO_DATE('$koniec','YYYYMMDD')) and koniec >= (TO_DATE('$poczatek','YYYYMMDD'))) as a left join galeria on galeria.idgalerii = a.idgalerii");
    $resultWypozyczenie = pg_query($link, "select * from (select idwypozyczenia, poczatek, koniec, eksponat.ideksponatu, idinstytucji from eksponat left join wypozyczenie on wypozyczenie.ideksponatu=eksponat.ideksponatu where eksponat.ideksponatu = $id and poczatek <= (TO_DATE('$koniec','YYYYMMDD')) and koniec >= (TO_DATE('$poczatek','YYYYMMDD'))) as a left join instytucja on instytucja.idinstytucji = a.idinstytucji");
    $resultMagazynowanie = pg_query($link, "select idmagazynowania, poczatek, koniec, eksponat.ideksponatu from eksponat left join magazynowanie on magazynowanie.ideksponatu=eksponat.ideksponatu where eksponat.ideksponatu = $id and poczatek <= (TO_DATE('$koniec','YYYYMMDD')) and koniec >= (TO_DATE('$poczatek','YYYYMMDD'))");
    $numrowsEksp = pg_num_rows($resultEkspozycja);
    $numrowsWyp = pg_num_rows($resultWypozyczenie);
    $numrowsMag = pg_num_rows($resultMagazynowanie);

    $poczatek = pg_query($link, "select TO_DATE('$poczatek','YYYYMMDD')");
    $row = pg_fetch_array($poczatek, 0);
    $poczatek = $row["to_date"];

    $koniec = pg_query($link, "select TO_DATE('$koniec','YYYYMMDD')");
    $row = pg_fetch_array($koniec, 0);
    $koniec = $row["to_date"];

    if($numrowsEksp == 0 && $numrowsMag == 0 && $numrowsWyp == 0){ //mozna dodac
        $indeks = pg_query($link, "select max(idmagazynowania) from magazynowanie");
        $row = pg_fetch_array($indeks, 0);
        $indeks = $row["max"] + 1;
        $wynik = pg_query($link,
                  "INSERT INTO magazynowanie VALUES ('" . 
                  pg_escape_string($indeks) . 
                  "','" . pg_escape_string($poczatek) . 
                  "','" . pg_escape_string($koniec) .
                  "','" . pg_escape_string($id) . "')"); 

        $_SESSION['dodanoMagazynowanie'] = '<h1 class="error-text">Udało się dodać magazynowanie!</h1>';
        header('Location: '.$linkdalszy);
    }

    else{
        $_SESSION['terminZajetyMag'] = '<h1 class="error-text">Niestety w tym terminie eksponat ma juz zaplanowany pobyt w innym miejscu ;((</h1>';
        header('Location: '.$linkdalszy);
    }
    pg_close($link);
    }

?>

    



    



</body>
</html>