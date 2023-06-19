<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zodiac</title>
</head>

<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
            foreach ($months as $x => $month) {
                $indexmonth = $x + 1;
                echo "<option value = '$indexmonth'>$month</option>";
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
        $day = $_POST['day'];
        $months = $_POST['month'];
        $year = $_POST['year'];
        if (checkdate($months, $day, $year)) {
            $zodiacs = array(
                "Rat", "Cow", "Tiger", "Rabbit", "Dragon", "Snake", "Horse",
                "Sheep", "Monkey", "Chicken", "Dog", "Pig"
            );

            $calculate = ($year - 1900) % 12;
            $zodiac = $zodiacs[$calculate];

            $westernZodiac = "";
            if (($months == 3 && $day >= 21) || ($months == 4 && $day <= 19)) {
                $westernZodiac = "Aries";
            } elseif (($months == 4 && $day >= 20) || ($months == 5 && $day <= 20)) {
                $westernZodiac = "Taurus";
            } elseif (($months == 5 && $day >= 21) || ($months == 6 && $day <= 20)) {
                $westernZodiac = "Gemini";
            } elseif (($months == 6 && $day >= 21) || ($months == 7 && $day <= 22)) {
                $westernZodiac = "Cancer";
            } elseif (($months == 7 && $day >= 23) || ($months == 8 && $day <= 22)) {
                $westernZodiac = "Leo";
            } elseif (($months == 8 && $day >= 23) || ($months == 9 && $day <= 22)) {
                $westernZodiac = "Virgo";
            } elseif (($months == 9 && $day >= 23) || ($months == 10 && $day <= 22)) {
                $westernZodiac = "Libra";
            } elseif (($months == 10 && $day >= 23) || ($months == 11 && $day <= 21)) {
                $westernZodiac = "Scorpio";
            } elseif (($months == 11 && $day >= 22) || ($months == 12 && $day <= 21)) {
                $westernZodiac = "Sagittarius";
            } elseif (($months == 12 && $day >= 22) || ($months == 1 && $day <= 19)) {
                $westernZodiac = "Capricorn";
            } elseif (($months == 1 && $day >= 20) || ($months == 2 && $day <= 18)) {
                $westernZodiac = "Aquarius";
            } elseif (($months == 2 && $day >= 19) || ($months == 3 && $day <= 20)) {
                $westernZodiac = "Pisces";
            }

            echo "<p>Your Birth is:  $day /" . $months . "/ $year</p>";
            echo "<p>Your 12 Chinese zodiac is: $zodiac</p>";
            echo "<p>Your Western zodiac is: $westernZodiac</p>";
        } else {
            echo "<p>Invalid date entered. Please check your input and try again.</p>";
        }
    }
    ?>
</body>

</html>