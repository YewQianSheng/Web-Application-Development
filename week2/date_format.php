<!DOCTYPE html>
<html>

<head>
    <title>Date Format</title>
</head>

<body>

    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');

    $date = date('M d, Y (D)');
    $time = date('H:i:s');

    echo '<span style="color: rgb(175,123,81); font-size:30px; font-weight: bold;" ><strong> ' . $date = date('M ') . '</strong></span>';
    echo '<span style="font-size:30px;">' . $date = date('d, Y') . '</span>';
    echo '<span style="color: rgb(7,55,99); font-size:30px;">' . $date = date('(D)') . '</span><br>';
    echo '<span style="font-size:30px;">' . $time . '</span>';
    ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>

</body>

</html>