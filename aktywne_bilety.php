<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: admin.php');
    exit();
}
include_once('funkcje_wyswietl.php');;
tworz_menu_admina($_SESSION['user']);
$dblink = lacz_bd();

$query = "SELECT * FROM wp_em_events, b_bilet where event_start_date>DATE_SUB(CURRENT_DATE, INTERVAL 1 year) and event_status=1 and wp_em_events.event_id=b_bilet.event_id and b_bilet.ilosc > 0";
$result= $dblink->query($query) or die ("Nie można wykonać polecenia: " . $dblink->error);


echo "</br></br><table>
<thead>
<tr>
<th>Data</th>
<th>Godzina</th>
<th>Wydarzenie</th>
<th>Sprawdź zamówienia</th>
<th></th>
</tr>
</thead>
<tbody>";
while ($row= $result->fetch_assoc()){
    echo "<tr>";
    $data=$row['event_start_date'];
    $godzina=$row['event_start_time'];
    $idevent=stripslashes($row['id_bilet']);
    $wydarzenie=stripslashes($row['event_name']);
    $url = 'kupcy.php?ide='.$idevent;


    echo "<td>".$data." </td><td>  ".$godzina."</td><td>  ".$wydarzenie."</td><td>" ;
    tworz_html_url($url, 'sprawdź zamówienia');
    echo "</td></tr>";
}
echo "</table>";
$dblink ->close();
tworz_stopke_html();


