<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Shorten a URL.</h1>

        <?php
            if(isset($_SESSION['feedback'])) {
                echo "<p>{$_SESSION['feedback']}</p>";
                unset($_SESSION['feedback']);
            }
        ?>

        <form action="shorten.php" method="POST">
            <input type="url" name="url" placeholder="Enter a URL here." autocomplete="off">
            <input type="submit" value="Shorten">
        </form>
    </div>
</body>
</html>