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
    $result = pg_query($link, "select * from wypozyczenie left join instytucja on wypozyczenie.idinstytucji = instytucja.idinstytucji where ideksponatu = $id");
    $numrows = pg_num_rows($result);
?>

<?php
    $link2 = './eksponatPracownik.php?id='.$id;
    $wroc = "Wróć do strony eksponatu.";
    echo "<a href='".$link2."'> $wroc </a> ";
?>


<h1 class="h2-text"><?php echo "Lista wypożyczeń: " ?></h1>
<table>
<tr>
 <th>ID wypożyczenia</th>
 <th>Początek</th>
 <th>Koniec</th>
 <th>ID instytucji</th>
 <th>Nazwa instytucji</th>
 <th>Miasto instytucji</th>
 <th>Usuń wypożyczenie</th>
</tr>
<?php

 // Loop on rows in the result set.

 for($ri = 0; $ri < $numrows; $ri++) {
  echo "<tr>\n";
  $row = pg_fetch_array($result, $ri);
  $idwypozyczenia = $row["idwypozyczenia"];
  $link_usun_wypozyczenie = './usunWypozyczenie.php?id='.$idwypozyczenia;


  echo " <td> ". $row["idwypozyczenia"] ."</td> 
 <td>" . $row["poczatek"] . "</td>
 <td>" . $row["koniec"] . "</td>
 <td>" . $row["idinstytucji"] . "</td>
 <td>" . $row["nazwa"] . "</td>
 <td>" . $row["miasto"] . "</td>
 <td> <a href='".$link_usun_wypozyczenie."'>Usuń wypożyczenie</a> </td>
</tr>
";
 }

 if(isset($_SESSION['wypozyczenieUsuniete'])) {
    echo $_SESSION['wypozyczenieUsuniete'];
    unset($_SESSION['wypozyczenieUsuniete']);}

 pg_close($link);
?>
</table>



</body>
</html>