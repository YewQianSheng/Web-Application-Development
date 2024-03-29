<?php include "session.php" ?>
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
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $birth = $_POST['birth'];
                $status = $_POST['status'];
                $email = $_POST['email'];
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));
                // upload to file to folder
                $target_file = "";
                $errors = array();

                // now, if image is not empty, try to upload the image
                if ($image) {

                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    //pathinfo找是不是.jpg,.png
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['image']['size'] > (524288)) {
                        $errors[] = "<div>Image must be less than 512 KB in size.</div>";
                    }
                    if ($check == false) {
                        // make sure that file is a real image
                        $errors[] = "<div>Submitted file is not an image.</div>";
                    }
                    // make sure certain file types are allowed
                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $errors[] = "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    } else {
                        $image_width = $check[0];
                        $image_height = $check[1];
                        if ($image_width != $image_height) {
                            $errors[] = "Only square size image allowed.";
                        }
                    }
                    // make sure file does not exist
                    if (file_exists($target_file)) {
                        $errors[] = "<div>Image already exists. Try to change file name.</div>";
                    }
                }
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                if (empty($username)) {
                    $errors[] = "Username is required.";
                } elseif (!preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) {
                    $errors[] = "Username must start with a letter, and can have numbers, underscore, or hyphen.";
                }

                if (empty($password)) {
                    $errors[] = "Password is required.";
                } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password)) {
                    $errors[] = "Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one number.";
                }

                if ($password !== $confirm_password) {
                    $errors[] = "Passwords do not match.";
                }


                if (empty($gender)) {
                    $errors[] = "Gender is required.";
                }

                if (empty($first_name)) {
                    $errors[] = "First name is required";
                } elseif (preg_match('/\d/', $first_name)) {
                    $errors[] = 'First name cannot contain numbers';
                }

                if (empty($last_name)) {
                    $errors[] = "Last name is required";
                } elseif (preg_match('/\d/', $last_name)) {
                    $errors[] = 'Last name cannot contain numbers';
                }

                if (empty($email)) {
                    $errors[] = "Email is required.";
                }

                if (empty($birth)) {
                    $errors[] = "Date of birth is required.";
                }

                if ($birth > date('Y-m-d')) {
                    $errors[] = "Date of birth cannot be greater than the current date.";
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
                    $query = "INSERT INTO customer SET username=:username, password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, birth=:birth, status=:status , registration_date=:registration, email=:email, image=:image";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
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
                    $stmt->bindParam(':image', $target_file);
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";

                        if ($image) {


                            // make sure the 'uploads' folder exists
                            // if not, create it
                            if (!is_dir($target_directory)) {
                                mkdir($target_directory, 0777, true);
                            }
                            // if $file_upload_error_messages is still empty
                            if (empty($file_upload_error_messages)) {
                                // it means there are no errors, so try to upload the file
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    // it means photo was uploaded
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<div>Unable to upload photo.</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                    echo "</div>";
                                }
                            } else {
                                // it means there are some errors, so show them to user
                                echo "<div class='alert alert-danger'>";
                                echo "<div>{$file_upload_error_messages}</div>";
                                echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }
                        $_POST = array();
                    }
                    // bind the parameters
                    // insert query

                    // Execute the query
                    else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }

            // show error
            catch (PDOException $exception) {
                // die('ERROR: ' . $exception->getMessage());
                if ($exception->getCode() === 23000) {
                    var_dump($username);
                    echo '<div class= "alert alert-danger role=alert">' . 'Username or email has been taken' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        }
        ?>
        <h1>Registration Form</h1>
        <form method="post" action="" enctype="multipart/form-data">
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
                    <option value="Male" checked>Male</option>
                    <option value="Female">Female</option>
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
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label><br>
                <input type="file" class="form-control" name="image" accept="image/*" />
            </div>


            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>