<!DOCTYPE HTML>
<html>

<head>
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        include 'navbar/menu_nav.php';
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
                $query = "INSERT INTO customer SET username=:username, password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, birth=:birth, status=:status , registration_date=:registration, email=:email";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $birth = $_POST['birth'];
                $status = $_POST['status'];
                $email = $_POST['email'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);


                $formattedFirstName = ucwords(strtolower($first_name));
                $formattedLastName = ucwords(strtolower($last_name));
                $formattedgender = ucwords(strtolower($gender));
                $errors = [];

                if (empty($username)) {
                    $errors[] = "username is required.";
                } elseif (!preg_match('/^[a-zA-Z][a-zA-Z0-9]{5,}$/', $username)) {
                    $errors[] = "Username must start with a letter, and cannot have numbers, underscore, or hyphen.";
                }

                if (empty($password)) {
                    $errors[] = "password is required.";
                } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password)) {
                    $errors[] = "Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one number.";
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

                if (empty($email)) {
                    $errors[] = "email is required.";
                }

                if (empty($birth)) {
                    $errors[] = "Date of birth is required.";
                }

                if (empty($status)) {
                    $errors[] = 'Account status is required.';
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid email format.";
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
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birth', $birth);
                    $stmt->bindParam(':status', $status);
                    $registration = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':registration', $registration);
                    $stmt->bindParam(':email', $email);
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
                // die('ERROR: ' . $exception->getMessage());
                if ($exception->getCode() == 23000) {
                    echo '<div class= "alert alert-danger role=alert">' . 'Username has been taken' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        }


        ?>
        <h1>Registration Form</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">

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
                <select class="form-select" id="gender" name="gender">
                    <option value="male" checked>Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date of Birth:</label>
                <input type='date' name='birth' class='form-control' value="<?php echo isset($_POST['birth']) ? $_POST['birth'] : ''; ?>" />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-select" id="status" name="status">

                    <option value="active" checked>Active</option>
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