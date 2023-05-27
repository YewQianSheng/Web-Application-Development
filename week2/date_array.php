<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <label for="daySelect">Day:</label>
                <select class="form-select bg-lightblue" id="daySelect">
                    <?php
                    for ($day = 1; $day <= 31; $day++) {
                        echo "<option value='$day'>$day</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="monthSelect">Month:</label>
                <select class="form-select bg-yellow" id="monthSelect">
                    <?php
                    $months = array(
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    );
                    foreach ($months as $key => $month) {
                        $monthIndex = $key + 1;
                        echo "<option value='$monthIndex'>$month</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="yearSelect">Year:</label>
                <select class="form-select bg-red" id="yearSelect">
                    <?php
                    $currentYear = date('Y');
                    for ($year = 1900; $year <= $currentYear; $year++) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</body>

</html>