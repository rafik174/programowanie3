<?php

if (!isset($_GET['idpotwierdz'])){

    header('Location: index.php');
    exit();
}
include_once('funkcje_wyswietl.php');
$idpotwierdz=$_GET['idpotwierdz'];

$lacz = lacz_bd();


        $zapytanie = "select * 
                        from klienci, zamowienia 
                        where zamowienia.idpotwierdz='$idpotwierdz'
                        and zamowienia.stan_zam='CZĘŚCIOWE'
                        AND zamowienia.idklienta=klienci.idklienta ";
$wynik = $lacz->query($zapytanie);
if($wynik->num_rows==1)
{
    $zamowienie = $wynik->fetch_object();
    $email= $zamowienie->email;
    $tekst= 'Dziękujemy za potwierdzenie złożenia zamóienia numer '.$zamowienie->idzamowienia.'. Poniżej znajdziesz dane do przelewu:</br>
            Kwota: '.$zamowienie->wartosc.'</br>
            Tytułem:'.$zamowienie->idpotwierdz.'</br>
            Nr rachunku: 40 1940 1076 3079 3831 0004 0000 CREDIT AGRICOLE</br>
Stowarzyszenie OPAK – Opolski Projektor Animacji Kulturalnych, Ul.H.Sienkiewicza 20 oficyna, 45-037 Opole</br>
            ';
    $subject='Zamówienie potwierdzone czekamy na płatność';
    mail2($email,$tekst,$subject);
    $zapytanie = "update zamowienia
             set stan_zam='POTWIERDZONE'
             where  idpotwierdz = '$idpotwierdz'";

    $wynik = $lacz->query($zapytanie);
    echo "zamówienie potwierdzone";
}else{
    echo "zamówienie już potwierdzone lub błędny kod";



}
?>