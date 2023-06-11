<!DOCTYPE html>
<html>

<head>
    <title>Star</title>
</head>

<body>
    <?php
    for ($i = 10; $i >= 1; $i--) {
        for ($j = 1; $j <= $i; $j++) {
            echo "*";
        }
        echo '<br>';
    }
    ?>

</body>

</html>