<!DOCTYPE html>
<?php
include('verify_sesh.php');
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gitnab - <?php echo $_SESSION['login_user'] ?>'s dashboard</title>
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>

<body>
    <div class="h-100 d-flex flex-column align-items-center align-content-center justify-content-center pt-4 text-center">
        <div class="table-responsive" id="your-repos">
            <h1>Your repositories:</h1>
            <br>
            <?php
            $error = "";
            $q1 = "SELECT `id` FROM `users` WHERE `login` = '" . $_SESSION['login_user'] . "';";
            $result = mysqli_query($db, $q1);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (isset($row)) {
                $id = $row["id"];
                $q2 = "SELECT `id`,`title`, `author`,`description` FROM `repos` WHERE `author` =" . $id . ";";
                $result2 = mysqli_query($db, $q2);
                echo "<form action='new_repo.php' id='new_repo_form' method='post'>
                <table class='table table-dark table-bordered table-striped '>
                <tr>
                    <th>Repository</th>
                    <th>Description</th>
                </tr>";
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr>
                        <td>{$_SESSION['login_user']} / {$row["title"]}</td>
                        <td>{$row["description"]}</td>
                    </tr>";
                }
                echo "<tr>
                    <td><p class='d-inline-block'>{$_SESSION['login_user']} / <input name='title' id='nr-title' type='textbox' class='form-control d-inline w-75 py-1 lh-1' required></p></td>
                    <td><input type='textbox' id='nr-desc' name='description' class='form-control mw-50 py-1 lh-1'></td>
                </tr>";
                echo "
                </form>
                </table>";
                echo "<script>
                $('#nr-title, #nr-desc').keypress(function(event){
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if(keycode == '13'){
                        document.getElementById('new_repo_form').submit()
                    }
                });
             </script>";
            };
            if (isset($_GET["nr"])) {
                echo "<p>Currently, commits aren't available yet.</p>";
            }
            ?>
        </div>
        <div id="your_prs">
            <h1>Your unresolved pull requests:</h1>
            <?php
            $error = "";
            $q1 = "SELECT `id` FROM `users` WHERE `login` = '" . $_SESSION['login_user'] . "';";
            $result = mysqli_query($db, $q1);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (isset($row)) {
                $id = $row["id"];
                $q2 = "SELECT `id`,`title`, `author`,`description`,`branch`,`merge_into`,`auto_merge` FROM `pull_requests` WHERE `resolved`=0 AND `author` =" . $id . ";";
                $result2 = mysqli_query($db, $q2);
                echo
                "<table class='table table-dark table-bordered table-striped '>
                <tr>
                    <th>Branch to merge</th>
                    <th>PR Name</th>
                    <th>Description</th>
                    <th>Can auto-merge?</th>
                </tr>";
                while ($row = mysqli_fetch_assoc($result2)) {
                    $q3 = "SELECT `users`.`login`, `repos`.`title`, `branches`.`name` FROM `users` JOIN `repos` ON `repos`.`author`=`users`.`id` JOIN `branches` ON `branches`.`repo`=`repos`.`id` JOIN `pull_requests` ON `pull_requests`.`branch` = `branches`.`id` WHERE `pull_requests`.`author`=" . $id . ";";
                    $result3 = mysqli_query($db, $q3);
                    $details = mysqli_fetch_assoc($result3);
                    $am = ($row['auto_merge'] == 1) ? '✔' : '❌';
                    echo "<tr>
                        <td>{$details["login"]} / {$details["title"]} / {$details["name"]}</td>
                        <td>{$row["title"]}</td>
                        <td>{$row["description"]}</td>
                        <td>{$am}</td>
                    </tr>";
                }
                echo "</table>";
            };
            ?>
        </div>
        <footer class="text-right link-warning fluid-container p-4">
            <script>
                function confirm_del() {
                    var confirm = prompt("Are you sure you want to delete this user? This action cannot be undone. Type in the username to confirm.")
                    console.log(confirm)
                    const validate = "<?php echo $_SESSION['login_user'] ?>"
                    const admin = <?php if (isset($_SESSION['admin'])) echo ($_SESSION['admin'] ? "true" : "false"); ?>;

                    if (confirm === validate) {
                        if (admin) {
                            if (window.confirm("You are an administrator. Are you absolutely sure that you wish to delete your own account?") !== true) {
                                return false;
                            }
                        }
                        var url = "deluser.php";
                        var params = "id=" + <?php if (isset($_SESSION['admin'])) echo $id;
                                                else echo -1 ?>;
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", url, true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.onload = function() {
                            location.href = "logout.php?del"
                        };
                        xhr.send(params);
                    } else if (confirm != null) {
                        alert("Incorrect username.")
                    }
                    return false;
                }
            </script>
            <a class="btn btn-warning" href="./logout.php">Log out</a>
            <a class="btn btn-danger" onclick="return confirm_del()">Delete user</a>
            <br>
            <br>
            <a class="btn btn-primary" href="users/index.php">Visit user list</a>
        </footer>
    </div>
</body>

</html>