<?php
session_start();
if((isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))){
    header('Location :panel.php');
    exit();
}
?>
<html>
<head>
    <title>
        bilety.opak.org.pl</title>
    <style type="text/css">
        * { font-family: verdana; font-size: 10pt; COLOR: gray; }
        b { font-weight: bold; }
        table { border: 1px solid gray;}
        td { text-align: center; padding: 25px;}
    </style>
</head>
<body>
<form action="zaloguj.php" method="post">
    Login: <br><input type="text" name="login" ><br><br>
    Hasło: <br><input type="text" name="haslo" id="haslo"><br><br>
    <input type="submit" name="" id="Zaloguj się">

    <?php

    if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
    ?>

</form>
</body>
</html>