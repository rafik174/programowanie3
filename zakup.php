<?php

include_once('funkcje_wyswietl.php');
include_once('funkcje_zamowien.php');
// koszyk na zakupy potrzebuje sesji, zostaje więc ona rozpoczęta
session_start();

tworz_naglowek_html("zamówienie");
// utworzenie krótkich nazw zmiennych
$nazwisko = $_POST['nazwisko'];
$imie = $_POST['imie'];
$telefon = $_POST['telefon'];
$email = $_POST['email'];
$spr_mail=prawid_email($email);

// jeżeli wypełniony
if($_SESSION['koszyk']&&$nazwisko&&$imie&&$telefon&&$email&&$spr_mail)
{ echo 'dane poprawne';
     // możliwe umieszczenie danych w bazie
       if( umiesc_zamowienie($_POST)!=false )
       {echo 'dane poprawne';
           //wyświetl koszyk bez możliwości zmian i bez obrazków

           wyswietl_kosz($_SESSION['koszyk'], false);
           echo 'Dziękujemy za dokonanie zakupów. Teraz masz godzine na potwierdzenie zamówienia klikajać w link na mailu.';
           echo "<button><a href='index.php'>powrót na strone główną</a></button>";

       }
       else
       {
           echo 'Nie wypełniono wszystkich pól, proszę spróbować ponownie.';
           echo "<button><a href='kosz.php'>Idź do kasy</a></button>";
       }
   }
 else
 {
     echo 'Błąd formularza popraw błędy<hr />';
     echo "<button><a href='kosz.php'>powrót</a></button>";
 }

tworz_stopke_html();
?>