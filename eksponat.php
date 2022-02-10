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
    $result = pg_query($link, "select tworca.idtworcy, imie, nazwisko, tytul, typ, wysokosc, szerokosc, masa from eksponat left join tworca on tworca.idtworcy=eksponat.idtworcy where ideksponatu = $id");
    $resultEkspozycja = pg_query($link, "select * from (select poczatek, koniec, eksponat.ideksponatu, idgalerii, sala from eksponat left join ekspozycja on ekspozycja.ideksponatu=eksponat.ideksponatu where eksponat.ideksponatu = $id and (select current_date) >= poczatek and (select current_date) <= koniec) as a left join galeria on galeria.idgalerii = a.idgalerii");
    $resultWypozyczenie = pg_query($link, "select * from (select poczatek, koniec, eksponat.ideksponatu, idinstytucji from eksponat left join wypozyczenie on wypozyczenie.ideksponatu=eksponat.ideksponatu where eksponat.ideksponatu = $id and (select current_date) >= poczatek and (select current_date) <= koniec) as a left join instytucja on instytucja.idinstytucji = a.idinstytucji");
    $numrows = pg_num_rows($result);
    $numrowsEksp = pg_num_rows($resultEkspozycja);
    $numrowsWyp = pg_num_rows($resultWypozyczenie);

    $row = pg_fetch_array($result, 0);
    pg_close($link);
?>
    <h1 class="h1-text"><?php echo $row["tytul"] ?></h1>
    <?php
        $where;
        if($numrowsEksp == 1){
            $rowWhere = pg_fetch_array($resultEkspozycja, 0);
            $where = " Wystawiony w galerii: ".$rowWhere["nazwa"].", w sali nr ".$rowWhere["sala"].", do ".$rowWhere["koniec"];
        }
        else if($numrowsWyp == 1){
            $rowWhere = pg_fetch_array($resultWypozyczenie, 0);
            $where = " Wypożyczony instytucji:  ".$rowWhere["nazwa"].", w mieście ".$rowWhere["miasto"].", do ".$rowWhere["koniec"];
        }
        else{ //jest w magazynie
            $where = " W magazynie";
        }



        $name = $row["imie"] . " " . $row["nazwisko"];
        $idArtist = $row["idtworcy"];
        $link_address_artist = './artysta.php?id='.$idArtist;
        echo "Twórca: "."<a href='".$link_address_artist."'>$name</a>"."<br>";
        echo "Typ: ".$row["typ"]."<br>";
        echo "Wysokość: ".$row["wysokosc"]."<br>";
        echo "Szerokość: ".$row["szerokosc"]."<br>";
        echo "Masa: ".$row["masa"]."<br>";
        echo "Stan:".$where."<br>";
    ?>

</body>
</html>