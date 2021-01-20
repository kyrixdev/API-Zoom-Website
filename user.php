<?php
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        <?php 
            $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            if ( strpos($url, 'user.php') !== false ) {
                echo('Zoom Meetings | Zoom Node');
            }
        ?>
    </title>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=0" />
<link rel="icon" href="img/icon.png">
<meta name="description" content="">
<meta name="author" content="">

<!-- LINKS -->
<link href="public/styles.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/d70f8cdd06.js" crossorigin="anonymous"></script>

<!-- JS, Popper.js, and jQuery -->
<script>
</script>
</head>
<body>
<main class="container mx-auto";

</body>
</html>