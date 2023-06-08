<!DOCTYPE html>
<html>

<head>
    <title>Number Adder</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Number Adder</h2>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="number1">Number 1:</label>
        <input type="text" id="number1" name="number1"><br>

        <label for="number2">Number 2:</label>
        <input type="text" id="number2" name="number2"><br>

        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $number1 = $_POST['number1'];
        $number2 = $_POST['number2'];

        if (empty($number1) || empty($number2)) {
            echo "<p class='error'>Please fill in a number.</p>";
        } elseif (!is_numeric($number1) || !is_numeric($number2)) {
            echo "<p class='error'>Please enter valid numbers.</p>";
        } else {
            $sum = $number1 + $number2;

            echo "<h3>Sum:</h3>";
            echo $sum;
        }
    }
    ?>
</body>

</html>