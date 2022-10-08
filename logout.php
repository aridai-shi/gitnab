<?php
   session_start();
   
   if(session_destroy()) {
      if (isset($_GET["del"])){
         
      header("Location: login.php?del");
      }else{
         
      header("Location: login.php");
      }
   }
?>