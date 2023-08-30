<?php include "session.php" ?>
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
            $query = "SELECT id, username, password, first_name, last_name, gender, birth, email, status,image FROM customer WHERE id = ? LIMIT 0,1";
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
            $image = $row['image'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        if ($_POST) {
            try {
                if (isset($_POST['delete_image'])) {
                    $empty = "";
                    $delete_query = "UPDATE customer
                    SET image=:image  WHERE customer.id = :id";
                    $delete_stmt = $con->prepare($delete_query);
                    $delete_stmt->bindParam(":image", $empty);
                    $delete_stmt->bindParam(":id", $id);
                    $delete_stmt->execute();
                    unlink($image);
                    echo "<script>
                    window.location.href = 'customer_read_one.php?id={$id}&action=record_updated';
                  </script>";
                } else {

                    $query = "UPDATE customer
               SET first_name=:first_name, last_name=:last_name, gender=:gender, birth=:birth, email=:email,
               status=:status,image=:image";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // posted values
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];
                    $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                    $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                    $gender = $_POST['gender'];
                    $birth = $_POST['birth'];
                    $email = htmlspecialchars(strip_tags($_POST['email']));
                    $status = $_POST['status'];
                    $image = !empty($_FILES["image"]["name"])
                        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                        : "";
                    $image = htmlspecialchars(strip_tags($image));
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    //pathinfo找是不是.jpg,.png
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                    $error = array();

                    if ($image) {
                        $check = getimagesize($_FILES["image"]["tmp_name"]);

                        // make sure submitted file is not too large, can't be larger than 1 MB
                        if ($_FILES['image']['size'] > (524288)) {
                            $error[] = "<div>Image must be less than 512 KB in size.</div>";
                        }
                        if ($check == false) {
                            // make sure that file is a real image
                            $error[] = "<div>Submitted file is not an image.</div>";
                        }
                        // make sure certain file types are allowed
                        $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                        if (!in_array($file_type, $allowed_file_types)) {
                            $error[] = "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                        } else {
                            $image_width = $check[0];
                            $image_height = $check[1];
                            if ($image_width != $image_height) {
                                $error[] = "Only square size image allowed.";
                            }
                        }
                        // make sure file does not exist
                        if (file_exists($target_file)) {
                            $error[] = "<div>Image already exists. Try to change file name.</div>";
                        }
                    }
                    if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
                        // Password format validation
                        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[-+$()%@#]).{6,}$/', $new_password)) {
                            $error[] = 'Invalid new password format.';
                        } else {
                            if ($new_password == $confirm_password) {
                                if (password_verify($old_password, $password)) {
                                    if ($old_password == $new_password) {
                                        $error[] = "New password can't be the same as the old password.";
                                    } else {
                                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                                    }
                                } else {
                                    $error[] = "Wrong password entered in the old password column.";
                                }
                            } else {
                                $error[] = "The confirm password doesn't match the new password.";
                            }
                        }
                    } else {
                        $hashed_password = $password;
                    }

                    if (empty($first_name)) {
                        $error[] = "First name is required";
                    } elseif (preg_match('/\d/', $first_name)) {
                        $error[] = 'First name cannot contain numbers';
                    }

                    if (empty($last_name)) {
                        $error[] = "Last name is required";
                    } elseif (preg_match('/\d/', $last_name)) {
                        $error[] = 'Last name cannot contain numbers';
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error[] = "Invalid Email format.";
                    }

                    if ($birth >= date('Y-m-d')) {
                        $error[] = "Date of birth cannot be greater/same than the current date.";
                    }

                    if (!empty($error)) {
                        echo "<div class='alert alert-danger m-3'>";
                        foreach ($error as $errorMessage) {
                            echo $errorMessage . "<br>";
                        }
                        echo "</div>";
                    } else {
                        if (isset($hashed_password)) {
                            $query .= ", password=:password";
                        }
                        $query .= " WHERE id=:id";
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':id', $id);
                        if (isset($hashed_password)) {
                            $stmt->bindParam(':password', $hashed_password);
                        }

                        $stmt->bindParam(':first_name', $first_name);
                        $stmt->bindParam(':last_name', $last_name);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':birth', $birth);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':status', $status);

                        if ($image == "") {
                            $stmt->bindParam(":image", $row['image']);
                        } else {
                            $stmt->bindParam(':image', $target_file);
                        }
                        // Execute the query
                        if ($stmt->execute()) {

                            echo "<script>
                            window.location.href = 'customer_read_one.php?id={$id}&action=record_updated';
                          </script>";
                            if ($image) {
                                if ($target_file !=  $row['image'] && $row['image'] != "") {
                                    unlink($row['image']);
                                }

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
                                }
                                // if $file_upload_error_messages is NOT empty
                                else {
                                    // it means there are some errors, so show them to user
                                    echo "<div class='alert alert-danger'>";
                                    echo "<div>{$file_upload_error_messages}</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                    echo "</div>";
                                }
                            }
                            //     echo "<script>
                            //     window.location.href = 'customer_read_one.php?id={$id}';
                            //   </script>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                if ($exception->getCode() == 23000) {
                    echo '<div class= "alert alert-danger role=alert">' . 'Email has been taken. Please provide other email ' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>User Name</td>
                    <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
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
                        <input type="radio" name="gender" id="gender" value="Male" <?php if ($row['gender'] == "Male") {
                                                                                        echo 'checked';
                                                                                    } ?>>
                        <label class="form-check-label" for="active">Male</label>
                        <input type="radio" name="gender" id="gender" value="Female" <?php if ($row['gender'] == "Female") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label class="form-check-label" for="gender">Female</label>
                    </td>



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
                    <td>
                        <input type="radio" name="status" id="active" value="Active" <?php if ($row['status'] == "Active") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label class="form-check-label" for="active">Active</label>
                        <input type="radio" name="status" id="inactive" value="Inactive" <?php if ($row['status'] == "Inactive") {
                                                                                                echo 'checked';
                                                                                            } ?>>
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td>
                        <?php
                        if ($image == "") {
                            echo '<img src="image/customer_img.jpg" alt="image" width="100"> <br>';
                            echo '<input type="file" name="image" />';
                        } else {
                            echo '<img src="' . ($image) . '"width="100"> <br>';
                            echo '<input type="file" name="image" />';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <?php if ($image != "") { ?>
                            <input type="submit" value="Delete Image" class="btn btn-danger" name="delete_image">
                        <?php } ?>
                        <a href='customer_read.php' class='btn btn-info'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>