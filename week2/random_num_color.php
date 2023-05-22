<!DOCTYPE html>
<html>

<head>
    <title>Random Numbers & Color</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php
                $number1 = rand(1, 100);
                $number2 = rand(1, 100);
                $same = "same number";
                if ($number1 > $number2) {
                    echo '<span class="bigger text-primary fw-bold fs-2">' . $number1 . '</span> ';
                    echo $number2;
                } else if ($number1 == $number2) {
                    echo $same;
                } else {
                    echo $number1 . ' ';
                    echo '<span class="bigger text-secondary fw-bold fs-2">' . $number2 . '</span>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>