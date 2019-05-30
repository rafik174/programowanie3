<?php
session_start();
include_once('funkcje_wyswietl.php');
$ide = $_GET['ide'];
$event=pobierz_dane_event($ide);
tworz_naglowek_html('kup bilet na '.$event['event_name']);
if (is_array($event))
{
    echo "<H1>Wybór biletów:</H1>";
    ?>

    <form id="rezerwacja" action="pokaz_kosz.php" method="post" ><fieldset>
  <?php  echo "<table>
<thead>
<tr>
<th>Nazwa</th>
<th>Cena</th>
<th>Liczba</th>
<th></th>
</tr>
</thead>
<tbody>";


        echo "<td><input type='hidden' name='ide' value='".$event['event_id']."'>".$event['event_name']." </td>
<td>  ".$event['cena']."</td><td><input name='ilosc2' value='1' type='text'></td><td>" ;

        echo "</td></tr>";

    echo "</table>";
echo "<input type='submit' value='dalej'>";
echo "</fieldset></form>";

}
else
    echo 'Dane tej książki nie mogą zostać wyświetlone w tym momencie.';


tworz_stopke_html();