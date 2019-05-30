<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('Location: admin.php');
    exit();
}
include_once('funkcje_wyswietl.php');;
tworz_menu_admina($_SESSION['user']);

?>

  <form action="edycja_bilet.php" method="post">
  <table border='0'>
  <tr>
      <td>wybierz wydarzenie:</td>
      <td><select name='idwyd'>
              <?php
              $lacz=lacz_bd();
              $query = "SELECT * FROM wp_em_events where event_start_date>DATE_SUB(CURRENT_DATE, INTERVAL 1 year) and event_status=1";
              $result= $lacz->query($query) or die ("Nie można wykonać polecenia: " . $lacz->error);
              while ($row= $result->fetch_assoc()){

              $event_name=stripslashes($row['event_name']);
              $event_id=stripslashes($row['event_id']);
              echo "<option value='$event_id'>".$event_name." </option>" ;}

              $lacz ->close();
              ?>
          </select>
        </td>
   </tr>
   <tr>
    <td>Cena:</td>
    <td><input type='text' name='cena' /></td>
   </tr>
      <tr>
          <td>Ilość:</td>
          <td><input type='text' name='ilosc' /></td>
      </tr>

    <tr>
        <td>dodaj:</td>
        <td><input type='submit' value="dodaj" /></td></tr>
        </form>
            <?php


tworz_stopke_html();
?>
