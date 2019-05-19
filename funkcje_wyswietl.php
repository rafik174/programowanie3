<?php

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
  if($tytul)
    tworz_tytul_html($tytul);
}

function tworz_stopke_html()
{
  // wyœwietlenie stopki HTML
?>
  </body>
  </html>
<?php
}

function tworz_tytul_html($naglowek)
{
  // wyœwietlenie nag³ówka
?>
  <h2><?php echo $naglowek; ?></h2>
<?php
}

function tworz_html_url($url, $nazwa)
{
  // wyœwietlenie URL-a jako ³¹cza i nowa linia
?>
  <a href="<?php echo $url; ?>"><?php echo $nazwa; ?></a><br />
<?php
}
