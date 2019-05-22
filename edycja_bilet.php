<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: admin.php');
    exit();
}

require_once "config.php";
include_once('funkcje_wyswietl.php');
tworz_naglowek_html('Bilet dodany');
echo "<a href='logout.php'>wyloguj</a>";



require_once "config.php";

    $event_id = $_POST['idwyd'];
    $cena = $_POST['cena'];
    $ilosc = $_POST['ilosc'];


              $lacz=lacz_bd();

// sprawdzenie, czy książka juz nie istnieje
$zapytanie = "SELECT * FROM b_bilet where  event_id='$event_id'";

$wynik = $lacz->query($zapytanie);
if (!$wynik || mysqli_num_rows($wynik)!=0)echo "blad taki bilet juz istnieje <a href='admin.php'>Wróć do strony admina</a>";


else{
$zapytanie = "insert into b_bilet values
            ('', '$event_id', '$ilosc', '$cena')";

$wynik = $lacz->query($zapytanie);
if (!$wynik) echo"nieznany blad skontaktuj sie z adminem".$lacz->error;
else echo "Bilet została dodana do bazy danych.<br />";
$lacz ->close();
 // echo $id_event.$idwyd;
echo "<a href='admin.php'>Wróć do strony admina</a>";
}






tworz_stopke_html();
?>
