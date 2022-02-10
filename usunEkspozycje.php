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
    $temp = pg_query($link, "select * from ekspozycja WHERE idekspozycji = $id");
    $row = pg_fetch_array($temp, 0);
    $idEksponatu = $row["ideksponatu"];

    $wynik = pg_query($link, "DELETE FROM ekspozycja WHERE idekspozycji = $id");


    $_SESSION['ekspozycjaUsunieta'] = '<h1 class="error-text">Ekspozycja została usunięta</h1>';
    header('Location: historiaEkspozycja.php?id='.$idEksponatu);

    pg_close($link);
        
    ?>



</body>
</html>