<?php
include('config.php');
session_start();

$user_check = $_SESSION['login_user'];

$ses_sql = mysqli_query($db, "select login from users where login = '$user_check' ");

$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

if (!isset($_SESSION['login_user'])) {
   if (isset($level)) {
      $_SESSION["redir_to"]=$level;
      header("location:../login.php");
      die();
   } else {
      $_SESSION["redir_to"]="index.php";
      header("location:login.php");
      die();
   }
}
