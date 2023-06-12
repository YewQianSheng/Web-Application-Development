<!DOCTYPE html>
<html>

<head>
    <title>Name_Put</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Question 2</h2>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName"><br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName"><br><br>

        <label for="day">Day:</label>
        <select id="day" name="day">
            <?php
            for ($i = 1; $i <= 31; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>

        <label for="month">Month:</label>
        <select name="month">
            <?php
            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            foreach ($months as $month) {
                echo "<option value='$month'>$month</option>";
            }
            ?>
        </select>

        <label for="year">Year:</label>
        <select id="year" name="year">
            <?php
            $current_year = date('Y');
            for ($i = 1900; $i <= $current_year; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>
        <br><br>


        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];

        if (empty($firstName) || empty($lastName)) {
            echo "<p class='error'>Please enter your name.</p>";
        } else {
            $formattedFirstName = ucwords(strtolower($firstName));
            $formattedLastName = ucwords(strtolower($lastName));

            echo "<h3>Full Name:</h3>";
            echo "$formattedFirstName $formattedLastName";
            $day = $_POST['day'];
            $month = $_POST['month'];
            $year = $_POST['year'];

            $current_year = date('Y');
            $age = $current_year - $year;

            $birthdate = strtotime("$year-$month-$day");
            $age = date('Y') - date('Y', $birthdate);
            if (date('md') < date('md', $birthdate)) {
                $age--;
            }

            echo "<p>$day " . $month . " $year</p>";
            if ($age >= 18) {
                echo "<p>Welcome!You are $age years old.</p>";
            } else {
                echo '<p style="color: red;">Sorry,You are under the age of 18!!</p>';
            }
        }
    }

    ?>
</body>

</html>