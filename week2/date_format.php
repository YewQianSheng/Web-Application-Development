<!DOCTYPE html>
<html>

<body>

    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');

    $today = date('M d, Y (D)');
    $current_time = date('H:i:s');

    echo $today . '<br>' . $current_time;

    ?>


</body>

</html>