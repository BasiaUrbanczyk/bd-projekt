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
$link = pg_connect("host='ec2-54-155-254-112.eu-west-1.compute.amazonaws.com' port='5432' user='twekjbvjjevmlz' password='a643d1b14c97af5e52f6e7af4596bf3d7d087b998469977476f4a26de70effb2' dbname='d80bef3rqavvdc'");
$result = pg_query($link, "select tworca.idtworcy, ideksponatu, tytul, imie, nazwisko from eksponat left join tworca on eksponat.idtworcy = tworca.idtworcy");
$numrows = pg_num_rows($result);
?>

<h1 class="h1-text">EKSPONATY</h1>
<?php
    $link2 = './index.php';
    $wroc = "Wróć do poprzedniej strony.";
    echo "<a href='".$link2."'> $wroc </a> ";
?>

<table>
<tr>
 <th>tytuł</th>
 <th>twórca</th>
</tr>
<?php

 // Loop on rows in the result set.

 for($ri = 0; $ri < $numrows; $ri++) {
  echo "<tr>\n";
  $row = pg_fetch_array($result, $ri);
  $name = $row["imie"] . " " . $row["nazwisko"];
  $idArtist = $row["idtworcy"];
  $idEksp = $row["ideksponatu"];
  $link_address_title = './eksponat.php?id='.$idEksp;
  $link_address_artist = './artysta.php?id='.$idArtist;
  $title = $row["tytul"];
  echo "<td> <a href='".$link_address_title."'>$title</a></td>
  <td> <a href='".$link_address_artist."'>$name</a> </td> </tr>";
 }
 pg_close($link);
?>
</table>
</body>
</html>