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
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        if (checkdate(array_search($month, $months) + 1, $day, $year)) {
            $zodiacs = array(
                "Rat", "Cow", "Tiger", "Rabbit", "Dragon", "Snake", "Horse",
                "Sheep", "Monkey", "Chicken", "Dog", "Pig"
            );

            $calculate = ($year - 1900) % 12;
            $zodiac = $zodiacs[$calculate];

            $month = array_search($month, $months) + 1;
            $westernZodiac = "";

            if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
                $westernZodiac = "Aries";
            } elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
                $westernZodiac = "Taurus";
            } elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
                $westernZodiac = "Gemini";
            } elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
                $westernZodiac = "Cancer";
            } elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
                $westernZodiac = "Leo";
            } elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
                $westernZodiac = "Virgo";
            } elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
                $westernZodiac = "Libra";
            } elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
                $westernZodiac = "Scorpio";
            } elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
                $westernZodiac = "Sagittarius";
            } elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) {
                $westernZodiac = "Capricorn";
            } elseif (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
                $westernZodiac = "Aquarius";
            } elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
                $westernZodiac = "Pisces";
            }

            echo "<p>Your Birth is:  $day /" . $month . "/ $year</p>";
            echo "<p>Your 12 Chinese zodiac is: $zodiac</p>";
            echo "<p>Your Western zodiac is: $westernZodiac</p>";
        } else {
            echo "<p>Invalid date entered. Please check your input and try again.</p>";
        }
    }
    ?>
</body>

</html>