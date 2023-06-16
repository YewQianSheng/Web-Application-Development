<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dob_day = $_POST['dob_day'];
        $dob_month = $_POST['dob_month'];
        $dob_year = $_POST['dob_year'];
        $gender = $_POST['gender'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $email = $_POST['email'];
        $formattedFirstName = ucwords(strtolower($first_name));
        $formattedLastName = ucwords(strtolower($last_name));
        $formattedgender = ucwords(strtolower($gender));
        $errors = [];

        if (empty($first_name)) {
            $errors[] = "First name is required.";
        }

        if (empty($last_name)) {
            $errors[] = "Last name is required.";
        }

        if (empty($dob_day) || empty($dob_month) || empty($dob_year)) {
            $errors[] = "Date of birth is required.";
        }

        if (empty($gender)) {
            $errors[] = "Gender is required.";
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_-]{5,}$/', $username)) {
            $errors[] = "Invalid username format.";
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password)) {
            $errors[] = "Invalid password format.";
        }

        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (!empty($errors)) {
            echo '<h2>Error:</h2>';
            foreach ($errors as $error) {
                echo  $error;
            }
            echo '<a href="registration.php">Go back to the registration form</a>';
            exit;
        } else {
            echo "<h2>Register Successful!</h2>";
            echo "<p><strong>First Name:</strong> $formattedFirstName</p>";
            echo "<p><strong>Last Name:</strong>$formattedLastName </p>";
            echo "<p><strong>Date of Birth:</strong> $dob_day $dob_month $dob_year</p>";
            echo "<p><strong>Gender:</strong> $formattedgender</p>";
            echo "<p><strong>Username:</strong> $username</p>";
            echo "<p><strong>Email:</strong> $email</p>";
        }
    } else {
        header("Location: registration.php");
        exit();
    }
    ?>

</body>

</html>