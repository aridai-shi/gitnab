<!DOCTYPE html>
<?php
$level = "users/edit.php?id=" . $_GET["id"];
include('../verify_sesh.php');

$query = "SELECT * from `users` WHERE id=" . $_GET["id"];
$result = mysqli_query($db, $query) or die("Invalid user ID");
if ($result !== false) {
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else die("Invalid user ID");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gitnab - User edit for <?php echo $row["login"] ?></title>
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
        <h1>Edit user info</h1>
        <form class="d-flex flex-column text-center">
            <div class="form-group">
                <label for="login">Username </label>
                <input type="text" name="login" id="login" value="<?php echo $row["login"] ?>" placeholder="<?php echo $row["login"] ?>" autocomplete="new-password" required>
            </div>
            <div class="form-group">
                <label for="cpass">Current password </label>
                <input type="password" name="cpass" id="cpass" autocomplete="new-password">
                <br>
                <label for="pass">New password </label>
                <input type="password" name="pass" id="pass" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="admin">Is an admin </label>
                <input type="checkbox" name="admin" id="admin" <?php echo ($row['admin'] ? "checked" : ""); ?>>
            </div>
            <div class="form-group">
                <button type="submit" name="action" class="btn btn-success mb-2  my-2" value="save">Save changes</button>
                <button type="submit" name="action" class="btn btn-warning mb-2  my-2" value="res">Reset password</button>
                <button type="submit" name="action" class="btn btn-danger mb-2  my-2" value="delete">Delete user</button>
            </div>
        </form>
        <script>
            const userIsAdmin = <?php if (isset($_SESSION['admin'])) echo ($_SESSION['admin'] ? "true" : "false"); else echo "false";?>;
            const userIsSelf = <?php echo ($row["id"] == $_SESSION["id_user"] ? "true" : "false"); ?>;

            $(document).ready(function() {
                $("form button:submit").click(function() {
                    $("form").data("action", $(this).val())
                })
                $("form").submit(function() {
                    var val = $(this).data("action");
                    console.debug(val)
                    if (val == "save") {
                        update($("#login").val(), $("#cpass").val(), $("#pass").val(), $("#admin").prop('checked'))
                    } else if (val == "delete") {
                        remove(<?php echo "\"{$row["login"]}\",{$row["admin"]}" ?>)
                    } else if (val == "res") {
                        reset();
                    }
                    return false;
                });
                $("form input[type=submit]").click(function() {
                    $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
                    $(this).attr("clicked", "true");
                });
            });

            function update(newLogin, currentPass, newPass, adminVal) {
                var actualCurrentPass = "<?php echo $row['pass'] ?>"; // to avoid unnecessary queries in update.php 
                if (!(userIsAdmin || userIsSelf)) {
                    alert("Only admins can edit other users.")
                    return false;
                }
                if (!(userIsAdmin) && (adminVal!=<?php echo ($row['admin'] ? "true" : "false"); ?>)) {
                    alert("Only admins can promote other users to admin status. Ignoring admin setting.")
                    adminVal = false;
                }
                var url = "update.php";
                var params = "id=" + <?php echo $row["id"]; ?> + "&login=" + newLogin + "&cpass=" + currentPass + "&pass=" + newPass + "&acpass=" + actualCurrentPass + "&admin=" + adminVal;
                var xhr = new XMLHttpRequest();
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onload = function(e) {


                    console.debug(e.target.response)
                    location.reload();
                };
                xhr.onerror = function(e) {
                    console.debug(e)
                }
                xhr.send(params);

                return false;

            }

            function remove(username, adminVal) {
                if (!(userIsAdmin || userIsSelf)) {
                    alert("Only admins can delete other users.")
                    return false;
                }
                var confirm = prompt("Are you sure you want to delete this user? This action cannot be undone. Type in the username to confirm.")
                console.log(confirm)
                const admin = (adminVal == 1);

                if (confirm === username) {
                    if (admin) {
                        if (window.confirm("This user is an administrator. Are you absolutely sure that you wish to delete this account?") !== true) {
                            return false;
                        }
                    }
                    var url = "../deluser.php";
                    var params = "id=" + <?php echo $row["id"]; ?>;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", url, true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onload = function() {
                        location.href = "index.php"
                    };
                    xhr.onerror = function(e) {
                        console.debug(e)
                    }
                    xhr.send(params);
                } else if (confirm != null) {
                    alert("Incorrect username.")
                }
                return false;
            }

            function reset() {
                var actualCurrentPass = "<?php echo $row['pass'] ?>"; // to avoid unnecessary queries in update.php 
                if (!(userIsAdmin || userIsSelf)) {
                    alert("Only admins can edit other users.")
                    return false;
                }
                var url = "update.php";
                var params = "id=" + <?php echo $row["id"]; ?> + "&respass=true";
                var xhr = new XMLHttpRequest();
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onload = function(e) {
                    console.debug(e.target.response);
                    location.reload();
                };
                xhr.onerror = function(e) {
                    console.debug(e)
                }
                xhr.send(params);

                return false;

            }
        </script>
    </div>
</body>

</html>