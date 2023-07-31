<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php include 'navbar/menu_nav.php' ?>
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        include 'config/database.php';

        try {
            $query = "SELECT id, username, password, first_name, last_name, gender, birth, email, status FROM customer WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $username = $row['username'];
            $password = $row['password'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $gender = $row['gender'];
            $birth = $row['birth'];
            $email = $row['email'];
            $status = $row['status'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        if ($_POST) {
            try {
                $query = "UPDATE customer
                SET username=:username, first_name=:first_name, last_name=:last_name, gender=:gender, birth=:birth, email=:email,
               status=:status";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                $gender = $_POST['gender'];
                $birth = $_POST['birth'];
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $status = $_POST['status'];

                $error = array();
                if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
                    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password)) {
                        $errors[] = "Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one number.";
                    }
                    if ($new_password == $confirm_password) {
                    } else {
                        $error[] = "The confirm password doesn't match with new password.";
                    }
                    if (password_verify($old_password = $password, $password)) {
                    } else {
                        $error[] = "Wrong password entered in old password column";
                    }
                    if ($old_password == $new_password) {
                        $error[] = "New Password can't be same with Old Password";
                    } else {
                        $formatted_password = $new_password;
                    }
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error[] = "Invalid Email format.";
                }

                if (!empty($error)) {
                    echo "<div class='alert alert-danger m-3'>";
                    foreach ($error as $errorMessage) {
                        echo $errorMessage . "<br>";
                    }
                    echo "</div>";
                } else {
                    if (isset($formatted_password)) {
                        $query .= ", password=:password";
                    }

                    $query .= " WHERE id = :id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birth', $birth);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':status', $status);
                    if (isset($formatted_password)) {
                        $stmt->bindParam(':password', $formatted_password);
                    }

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>ERROR: " . $exception->getMessage() . "</div>";
            }
        } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>User Name</td>
                    <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td>
                        <input type="password" name="old_password" class="form-control" placeholder="Old Password" value="<?php isset($_POST['old_password']) ? $_POST['old_password'] : '' ?>">
                    </td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td>
                        <input type="password" name="new_password" class="form-control" placeholder="New Password" value="<?php isset($_POST['new_password']) ? $_POST['new_password'] : '' ?>">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>">
                    </td>
                </tr>

                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>

                    <td>

                        <select class="form-select" id="gender" name="gender">
                            <option value="Male" <?php if ($row['gender'] == "Male") {
                                                        echo 'selected';
                                                    } ?>>Male</option>
                            <option value="Female" <?php if ($row['gender'] == "Female") {
                                                        echo 'selected';
                                                    } ?>>Female</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><input type='date' name='birth' value="<?php echo htmlspecialchars($birth, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type='text' name='status' value="<?php echo htmlspecialchars($status, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>