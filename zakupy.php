<?php

include ('funkcje_ksiazka_kz.php');
// koszyk na zakupy potrzebuje sesji, zostaje więc ona rozpoczęta
session_start();

tworz_naglowek_html("Kasa");
// utworzenie krótkich nazw zmiennych
$nazwisko = $_POST['nazwisko'];
$imie = $_POST['imie'];
$telefon = $_POST['telefon'];
$email = $_POST['email'];
$spr_mail=prawid_email($email);

// jeżeli wypełniony
if($_SESSION['koszyk']&&$nazwisko&&$imie&&$telefon&&$email&&$spr_mail)
{ echo 'dane poprawne';
  /*  // możliwe umieszczenie danych w bazie
    if( umiesc_zamowienie($_POST)!=false )
    {
        //wyświetl koszyk bez możliwości zmian i bez obrazków
        wyswietl_koszyk($_SESSION['koszyk'], false, 0);

        wyswietl_dostawe(oblicz_koszt_dostawy());

        // pobranie szczegółów karty kredytowej
        wyswietl_form_karty($nazwisko);

        wyswietl_przycisk('pokaz_kosz.php', 'kontynuacja', 'Kontynuacja zakupów');
    }
    else
    {
        echo 'Nie wypełniono wszystkich pól, proszę spróbować ponownie.';
       // wyswietl_przycisk('kasa.php', 'powrot', 'Powrót');
    }
}*/}
else
{
    echo 'Nie wypełniono wszystkich pól, proszę spróbować ponownie.<hr />';
    echo "<button><a href='kosz.php'>Idź do kasy</a></button>";
}

tworz_stopke_html();
?>