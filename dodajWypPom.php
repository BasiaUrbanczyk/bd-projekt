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
    $link = pg_connect("host='ec2-54-155-254-112.eu-west-1.compute.amazonaws.com' port='5432' user='twekjbvjjevmlz' password='a643d1b14c97af5e52f6e7af4596bf3d7d087b998469977476f4a26de70effb2' dbname='d80bef3rqavvdc'");

    $poczatek = $_POST['poczatek'];
    $koniec = $_POST['koniec'];
    $nazwa = $_POST['nazwa'];
    $miasto = $_POST['miasto'];
    $nazwa = ucfirst($nazwa);

    $linkdalszy = 'dodajWypozyczenie.php?id='.$id;

    if(intval($poczatek) > intval($koniec)){
        $_SESSION['zleDaneWyp'] = '<h1 class="error-text">Proszę podać poprawne daty!</h1>';
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
            $instytucja = pg_query($link, "select * from instytucja where nazwa = '$nazwa'");
            $rowsIns = pg_num_rows($instytucja);
            $idInstytucji;

            if($rowsIns == 0){ //nie ma instytucji w bazie
                $tempp = pg_query($link, "select * from instytucja");
                $rowInstytucjaa = pg_num_rows($tempp);
                $indeksinst = pg_query($link, "select max(idinstytucji) from instytucja");
                if($rowInstytucjaa == 0){
                    $idinstytucji = 0;
                }
                else{
                    $row = pg_fetch_array($indeksinst, 0);
                    $idInstytucji = $row["max"] + 1;
                }
        
                $wynik = pg_query($link,
                "INSERT INTO instytucja VALUES ('" . 
                pg_escape_string($idInstytucji) . 
                "','" . pg_escape_string($nazwa) .
                "','" . pg_escape_string($miasto) . "')"); 
            }
            else{
                $row = pg_fetch_array($instytucja, 0);
                $idInstytucji = $row["idinstytucji"];
            }


            $indeks = pg_query($link, "select max(idwypozyczenia) from wypozyczenie");
            $row = pg_fetch_array($indeks, 0);
            $indeks = $row["max"] + 1;
            $wynik = pg_query($link,
                    "INSERT INTO wypozyczenie VALUES ('" . 
                    pg_escape_string($indeks) . 
                    "','" . pg_escape_string($poczatek) . 
                    "','" . pg_escape_string($koniec) .
                    "','" . pg_escape_string($id) .
                    "','" . pg_escape_string($idInstytucji) . "')"); 

            $_SESSION['dodanoWyp'] = '<h1 class="error-text">Udało się dodać wypozyczenie!</h1>';
            header('Location: '.$linkdalszy);
        }

        else{
            $_SESSION['terminZajetyWyp'] = '<h1 class="error-text">Niestety w tym terminie eksponat ma juz zaplanowany pobyt w innym miejscu ;((</h1>';
            header('Location: '.$linkdalszy);
        }
    }
    pg_close($link);
?> 




</body>
</html>