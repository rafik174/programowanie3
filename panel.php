<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: admin.php');
    exit();
}

require_once "config.php";
include_once('funkcje_wyswietl.php');
tworz_naglowek_html('panel admina');
echo "<a href='logout.php'>wyloguj</a>";
echo "<h2>Witaj ".$_SESSION['user'].'</h2>';
echo '<a href="dodaj_bilet.php">dodaj bilet</a>';
$dblink = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD) or die("Could not
connect: " );
$dblink->query("SET NAMES 'utf8'");
$dblink->select_db($DB_NAME) or die ("Nie można wybrać bazy:
pracownicy: " );
echo " <br /> Wybrano bazę danych";
$query = "SELECT * FROM wp_em_events where event_start_date>DATE_SUB(CURRENT_DATE, INTERVAL 1 year) and event_status=1";
$result= $dblink->query($query) or die ("Nie można wykonać polecenia: " . $dblink->error);
echo "<br/>Wynik to:";
echo "<table>";
while ($row= $result->fetch_assoc()){
    echo "<tr>";
    $idpracownika=stripslashes($row['event_name']);
    $nazwisko=$row['event_start_date'];
    echo "<td>".$idpracownika." </td><td>  ".$nazwisko."</td> " ;
    echo "</tr>";
}
echo "</table>";
$dblink ->close();

tworz_stopke_html();


