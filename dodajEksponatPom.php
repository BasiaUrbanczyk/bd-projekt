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

        $tytul = $_POST['tytul'];
        $typ = $_POST['typ'];
        $wysokosc = $_POST['wysokosc'];
        $szerokosc = $_POST['szerokosc'];
        $wypozyczalne = $_POST['wypozyczalne'];
        $masa = $_POST['masa'];
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $dataurodzenia = $_POST['dataurodzenia'];
        $datasmierci = $_POST['datasmierci'];
        $imie = ucfirst($imie);
        $nazwisko = ucfirst($nazwisko);
        $tytul = ucfirst($tytul);
        $wysokosc = intval($wysokosc);
        $szerokosc = intval($szerokosc);
        $masa = intval($masa);

        

        if(!is_int($wysokosc) || !is_int($szerokosc) || $szerokosc <= 0 || $wysokosc <= 0 || $masa <= 0|| !is_int($masa) || !($wypozyczalne == "tak" || $wypozyczalne == "nie")){
            unset($_SESSION['dodanoEksponat']);
            $_SESSION['zledane'] = '<h1 class="error-text">Proszę wprowadzić poprawne dane!</h1>';
            header('Location: dodajEksponat.php');
        }
        else{
            if($wypozyczalne == "tak"){
                $wypozyczalne = 1;
            }
            else{
                $wypozyczalne = 0;
            }
    
            $link = pg_connect("host='ec2-54-155-254-112.eu-west-1.compute.amazonaws.com' port='5432' user='twekjbvjjevmlz' password='a643d1b14c97af5e52f6e7af4596bf3d7d087b998469977476f4a26de70effb2' dbname='d80bef3rqavvdc'");
            $result = pg_query($link, "select * from eksponat left join tworca on eksponat.idtworcy = tworca.idtworcy where tytul like '$tytul' and nazwisko like '$nazwisko' and typ like '$typ'");
            $numrows = pg_num_rows($result);
    
            if($numrows == 0){ //mozna dodac eksponat
                    //sprawdzanie, czy artysta jest juz w bazie
                unset($_SESSION['zledane']);
                unset($_SESSION['eksponatJuzIstnieje']);
                $idtworcy;
                $resultArtysta = pg_query($link, "select * from tworca where imie like '$imie' and nazwisko like '$nazwisko'");    
                $numrowsArtysta = pg_num_rows($resultArtysta);
                if($numrowsArtysta == 0){ //nie ma artysty w bazie
                    $indeksArtysty = pg_query($link, "select max(idtworcy) from tworca");
                    $row = pg_fetch_array($indeksArtysty, 0);
                    $idtworcy = $row["max"] + 1;
                    $wynik = pg_query($link,
                      "INSERT INTO tworca VALUES ('" . 
                      pg_escape_string($idtworcy) . 
                      "','" . pg_escape_string($nazwisko) . 
                      "','" . pg_escape_string($imie) .
                      "','" . pg_escape_string($dataurodzenia) .
                      "','" . pg_escape_string($datasmierci) . "')"); 
                }
                else{
                    $row = pg_fetch_array($resultArtysta, 0);
                    $idtworcy = $row["idtworcy"];
                }
    
                $result = pg_query($link, "select max(ideksponatu) from eksponat");
                      $row = pg_fetch_array($result, 0);
                      $indeks = $row["max"] + 1;
                      $wynik = pg_query($link,
                            "INSERT INTO eksponat VALUES ('" . 
                            pg_escape_string($indeks) . 
                            "','" . pg_escape_string($tytul) . 
                            "','" . pg_escape_string($typ) .
                            "','" . pg_escape_string($wysokosc) .
                            "','" . pg_escape_string($szerokosc) .   
                            "','" . pg_escape_string($masa) .
                            "','" . pg_escape_string($idtworcy) .  
                            "','" . pg_escape_string($wypozyczalne) . "')"); 
                      $_SESSION['dodanoEksponat'] = '<h1 class="error-text">Udało się dodać eksponat!</h1>';
                      header('Location: dodajEksponat.php');
    
            }
    
            else{
                unset($_SESSION['dodanoEksponat']);
                unset($_SESSION['zledane']);
                $_SESSION['eksponatJuzIstnieje'] = '<h1 class="error-text">Eksponat juz istnieje ;(</h1>';
                header('Location: dodajEksponat.php');
            }
        }

        pg_close($link);
    ?>


</body>
</html>