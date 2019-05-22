<?php
  require ('funkcje_ksiazka_kz.php');
  // koszyk na zakupy potrzebuje sesji, zostaje więc ona rozpoczęta
  session_start();

  @ $nowy = $_GET['nowy'];

  if($nowy)
  {
    // wybrany nowy produkt
    if(!isset($_SESSION['koszyk']))
    {
      $_SESSION['koszyk'] = array();
      $_SESSION['produkty'] = 0;
      $_SESSION['calkowita_wartosc'] ='0.00';
    }
    if(isset($_SESSION['koszyk'][$nowy]))
      $_SESSION['koszyk'][$nowy]++;
    else 
      $_SESSION['koszyk'][$nowy] = 1;
    $_SESSION['calkowita_wartosc'] =       
                                      oblicz_wartosc($_SESSION['koszyk']);
    $_SESSION['produkty'] = oblicz_produkty($_SESSION['koszyk']);

  }
  if(isset($_POST['zapisz']))
  {   
    foreach ($_SESSION['koszyk'] as $isbn => $ilosc)
    {
      if($_POST[$isbn]=='0')
        unset($_SESSION['koszyk'][$isbn]);
      else 
        $_SESSION['koszyk'][$isbn] = $_POST[$isbn];
    }
    $_SESSION['calkowita_wartosc'] = 
oblicz_wartosc($_SESSION['koszyk']);
    $_SESSION['produkty'] = oblicz_produkty($_SESSION['koszyk']);
  }

  tworz_naglowek_html('Koszyk na zakupy');

  if($_SESSION['koszyk']&&array_count_values($_SESSION['koszyk']))
    wyswietl_koszyk($_SESSION['koszyk']);
  else
  {
    echo '<p>Koszyk jest pusty</p>';
    echo '<hr />';
  }
  $cel = 'indeks.php';

  // jeżeli do koszyka został właśnie dodany przedmiot
  // kontynuacja zakupów w danej kategorii
  if($nowy)
  {
    $dane =  pobierz_dane_ksiazki($nowy);
    if($dane['idkat'])    
      $cel = 'pokaz_kat.php?idkat='.$dane['idkat']; 
  }
  wyswietl_przycisk($cel, 'kontynuacja', 'Kontynuacja zakupów');  

  // poniższy kod należy zastosować, jeśli włączona jest obsługa SSL
  // $sciezka = $_SERVER['PHP_SELF'];
  // $serwer = $_SERVER['SERVER_NAME'];
  // $sciezka = str_replace('pokaz_kat.php', '', $sciezka);
  // wyswietl_przycisk('https://'.$serwer.$sciezka.'kasa.php', 'idz-do-kasy', 'Idź do kasy');  

  // jeśli SSL nie działa, należy zastosować poniższy kod
  wyswietl_przycisk('kasa.php', 'idz-do-kasy', 'Idź do kasy');  

  
  tworz_stopke_html();
?>