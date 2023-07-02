<!DOCTYPE HTML>
<html>

<head>
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        include 'menu_nav.php';
        ?>
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO contact SET name=:name, description=:description, email=:email  ";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $name = $_POST['name'];
                $description = $_POST['description'];
                $email = $_POST['email'];

                if (!preg_match('/^[a-zA-Z][a-zA-Z0-9 ]{5,}$/', $name)) {
                    $errors[] = "Invalid username format.";
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
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':email', $email);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }   // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>
        <h1>Contact Form</h1>
        <!-- Contact form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' pattern='^[A-Za-z\s]+$' value=" <?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" title='Please enter a valid name (letters and spaces only).' /></td>

                </tr>
                <tr>
                    <td>email</td>
                    <td> <input type="email" class="form-control" id="email" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" name="email"></td>
                </tr>

                <td>Message</td>
                <td><textarea class="form-control" name="description" id="floatingTextarea"></textarea></td>
                </tr>
                <tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='submit' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>