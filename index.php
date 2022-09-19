<!DOCTYPE html>
<?php
   include('verify_sesh.php');
?>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap.min.css" rel="stylesheet" media="(prefers-color-scheme: light)">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet" media="(prefers-color-scheme: dark)">
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $_SESSION["login_user"]; ?></h1> 
      <h2><a href = "logout.php">Sign Out</a></h2>
   </body>
   
</html>