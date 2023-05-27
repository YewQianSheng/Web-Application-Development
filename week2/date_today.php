<!DOCTYPE html>
<html>

<body>

    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $today = date('Y-m-d');
    $year_today = date('Y');
    $month_today = date('m');
    $day_today = date('d');

    $days = range(1, 31);
    $months = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    ];
    $years = range($year_today - 10, $year_today + 10);
    echo '<form>';
    echo 'Day: <select name="day">';
    foreach ($days as $day) {
        $selected = ($day == $day_today) ? 'selected' : '';
        echo '<option value="' . $day . '"' . $selected . '>' . $day . '</option>';
    }
    echo '</select>';

    echo 'Month: <select name="month">';
    foreach ($months as $key => $month) {
        $selected = ($key == $month_today) ? 'selected' : '';
        echo '<option value="' . $key . '"' . $selected . '>' . $month . '</option>';
    }
    echo '</select>';

    echo 'Year: <select name="year">';
    foreach ($years as $year) {
        $selected = ($year == $year_today) ? 'selected' : '';
        echo '<option value="' . $year . '"' . $selected . '>' . $year . '</option>';
    }
    echo '</select>';

    echo '</form>';
    ?>

</body>

</html>