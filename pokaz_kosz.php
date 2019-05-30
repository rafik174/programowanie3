<?php
  require ('funkcje_wyswietl.php');
  // koszyk na zakupy potrzebuje sesji, zostaje więc ona rozpoczęta
  session_start();
  @ $nowy = $_POST['ide'];;
@ $ilosc2 = $_POST['ilosc2'];

  if($nowy) {
      // wybrany nowy produkt
      if (!isset($_SESSION['koszyk'])) {
          $_SESSION['koszyk'] = array();
          $_SESSION['produkty'] = 0;
          $_SESSION['calkowita_wartosc'] = '0.00';
          echo "1";
      }

      $_SESSION['koszyk'][$nowy] = $ilosc2;
      $_SESSION['calkowita_wartosc'] = oblicz_wartosc($_SESSION['koszyk']);
      $_SESSION['produkty'] = oblicz_produkty($_SESSION['koszyk']);

  }echo $_POST['zapisz'];
  if(isset($_POST['zapisz']))
  {   
    foreach ($_SESSION['koszyk'] as $ide => $ilosc)
    {
      if($_POST[$ide]=='0')
        unset($_SESSION['koszyk'][$ide]);
      else 
        $_SESSION['koszyk'][$ide] = $_POST[$ide];
    }
    $_SESSION['calkowita_wartosc'] = oblicz_wartosc($_SESSION['koszyk']);
    $_SESSION['produkty'] = oblicz_produkty($_SESSION['koszyk']);
  }
if(isset($_GET['usun'])){
    foreach ($_SESSION['koszyk'] as $ide => $ilosc)
    {
        if($ide==($_GET['usun']))
            unset($_SESSION['koszyk'][$ide]);
        else "blad";

    }

}

  tworz_naglowek_html('Koszyk na zakupy');

wyswietl_kosz($_SESSION['koszyk'], true);
echo "<button><a href='kosz.php'>Idź do kasy</a></button>";
echo "<button><a href='index.php'>kontynuuj zakupy</a></button>";
  //wyswietl_przycisk('kasa.php', 'idz-do-kasy', 'Idź do kasy');

  
  tworz_stopke_html();
?>