<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: admin.php');
    exit();
}
include_once('funkcje_wyswietl.php');;
tworz_menu_admina($_SESSION['user']);
$idb = $_GET['idb'];




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

    echo "</td></tr><p>NIEAKTYWNA STRONA</p>";


tworz_stopke_html();