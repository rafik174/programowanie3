<?php


function umiesc_zamowienie($szczegoly_zamowienia)
{
  // wyciągnięcie szczegółów zamówienia jako zmiennych
  extract($szczegoly_zamowienia);


  // ustawienie adresu dostawy na taki sam jak adres klienta


  $lacz = lacz_bd();

  // Zamówienie ma zostać zapisane w ramach transakcji
  // rozpoczynamy ją wyłączając tryb autocommit;
  $lacz->autocommit(FALSE);

  // wstawienie adresu klienta
  $zapytanie = "select idklienta from klienci where
                nazwisko='$nazwisko' and imie='$imie'
                and email='$email' and telefon='$telefon'";
  $wynik = $lacz->query($zapytanie);
  if($wynik->num_rows>0)
  {
    $klient = $wynik->fetch_object();
    $idklienta = $klient->idklienta;
  }
  else
  {
    $zapytanie = "insert into klienci values
            ('', '$nazwisko','$imie','$email','$telefon')";
    $wynik = $lacz->query($zapytanie);
    if (!$wynik)
       return false;
    $idklienta = $lacz->insert_id;
  }


  $data = date('Y-n-j H:i:s');

  $idpotwierdz=losowy_ciag(15);

  $zapytanie = "insert into zamowienia values
            ('', $idklienta, ".$_SESSION['calkowita_wartosc'].", '$data', 'CZĘŚCIOWE','$idpotwierdz')";

  $wynik = $lacz->query($zapytanie);
  if (!$wynik)
    return false;

  $zapytanie = "select idzamowienia from zamowienia where 
               idklienta = $idklienta and 
               wartosc > ".$_SESSION['calkowita_wartosc']."-.001 and
               wartosc < ".$_SESSION['calkowita_wartosc']."+.001 and
               data = '$data' and
               stan_zam = 'CZĘŚCIOWE'";
  $wynik = $lacz->query($zapytanie);
  if($wynik->num_rows>0)
  {
    $zamowienie = $wynik->fetch_object();
    $idzam = $zamowienie->idzamowienia;

  }
  else
    return false;

  // umieszczenie wszystkich książek
    foreach($_SESSION['koszyk'] as $isbn => $ilosc)
    {
      $dane=pobierz_dane_event($isbn);
      $zapytanie = "delete from produkty_zamowienia where  
              idzamowienia = '$idzam' and isbn =  '$isbn'";
      $wynik = $lacz->query($zapytanie);
      $poprawiona_ilosc=$dane['ilosc']-$ilosc;
      $zapytanie = "update b_bilet 
                    set  ilosc = $poprawiona_ilosc
                    where event_id =  '$isbn'";
      $wynik = $lacz->query($zapytanie);
      $zapytanie = "insert into produkty_zamowienia values
                ('$idzam', '$isbn', ".$dane['cena'].", $ilosc)";
      $wynik = $lacz->query($zapytanie);
      if(!$wynik)
        return false;
    }

  // koniec transakcji
  $lacz->commit();
  $lacz->autocommit(TRUE);
  $tekst= 'Potwierdź zamówienie klikająć w poniższy link: <br></b><a href="http://opak.org.pl/bilety/potwierdz.php/?idpotwierdz='.$idpotwierdz.'" target="_blank" rel="noopener">klik</a>';
  $subject='Potwierdź zamówienie';
 if( mail2($email,$tekst,$subject))
   return $idklienta;
 else
   return false;
}
function losowy_ciag($dlugosc)
{$znaki= "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $losowy_ciag="";
  for ($i=0; $i < $dlugosc; $i++) $losowy_ciag .= substr($znaki, rand(0, strlen($znaki)-1), 1);
    return $losowy_ciag;}

?>