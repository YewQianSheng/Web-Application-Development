<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col text-primary">
                <label for="daySelect">Day:</label>
                <select class="form-select " id="daySelect">
                    <?php
                    for ($day = 1; $day <= 31; $day++) {
                        echo "<option value='$day'>$day</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col text-warning">
                <label for="monthSelect">Month:</label>
                <select class="form-select " id="monthSelect">
                    <?php
                    for ($month = 1; $month <= 12; $month++) {
                        echo "<option value='$month'>$month</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col text-danger">
                <label for="yearSelect">Year:</label>
                <select class="form-select" id="yearSelect">
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