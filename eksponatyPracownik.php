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
    $link = pg_connect("host='localhost' port='5432' user='postgres' password='Lola1906' dbname='muzeum'");
    $result = pg_query($link, "select * from eksponat left join tworca on eksponat.idtworcy = tworca.idtworcy order by eksponat.ideksponatu");
    $numrows = pg_num_rows($result);
?>
    <h1 class="h1-text"><?php echo "Informacje o eksponatach: " ?></h1>
    <?php echo " <a href='./dodajEksponat.php'>Dodaj eksponat</a>"; ?>


<h1 class="h2-text"><?php echo "Lista eksponatów: " ?></h1>
<table>
<tr>
 <th>ID eksponatu</th>
 <th>Tytuł</th>
 <th>Twórca</th>
</tr>
<?php

 // Loop on rows in the result set.

 for($ri = 0; $ri < $numrows; $ri++) {
  echo "<tr>\n";
  $row = pg_fetch_array($result, $ri);
  $idArtist = $row["idtworcy"];
  $idEksp = $row["ideksponatu"];
  $link_address_title = './eksponatPracownik.php?id='.$idEksp;
  $link_address_artist = './artystaPracownik.php?id='.$idArtist;
  $tworca = $row["imie"]." ".$row["nazwisko"];
  $title = $row["tytul"];
  echo "<td>".$row["ideksponatu"]. "</td>
  <td> <a href='".$link_address_title."'>$title</a></td> 
  <td> <a href='".$link_address_artist."'>$tworca</a> </td> </tr>"; 


  if(isset($_SESSION['eksponatUsuniety'])) {
    echo $_SESSION['eksponatUsuniety'];
    unset($_SESSION['eksponatUsuniety']);}
 }

 pg_close($link);
?>
</table>




</body>
</html>