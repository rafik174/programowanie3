<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: admin.php');
    exit();
}

require_once "config.php";
include_once('funkcje_wyswietl.php');
tworz_naglowek_html('Dodaj bilet');
echo "<a href='logout.php'>wyloguj</a>";
?>
  <form action=\"edycja_bilet.php\" method=\"post\">
  <table border='0'>
  <tr>
      <td>wybierz wydarzenie:</td>
      <td><select name='idwyd'>
  
          </select>
        </td>
   </tr>
   <tr>
    <td>Cena:</td>
    <td><input type='text' name='cena' /></td>
   </tr>

    <tr>

        <input type='submit' />
        </form></td>
            <?php


tworz_stopke_html();
?>
