<?php
    $level = "users/index.php";
    include('../verify_sesh.php');
    $id = $_POST["id"];
    $login = $_POST["login"];
    $oldpass = $_POST["cpass"];
    $hashedoldpass = $_POST["acpass"];
    $newpass = $_POST["pass"];
    $admin = $_POST["admin"];
    $comp = password_verify($oldpass,$hashedoldpass);
?>