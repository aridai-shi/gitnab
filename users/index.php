<!DOCTYPE html>
<?php
$level = "users/index.php";
include('../verify_sesh.php');
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gitnab - Users</title>
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
    <h1>User list</h1>    
    <div class="table-responsive" id="users">
            <table class="table-dark table-striped table-bordered table">
                <tr>
                    <th>User ID</th>
                    <th>Login</th>
                    <th>Repositories</th>
                    <th>Is an admin?</th>
                    <th>Actions</th>
                </tr>
                <?php
                    $q1 = "SELECT * from `users`";
                    $result = mysqli_query($db, $q1);
                    if ($result!==false) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $am = ($row['admin'] == 1) ? '✔' : '❌';
                            $q2 = "SELECT repos.title, users.login FROM repos JOIN users ON repos.author=users.id WHERE users.id=".$row['id'];
                            $result2 = mysqli_query($db, $q2);
                            $repoList="";
                            if ($result2!==false) {
                                while ($repo = mysqli_fetch_assoc($result2)) {
                                    $repoList .= $repo["login"]."/".$repo["title"].", ";
                                }
                                $repoList=substr($repoList, 0, -2);
                            }
                            echo "<tr>
                                <td>{$row["id"]}</td>
                                <td>{$row["login"]}</td>
                                <td>{$repoList}</td>
                                <td>{$am}</td>
                                <td>
                                    <button onclick='edit({$row['id']})' class='btn btn-primary'>Change info</button>
                                    <button onclick=\"remove({$row['id']},'{$row['login']}',{$row['admin']})\" class='btn btn-danger'>Delete this user</button>
                                </td>
                            </tr>";
                        }
                    }                    
                ?>
            </table>
            <script>
                const userIsAdmin = <?php if (isset($_SESSION['admin']))echo ($_SESSION['admin']?"true":"false");?>;
                function edit(id){
                    window.location.href = "edit.php?id="+id
                }
                function remove(id,username,adminVal) {
                    if (!userIsAdmin){
                        alert("Only admins can delete other users.")
                        return false;
                    }
                    var confirm = prompt("Are you sure you want to delete this user? This action cannot be undone. Type in the username to confirm.")
                    console.log(confirm)
                    const admin = (adminVal==1);
                    
                    if (confirm === username) {
                        if (admin){
                            if (window.confirm("This user is an administrator. Are you absolutely sure that you wish to delete this account?")!==true){
                                return false;
                            }
                        }
                        var url = "../deluser.php";
                        var params = "id="+id;
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", url, true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.onload = function(){location.reload()};
                        xhr.onerror = function(e){console.debug(e)}
                        xhr.send(params);
                    } else if (confirm != null) {
                        alert("Incorrect username.")
                    }
                    return false;
                }
            </script>
        </div>
</body>

</html>