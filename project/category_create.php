<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Create Category</title>
    <!-- Latest compiled and minified Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php
        include 'navbar/menu_nav.php';
        ?>
        <div class="page-header">
            <h1>Create Category</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO category SET category_name=:category_name, description=:description ";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $category_name = $_POST['category_name'];
                $description = $_POST['description'];

                $errors = array();
                if (empty($category_name)) {
                    $errors[] = 'Product name is required.';
                }

                if (empty($description)) {
                    $errors[] = 'Description is required.';
                }


                // bind the parameters
                else {
                    // bind the parameters
                    $stmt->bindParam(':category_name', $category_name);
                    $stmt->bindParam(':description', $description);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }    // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }


        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='category_name' class='form-control' pattern='^[A-Za-z\s]+$' title='Please enter a valid name (letters and spaces only).' value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea class="form-control" name="description" id="floatingTextarea"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea></td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='category_read.php' class='btn btn-danger'>Back to read category</a>
                    </td>
                </tr>
            </table>

        </form>




    </div>
    <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>