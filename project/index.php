<?php include "session.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Home</title>
</head>

<body>
    <div class="container">
        <?php
        include 'navbar/menu_nav.php';
        ?>

        <div class="welcome py-5 text-left">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-4">Welcome to Company Name</h1>
                    <p class="lead">We provide innovative solutions for your business.</p>
                    <a href="#contact" class="btn btn-primary btn-lg">Get in touch</a>
                </div>
            </div>
        </div>


        <div class="container col-lg-auto text-left mx-auto bg-light">
            <h2>About Us</h2>
            <p>~~</p>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>