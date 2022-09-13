<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // Initialize the session
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: index.php");
        exit;
    }

    // Include config file
    require_once "config.php";

    // Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check if username is empty
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // Check if password is empty
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate credentials
        if (empty($username_err) && empty($password_err)) {
            // Prepare a select statement
            $sql = "SELECT id, username, password FROM users WHERE username = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_username);

                // Set parameters
                $param_username = $username;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Store result
                    $stmt->store_result();

                    // Check if username exists, if yes then verify password
                    if ($stmt->num_rows == 1) {
                        // Bind result variables
                        $stmt->bind_result($id, $username, $hashed_password);
                        if ($stmt->fetch()) {
                            if (password_verify($password, $hashed_password)) {
                                // Password is correct, so start a new session
                                session_start();

                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                // Redirect user to welcome page
                                header("location: welcome.php");
                            } else {
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid username or password.";
                            }
                        }
                    } else {
                        // Username doesn't exist, display a generic error message
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        }

        // Close connection
        $mysqli->close();
    }
    ?>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap.min.css" rel="stylesheet" media="(prefers-color-scheme: light)">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet" media="(prefers-color-scheme: dark)">
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
                    <input type="text" name="pass" class="form-control  my-2" placeholder="Password" id="pass" required>
                    <button type="submit" class="btn btn-success mb-2  my-2">Log in</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>