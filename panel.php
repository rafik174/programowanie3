<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}
echo "witaj".$_SESSION['user'];
require_once "config.php";
$dblink = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD) or die("Could not
connect: " );
$dblink->query("SET NAMES 'utf8'");
echo " <br /> Connected successfully";
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
echo "<a href='logout.php'>wyloguj</a>";


