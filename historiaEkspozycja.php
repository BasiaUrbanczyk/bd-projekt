z<?php
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
    $result = pg_query($link, "select * from ekspozycja left join galeria on galeria.idgalerii = ekspozycja.idgalerii where ideksponatu = $id");
    $numrows = pg_num_rows($result);
?>
<?php
    $link2 = './eksponatPracownik.php?id='.$id;
    $wroc = "Wróć do strony eksponatu.";
    echo "<a href='".$link2."'> $wroc </a> ";
?>

<h1 class="h2-text"><?php echo "Lista ekspozycji: " ?></h1>
<table>
<tr>
 <th>ID ekspozycji</th>
 <th>Początek</th>
 <th>Koniec</th>
 <th>ID galerii</th>
 <th>Nazwa galerii</th>
 <th>Sala</th>
 <th>Usuń ekspozycję</th>
</tr>
<?php

 // Loop on rows in the result set.

 for($ri = 0; $ri < $numrows; $ri++) {
  echo "<tr>\n";
  $row = pg_fetch_array($result, $ri);
  $idekspozycji = $row["idekspozycji"];
  $link_usun_ekspozycje = './usunEkspozycje.php?id='.$idekspozycji;


  echo " <td> ". $row["idekspozycji"] ."</td> 
 <td>" . $row["poczatek"] . "</td>
 <td>" . $row["koniec"] . "</td>
 <td>" . $row["idgalerii"] . "</td>
 <td>" . $row["nazwa"] . "</td>
 <td>" . $row["sala"] . "</td>
 <td> <a href='".$link_usun_ekspozycje."'>Usuń ekspozycję</a> </td>
</tr>
";
 }

 if(isset($_SESSION['ekspozycjaUsunieta'])) {
    echo $_SESSION['ekspozycjaUsunieta'];
    unset($_SESSION['ekspozycjaUsunieta']);}

 pg_close($link);
?>
</table>



</body>
</html>