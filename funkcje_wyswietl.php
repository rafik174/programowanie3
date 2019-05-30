
<?php
require_once "config.php";
function tworz_naglowek_html($tytul = '')
{

?>
  <html>
  <head>
    <title><?php echo $tytul; ?></title>
    <style>
      h2 { font-family: Arial, Helvetica, sans-serif; font-size: 22px; color = red; margin = 6px }
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #FF0000; width=70%; text-align=center}
      a { color: #000000 }
        nav a {margin: 10px 50px}
        .zamowienia {
            border-collapse: collapse;
        }

      .zamowienia  tr td,.zamowienia  tr th {
        border: 1px solid black;
          padding: 10px;
      }
    </style>
  </head>
  <body>

<?php

}
function tworz_menu_admina($admin)
{
    require_once "config.php";
    tworz_naglowek_html('panel admina');
?><p>zalogowany jako:<?php echo $admin;?></p>
    <nav >
    <a href="dodaj_bilet.php">dodaj bilet</a>
    <a href="aktywne_bilety.php">przeglądaj aktywne bilety</a>
        <a href="zamowienia.php">przeglądaj aktywne zamówienia</a>
    <a href="logout.php" style="float: right">wyloguj</a>
</nav>
<?php

}

function tworz_stopke_html()
{
  // wyświetlenie stopki HTML
?>
  </body>
  </html>
<?php
}

function tworz_tytul_html($naglowek)
{
  // wyświetlenie nagłówka
?>
  <h2><?php echo $naglowek; ?></h2>
<?php
}

function tworz_html_url($url, $nazwa)
{
  // wyświetlenie URL-a jako łącza i nowa linia
?>
  <a href="<?php echo $url; ?>"><?php echo $nazwa; ?></a>
<?php
}

function lacz_bd()
{
    $wynik = new mysqli('localhost', 'raffal_opak', '8kul345ee53dJllaj', 'raffal_opak');
    if (!$wynik)
        return false;
    $wynik->autocommit(TRUE);
    $wynik->query("SET NAMES 'utf8'");
    return $wynik;
}
function pobierz_dane_event($ide)
{

    if (!$ide || $ide =='')
        return false;

    $lacz = lacz_bd();
    $zapytanie = "select * from wp_em_events, b_bilet where wp_em_events.event_id='$ide' and b_bilet.event_id='$ide'";
    $wynik = @$lacz->query($zapytanie);
    if (!$wynik)
        return false;
    $wynik = @$wynik->fetch_assoc();
    return $wynik;
}
function oblicz_wartosc($koszyk)
{
    // obliczenie całkowitej wartości produktów w koszyku
    $wartosc = 0.0;
    if(is_array($koszyk))
    {
        $lacz = lacz_bd();
        foreach($koszyk as $ide => $ilosc)
        {
            $zapytanie = "select cena from b_bilet where event_id='$ide'";
            $wynik = $lacz->query($zapytanie);
            if ($wynik)
            {
                $produkt = $wynik->fetch_object();
                $cena_produktu = $produkt->cena;
                $wartosc +=$cena_produktu*$ilosc;
            }
        }
    }
    return $wartosc;
}

function oblicz_produkty($koszyk)
{
    // obliczenie całkowitej ilości produktów w koszyku na zakupy
    $produkty = 0;
    if(is_array($koszyk))
    {
        $produkty = array_sum($koszyk);
    }
    return $produkty;
}

function wyswietl_kosz ($koszyk, $zmiana = true){


    if($_SESSION['koszyk']&&array_count_values($_SESSION['koszyk'])) {

        echo '<table border = 0 width = 100% cellspacing = 0>
        <form action = pokaz_kosz.php method = post>
        <tr><th align = left bgcolor="#cccccc">Rodzaj</th>
        <th bgcolor="#cccccc">Cena</th><th bgcolor="#cccccc">Ilość</th>
        <th bgcolor="#cccccc">Wartość</th>';
        if ($zmiana == true) echo '<th bgcolor="#cccccc">Usuń</th>';
        echo '</tr>';

        // wyświetlanie każdego produktu jako wiersza tabeli
        foreach ($_SESSION['koszyk'] as $ide => $ilosc) {
            $event = pobierz_dane_event($ide);
            echo '<tr>';

            echo '&nbsp;';
            echo '</td>';

            echo '<td align = left>';
            echo '<a href = "pokaz_event.php?ide=' . $ide . '">' . $event['event_name'] . '</a>';
            echo '</td><td align = center>PLN ' . number_format($event['cena'], 2);
            echo '</td><td align = center>';
            // jeżeli zmiany są dozwolone, ilości znajdują się w polach tekstowych

            if ($zmiana == true)
                echo "<input type = 'text' name = \"$ide\" value = \"$ilosc\" size = \"3\">";
            else
                echo $ilosc;
            echo '</td><td align = "center">PLN '.number_format($event['cena']*$ilosc,2)."";
            if ($zmiana==true){
                echo '</td><td>';
                $url = 'pokaz_kosz.php?usun='.$ide;
                tworz_html_url($url, 'usun');
            }

            echo"</td></tr>";
        }
        // wyświetl wiersz sumy
        echo "<tr >
          <th colspan = ". (2) .">&nbsp;</td>
          <th align = \"center\" > 
              ".$_SESSION['produkty']."
          </th>
          <th align = \"center\" >
              PLN ".number_format($_SESSION['calkowita_wartosc'], 2).
            '</th>
        </tr>';
        // wyświetl przycisk zapisujący zmiany
        if($zmiana == true)
        {
        echo '<tr>
            
            <td align = right>
              <input type = hidden name =zapisz value = true />  
              <input type = submit value = "zapisz zmiany" 
                     border = "0" alt = "Zapisz zmiany" heigth = 50 width = 135>
            </td>
            <td>&nbsp;</td>
        </tr>';}

        echo '</form></table>';

    }
    else
    {
        echo '<p>Koszyk jest pusty</p>';
        echo '<hr />';
    }
}
function wyswietl_form_kasy()
{echo date('Y-n-j H:i:s');
    // wyświetlenie formularza pobierającego adres
    ?>
    <br />
    <table border = 0 width = 100% cellspacing = 0>
        <form action = zakup.php method = post>
            <tr><th colspan = 2 bgcolor="#cccccc">Dane klienta:</th></tr>
            <tr>
                <td>Imię</td>
                <td><input type = text name = imie value = "" maxlength = 40 size = 40></td>
            </tr>
            <tr>
                <td>Nazwisko</td>
                <td><input type = text name = nazwisko value = "" maxlength = 40 size = 40></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type = text name = email value = ""  size = 40></td>
            </tr>
            <tr>
                <td>Telefon</td>
                <td><input type = text name = telefon value = "" maxlength = 20 size = 40></td>
            </tr>
            <tr>
                <td colspan = 2 align = center>
                    <b>Proszę nacisnąć przycisk "Zakup" w celu dokonania zakupu
                        lub "Kontynuacja zakupów" w celu zmiany zamówienia</b>
                   <input type="submit" value="Złóż zamówienie">
                </td>
            </tr>
        </form>
    </table><hr />
    <?php
}
function prawid_email($email)
{
// formuła prawidłowego adresu e-mail
    $sprawdz = '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]/';

    if(preg_match($sprawdz, $email))
        return true;
    else
        return false;

}
function mail2($email,$tekst,$subject){

// Naglowki mozna sformatowac tez w ten sposob.
    $naglowki = "Reply-to: $email <$email>" . PHP_EOL;
    $naglowki .= "From: Miejsce X<kontakt@opak.org.pl>" . PHP_EOL;
    $naglowki .= "MIME-Version: 1.0" . PHP_EOL;
    $naglowki .= "Content-type: text/html; charset=UTF-8" . PHP_EOL;

//Wiadomość najczęściej jest generowana przed wywołaniem funkcji

    $wiadomosc = '<html>

<head>
  <title>Wiadomość e-mail</title>
</head>
<body>
<p>'.$tekst.'</p>

</body>
</html>';


    return (mail($email, $subject, $wiadomosc, $naglowki));

}


?>