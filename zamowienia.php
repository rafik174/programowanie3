<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: admin.php');
    exit();
}
include_once('funkcje_wyswietl.php');;
tworz_menu_admina($_SESSION['user']);
$dblink = lacz_bd();
if($_GET['change']){
    $change=$_GET['change'];
    $zapytanie = "update zamowienia
             set stan_zam='ZAPŁACONE'
             where  idzamowienia = '$change'";
    $wynik = $dblink->query($zapytanie)or die ("Nie można wykonać polecenia: " . $dblink->error);
    $zapytanie = "select * 
                        from klienci, zamowienia 
                        where zamowienia.stan_zam='ZAPŁACONE'
                        AND zamowienia.idklienta=klienci.idklienta ";
    $wynik = $dblink->query($zapytanie);

        $zamowienie = $wynik->fetch_object();
    $email=$zamowienie->email;
    $tekst= 'Twoja płatność za zamówienie o numerze '.$zamowienie->idzamowienia.'. została pomyślnie przetworzona. </br>
            Pozdrawiamy OPAK</br>
            ';
    $subject='Płatność zaksięgowana';
    mail2($email,$tekst,$subject);

}
if($_GET['delete']){
    $delete=$_GET['delete'];
    $zapytanie = "delete 
             from zamowienia 
             where  idzamowienia = '$delete'";
    $wynik = $dblink->query($zapytanie)or die ("Nie można wykonać polecenia: " . $dblink->error);

}

$query = "SELECT * FROM zamowienia ,klienci  where not (zamowienia.stan_zam='CZĘŚCIOWE') 
          and zamowienia.idklienta=klienci.idklienta 
          ORDER BY zamowienia.idzamowienia desc ";
$result= $dblink->query($query) or die ("Nie można wykonać polecenia: " . $dblink->error);


echo "</br></br><table  class='zamowienia'>
<thead>
<tr>
<th>Lp.</th>
<th>imie</th>
<th>nazwisko</th>
<th>email</th>
<th>telefon</th>
<th>wartość</th>
<th>data</th>
<th>tytuł przelewu</th>
<th>stan zamówienia</th>
<th>potwierdź płatność</th>
<th>usuń zamówienie</th>
</tr>
</thead>
<tbody>";
$lp=0;
while ($row= $result->fetch_assoc()){
    $lp++;
    echo "<tr >";
    $idevent=stripslashes($row['idzamowienia']);
    $url1 = 'zamowienia.php?change='.$idevent;
    $url2 = 'zamowienia.php?delete='.$idevent;

    echo "<td>".$lp."</td>
 <td>  ".$row['imie']."</td>
 <td>  ".$row['nazwisko']."</td>
 <td>  ".$row['email']."</td>
 <td>  ".$row['telefon']."</td>
 <td>  ".$row['wartosc']."</td>
 <td>  ".$row['data']."</td>
  <td>  ".$row['idpotwierdz']."</td>
 <td>  ".$row['stan_zam']."</td>
 <td>" ;
    if($row['stan_zam']!="ZAPŁACONE")
    tworz_html_url($url1, 'potwierdź');
    echo "</td><td>" ;
    tworz_html_url($url2, 'usuń');
    echo "</td></tr>";
}
echo "</table>";
$dblink ->close();
tworz_stopke_html();