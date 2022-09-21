<?php
include('verify_sesh.php');
$title = mysqli_real_escape_string($db, $_POST['title']);
$description = mysqli_real_escape_string($db, $_POST['description']);
$sql = "SELECT id FROM users WHERE login = '" . $_SESSION['login_user'] . "'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
// If result matched $myusername, there must be a user with the correct id
if ($count == 1) {
    $userid = $row["id"];
    $sql = "SELECT id FROM repos WHERE author = '$userid' AND title = '$title'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    // If result matched $uid and $title, that would mean two indentical repos from a user
    if ($count == 0) {
        $add = "INSERT INTO `repos` (`id`, `author`, `title`, `description`) VALUES (NULL, '$userid','$title','$description')";
        $result = mysqli_query($db, $add) or die(mysqli_error($db));
        header("location: index.php?nr");
    }
}
