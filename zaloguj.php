<?php
session_start();
if((!isset($_POST['login']))||(!isset($_POST['haslo']))){

    header('Location: index.php');
    exit();
}
require_once "config.php";
$polaczenie = @new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
if ($polaczenie->connect_errno!=0){
    echo "error:".$polaczenie->connect_errno;
}
else{

    $login=$_POST['login'];
    $haslo=$_POST['haslo'];
    $login=htmlentities($login,ENT_QUOTES,"UTF-8");
    $haslo=htmlentities($haslo,ENT_QUOTES,"UTF-8");




    if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM login WHERE login='%s' AND haslo='%s'",
        mysqli_real_escape_string($polaczenie,$login),
        mysqli_real_escape_string($polaczenie,$haslo)))){

        $ilu_userow=$rezultat->num_rows;
        echo "pokaz 2";
        if($ilu_userow>0)
            {
            $wiersz=$rezultat->fetch_assoc();
            $_SESSION['user']=$wiersz["login"];
                echo "pokaz 3";
                unset($_SESSION['blad']);
            $rezultat->free_result();
                echo "pokaz 4";
            $_SESSION['zalogowany']=true;

            header('Location: panel.php');
            }


else {
    $_SESSION['blad']='<br>blad nie prawidlowy login';
    header('Location: index.php');
}
    }
}
$polaczenie->close();
?>