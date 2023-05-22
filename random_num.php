<!DOCTYPE html>
<html>

<head>
    <title>random_num</title>
    <link rel="stylesheet" type="text/css" href="random_num.css">
</head>

<body>
    <?php
    $number1 = rand(100, 200);
    $number2 = rand(100, 200);
    $sum = $number1 + $number2;
    $multiplication = $number1 * $number2;
    ?>
    <p class="italic green"><?php echo $number1; ?></p>
    <p class="italic blue"><?php echo $number2; ?></p>
    <p class="bold red"><?php echo $sum; ?></p>
    <p class="bold italic "><?php echo $multiplication; ?></p>
</body>

</html>