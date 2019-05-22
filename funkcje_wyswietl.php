
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
    </style>
  </head>
  <body>

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
  <a href="<?php echo $url; ?>"><?php echo $nazwa; ?></a><br />
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
    // zapytanie bazy danych o wszystkie dane konkretnej książki
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