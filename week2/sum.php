<!DOCTYPE html>
<html>

<head>
    <title>Sum ramdom number</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <?php
        $sum = 0;
        $numbers = array();

        for ($num = 1; $num <= 100; $num++) {
            if ($num % 2 == 0) {
                $sum += $num;
                $numbers[] = "<b>$num</b>";
            } else {
                $sum += $num;
                $numbers[] = $num;
            }
        }
        echo implode(" + ", $numbers) . " = " . $sum;
        ?>
    </div>
</body>

</html>