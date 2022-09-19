<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gitnab - Log in</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <meta name="color-scheme" content="dark light">
    <script>
        if (window.matchMedia("(prefers-color-scheme: dark)").media === "not all") {
            document.documentElement.style.display = "none";
            document.head.insertAdjacentHTML(
                "beforeend",
                "<link id=\"css\" rel=\"stylesheet\" href=\"../dist/css/bootstrap.css\" onload=\"document.documentElement.style.display = ''\">"
            );
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet" media="(prefers-color-scheme: dark)">
    <?php
    include("config.php");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    $error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form 
        $myusername = mysqli_real_escape_string($db, $_POST['login']);
        $mypassword = mysqli_real_escape_string($db, $_POST['pass']);

        $sql = "SELECT id FROM users WHERE login = '$myusername' and pass = '$mypassword'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row
        if ($count == 1) {
            $_SESSION['login_user'] = $myusername;
            $_SESSION["loggedin"] = TRUE;
            header("location: index.php");
        } else {
            $error = "Your login or password is invalid";
        }
    }
    ?>
</head>

<body>
    <div class="h-100 d-flex flex-column align-items-center align-content-center justify-content-center pt-4">
        <div>
            <h1>gitnab - an experimental VCS.</h1>
            <br>
        </div>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="d-flex flex-column text-center">
                <div class="form-group">
                    <h2>Login</h2>
                    <input type="text" class="form-control  my-2" name="login" placeholder="Username" id="login" required>
                    <input type="password" name="pass" class="form-control  my-2" placeholder="Password" id="pass" required>
                    <button type="submit" class="btn btn-success mb-2  my-2">Log in</button>
                </div>
                <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                echo "<p class='text-danger'>You are already logged in, " . $_SESSION['login_user'] . "</p>";
            }
            if (!empty($error)) {
                echo '<div class="text-danger">' . $error . '</div>';
            }
            ?>
            </form>
            
        </div>
    </div>

</body>

</html>