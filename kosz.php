<?php
session_start();
include_once('funkcje_wyswietl.php');


tworz_naglowek_html('Kasa');
echo date('Y-n-j H:i:s');
echo "<h1>Podsumowanie zamówienia</h1>";
    wyswietl_kosz($_SESSION['koszyk'], false);
  wyswietl_form_kasy();



//wyswietl_przycisk('pokaz_kosz.php', 'kontynuacja', 'Kontynuacja zakupów');

tworz_stopke_html();
?>