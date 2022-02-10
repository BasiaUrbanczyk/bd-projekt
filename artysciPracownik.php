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
    $link = pg_connect("host='localhost' port='5432' user='postgres' password='Lola1906' dbname='muzeum'");
    $result = pg_query($link, "select * from tworca");
    $numrows = pg_num_rows($result);
?>


<h1 class="h2-text"><?php echo "Lista artystów: " ?></h1>
<table>
<tr>
 <th>ID artysty</th>
 <th>Imię i nazwisko</th>
 <th>Rok urodzenia</th>
 <th>Rok śmierci</th>
</tr>
<?php

 // Loop on rows in the result set.

 for($ri = 0; $ri < $numrows; $ri++) {
  echo "<tr>\n";
  $row = pg_fetch_array($result, $ri);
  $idArtist = $row["idtworcy"];
  $link_address_artist = './artystaPracownik.php?id='.$idArtist;
  $tworca = $row["imie"]." ".$row["nazwisko"];
  echo " <td>" . $idArtist . "</td>
  <td> <a href='".$link_address_artist."'>$tworca</a></td> 
 <td>" . $row["rokurodzenia"] . "</td>
 <td>" . $row["roksmierci"] . "</td>
</tr>
";
 }
 pg_close($link);
?>
</table>

</body>
</html>