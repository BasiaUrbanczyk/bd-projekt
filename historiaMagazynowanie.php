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
    $result = pg_query($link, "select * from magazynowanie where ideksponatu = $id");
    $numrows = pg_num_rows($result);
?>

<?php
    $link2 = './eksponatPracownik.php?id='.$id;
    $wroc = "Wróć do strony eksponatu.";
    echo "<a href='".$link2."'> $wroc </a> ";
?>

<h1 class="h2-text"><?php echo "Lista obowiązkowych magazynowań: " ?></h1>
<table>
<tr>
 <th>ID magazynowania</th>
 <th>Początek</th>
 <th>Koniec</th>
 <th>Usuń magazynowanie</th>
</tr>
<?php

 // Loop on rows in the result set.

 for($ri = 0; $ri < $numrows; $ri++) {
  echo "<tr>\n";
  $row = pg_fetch_array($result, $ri);
  $idmagazynowania = $row["idmagazynowania"];
  $link_usun_magazynowanie = './usunMagazynowanie.php?id='.$idmagazynowania;


  echo " <td> ". $row["idmagazynowania"] ."</td> 
 <td>" . $row["poczatek"] . "</td>
 <td>" . $row["koniec"] . "</td>
 <td> <a href='".$link_usun_magazynowanie."'>Usuń magazynowanie</a> </td>
</tr>
";
 }

 if(isset($_SESSION['magazynowanieUsuniete'])) {
    echo $_SESSION['magazynowanieUsuniete'];
    unset($_SESSION['magazynowanieUsuniete']);}

 pg_close($link);
?>
</table>




</body>
</html>