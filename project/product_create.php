<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        <a class="nav-link" href="product_create.php">Create Product</a>
                        <a class="nav-link" href="#">Create Customer</a>
                        <a class="nav-link" href="contact_form.php">Contact Us</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="page-header">
            <h1>Create Product</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created, promotion_price=:promotion, manufacture_date=:manufacture, expired_date=:expired ";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion = $_POST['promotion'];
                $manufacture = $_POST['manufacture'];
                $expired = $_POST['expired'];
                if ($promotion >= $price) {
                    echo "<div class='alert alert-danger'>Promotion price must be cheaper than original price
                    </div>";
                }
                if ($expired <= $manufacture) {
                    echo "<div class='alert alert-danger'>Expired date must be later than manufacture date</div>";
                } else {
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $created = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':created', $created);
                    $stmt->bindParam(':promotion', $promotion);
                    $stmt->bindParam(':manufacture', $manufacture);
                    $stmt->bindParam(':expired', $expired);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }      // show error
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
                    <td><input type='text' name='name' class='form-control' pattern='^[A-Za-z\s]+$' title='Please enter a valid name (letters and spaces only).' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea class="form-control" name="description" id="floatingTextarea"></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' pattern='^\d+(\.\d{1,2})?$' title='Please enter a valid number.' /></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture_date</td>
                    <td><input type='date' name='manufacture' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired_date</td>
                    <td><input type='date' name='expired' class='form-control' /></td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>

        </form>




    </div>
    <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>