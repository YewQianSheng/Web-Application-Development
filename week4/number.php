<!DOCTYPE html>
<html>

<head>
    <title>Number Sum</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Number Sum</h2>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="number">Number:</label>
        <input type="text" id="number" name="number"><br>

        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $number = $_POST['number'];

        if (empty($number)) {
            echo "<p class='error'>Please fill in a number.</p>";
        } elseif (!is_numeric($number)) {
            echo "<p class='error'>Please enter a valid number.</p>";
        } else {
            $number = (int)$number;
            $sum = 0;

            for ($i = $number; $i >= 1; $i--) {
                $sum += $i;
            }

            echo "<h3>Sum:</h3>";
            echo implode('+', range(1, $number)) . ' = ' . $sum;
        }
    }
    ?>
</body>

</html>