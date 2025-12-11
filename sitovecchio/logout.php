<?php 
$lingua = $_GET['lingua'];
unset($_SESSION['id_listino']);
unset($_SESSION['user']);
session_start();
session_unset();
session_destroy();
unset($_SESSION['id_listino']);
header("location:http://www.sekurbox.com/" . $lingua . "/index.html");
?>