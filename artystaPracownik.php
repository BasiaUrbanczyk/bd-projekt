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

    $result = pg_query($link, "select * from tworca where idtworcy = $id");
    $numrows = pg_num_rows($result);

    $row = pg_fetch_array($result, 0);
?>
    <h1 class="h1-text"><?php echo $row["imie"]. " ". $row["nazwisko"] ?></h1>
    <?php
        echo "ID twórcy: ".$row["idtworcy"]."<br>";
        echo "Rok urodzenia: ".$row["rokurodzenia"]."<br>";
        echo "Rok śmierci: ".$row["roksmierci"];
    ?>

<h1 class="h2-text"><?php echo "Eksponaty artysty:" ?></h1>
<?php
    $result = pg_query($link, "select ideksponatu, tytul from tworca left join eksponat on tworca.idtworcy = eksponat.idtworcy where tworca.idtworcy = $id");
    $numrows = pg_num_rows($result);
    for($ri = 0; $ri < $numrows; $ri++) {
        $row = pg_fetch_array($result, $ri);
        $idEksp = $row["ideksponatu"];
        $link_address_title = './eksponatPracownik.php?id='.$idEksp;
        $title = $row["tytul"];
        echo "<a href='".$link_address_title."'>$title</a><br>";
       }
       pg_close($link);
?>

</body>
</html>