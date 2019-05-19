<?php
session_start();
echo "1";
session_unset();
echo "12";
header('Location: admin.php');
echo "13";
?>