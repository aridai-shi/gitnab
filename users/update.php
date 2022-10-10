<?php
$level = "users/index.php";
include('../verify_sesh.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    if (!isset($_POST["respass"])) {
        $login = $_POST["login"];
        $oldpass = $_POST["cpass"];
        $hashedoldpass = $_POST["acpass"];
        $newpass = $_POST["pass"];
        $admin = $_POST["admin"];
        $comp = password_verify($oldpass, $hashedoldpass);
        $pass;
        if ($comp) {
            $pass = password_hash(mysqli_real_escape_string($db, $newpass), PASSWORD_DEFAULT);
        } else {
            $pass = $hashedoldpass;
            if ($_SESSION['admin'] && !empty($newpass)) {
                echo "{ADMIN WARNING: Admins cannot change a password unless they know the original. Perhaps you're looking for 'Reset password'?} \n";
            }
        }
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            die("User does not exist");
        } elseif ($count == 1) {
            $query = "UPDATE `users` SET `login` = '{$login}',`pass` = '{$pass}',`admin` = " . $admin . " WHERE `users`.`id` = '{$id}'";
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
            if ($result!==false){
                if (($login != $_SESSION['login_user']) && ($id == $_SESSION['id_user'])) $_SESSION['login_user'] = $login;
            }
        }
    } else {
        $newpass = "";
        for ($i = 0; $i <= 16; $i++) {
            $newpass .= getRandFromPassSource(($i % 4));
        }
        $pass = password_hash(mysqli_real_escape_string($db, $newpass), PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            die("User does not exist");
        } elseif ($count == 1) {
            $query = "UPDATE `users` SET `pass` = '{$pass}' WHERE `users`.`id` = '{$id}'";
            echo "NEW PASSWORD FOR USER: " . $newpass;
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
        }
    }
    
}



function getRandFromPassSource($i)
{
    $passSources = ["ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz", "0123456789", "!@#$%^&*()_+~\\`|}{[]:;?><,./-="];
    $source = $passSources[$i];
    return $source[rand(0, strlen($source) - 1)];
}
