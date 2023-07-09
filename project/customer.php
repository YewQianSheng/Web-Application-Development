<!DOCTYPE HTML>
<html>

<head>
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        include 'menu_nav.php';
        ?>
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        date_default_timezone_set('asia/Kuala_Lumpur');
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO customer SET username=:username, password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, birth=:dob, status=:status , registration_date=:registration";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $dob_day = $_POST['dob_day'];
                $dob_month = $_POST['dob_month'];
                $dob_year = $_POST['dob_year'];
                $status = $_POST['status'];


                $formattedFirstName = ucwords(strtolower($first_name));
                $formattedLastName = ucwords(strtolower($last_name));
                $formattedgender = ucwords(strtolower($gender));
                $errors = [];
                if (!preg_match('/^[a-zA-Z][a-zA-Z0-9 ]{5,}$/', $username)) {
                    $errors[] = "Invalid username format.";
                }

                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password)) {
                    $errors[] = "Invalid password format.";
                }

                if ($password !== $confirm_password) {
                    $errors[] = "Passwords do not match.";
                }
                if (empty($first_name)) {
                    $errors[] = "First name is required.";
                }

                if (empty($last_name)) {
                    $errors[] = "Last name is required.";
                }

                if (empty($gender)) {
                    $errors[] = "Gender is required.";
                }

                if (empty($dob_day) || empty($dob_month) || empty($dob_year)) {
                    $errors[] = "Date of birth is required.";
                }

                if (empty($status)) {
                    $errors[] = 'Account status is required.';
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger m-3'>";
                    foreach ($errors as $displayError) {
                        echo $displayError . "<br>";
                    }
                    echo "</div>";
                } else {
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $dob = $dob_year . '-' . $dob_month . '-' . $dob_day;
                    $stmt->bindParam(':dob', $dob);
                    $stmt->bindParam(':status', $status);
                    $registration = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':registration', $registration);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            } // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }


        ?>
        <h1>Registration Form</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" pattern="[a-zA-Z][a-zA-Z0-9 ]{5,}" title="Username must start with a letter, and cannot have numbers, underscore, or hyphen.">

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$" title="Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one number.">

            </div>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm_password" value="<?php echo isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ''; ?>">

            </div>
            <div class="mb-3">
                <label for="first-name" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="first-name" name="first_name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">

            </div>
            <div class="mb-3">
                <label for="last-name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="last-name" name="last_name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label>
                <select class="form-select" id="gender" name="gender" require>
                    <option value="" selected disabled>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="dob-day" class="form-label">Date of Birth:</label>
                <div class="row">
                    <div class="col">
                        <select class="form-select" id="dob-day" name="dob_day" required>
                            <option value="" selected disabled>Select Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                echo "<option value=\"$day\">$day</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="dob-month" name="dob_month" required>
                            <option value="" selected disabled>Select Month</option>
                            <?php
                            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                            foreach ($months as $x => $month) {
                                $indexmonth = $x + 1;
                                echo "<option value = '$indexmonth'>$month</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="dob-year" name="dob_year" required>
                            <option value="" selected disabled>Select Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = 1900; $year <= $currentYear; $year++) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="" selected disabled>Select Status</option>
                    <option value="active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>