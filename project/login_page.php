<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
    <!-- container -->
    <div class="container pb-5">
        <div class="page-header p-2">
            <h1>Log In</h1>
        </div>

        <?php
        // include database connection
        include 'config/database.php';

        if ($_POST) {
            $username_enter = $_POST['username_input'];
            $password_enter = $_POST['password_input'];

            $errors = array();

            if (empty($username_enter)) {
                $errors[] = "Username/Email is required.";
            }
            if (empty($password_enter)) {
                $errors[] = "Password is required.";
            }
            if (!empty($errors)) {
                echo "<div class='alert alert-danger'>";
                foreach ($errors as $error) {
                    echo "<p class='error-message'>$error</p>";
                }
                echo "</div>";
            } else {
                try {
                    $query = "SELECT id, username, password, email,status FROM customer WHERE username=:username_input OR email=:username_input";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username_input', $username_enter);
                    $stmt->bindParam(':username_input', $username_enter);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {

                        if (password_verify($password_enter, $row['password'])) {
                            if ($row['status'] == 'Active') {
                                header("Location: index.php");
                                exit();
                            } else {
                                $error = "Inactive account.";
                                echo "<div class='alert alert-danger'>";

                                echo "<p class='error-message'>$error</p>";

                                echo "</div>";
                            }
                        } else {
                            $error = "Incorrect password.";
                            echo "<div class='alert alert-danger'>";

                            echo "<p class='error-message'>$error</p>";

                            echo "</div>";
                        }
                    } else {
                        $error = "Username/Email Not Found.";
                        echo "<div class='alert alert-danger'>";

                        echo "<p class='error-message'>$error</p>";

                        echo "</div>";
                    }
                } catch (PDOException $exception) {
                    $error = $exception->getMessage();
                }
            }
        }

        ?>


        <div class="container border border-5 p-3">
            <form action="" method="post">
                <div class="my-3">
                    <label for="username_input">Username/Email</label>
                    <input type="text" name="username_input" id="username_input" class="form-control">
                    <span class="text-danger">
                </div>
                <div class="my-3">
                    <label for="password_input">Password</label>
                    <input type="password" name="password_input" id="password_input" class="form-control">
                    <span class="text-danger">
                </div>
                <div class="text-center">
                    <button class='btn btn-primary m-r-1em fs-5 px-5' name="submit" type="submit">Login</button>
                </div>
                <span class="text-danger">
            </form>
        </div>




        <!-- PHP code to read records will be here -->

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>