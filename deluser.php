<?php
include("config.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            if ($count == 0) {
                die("User does not exist");
            } elseif ($count == 1) {
                $del = "DELETE FROM `users` WHERE id = '$id'";
                $result = mysqli_query($db, $del) or die(mysqli_error($db));
            }
    }
?>