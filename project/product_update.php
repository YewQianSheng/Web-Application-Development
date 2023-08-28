<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <?php
        include 'navbar/menu_nav.php';
        ?>
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        //include database connection
        include 'config/database.php';
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, description, price,promotion_price,category_name,manufacture_date,expired_date,image FROM products WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);
            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $category_name = $row['category_name'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
            $image = $row['image'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                if (isset($_POST['delete_image'])) {
                    $empty = "";
                    $delete_query = "UPDATE products
                    SET image=:image  WHERE products.id = :id";
                    $delete_stmt = $con->prepare($delete_query);
                    $delete_stmt->bindParam(":image", $empty);
                    $delete_stmt->bindParam(":id", $id);
                    $delete_stmt->execute();
                    unlink($image);
                    echo "<script>
                    window.location.href = 'customer_read_one.php?id={$id}';
                  </script>";
                } else {
                    // write update query
                    // in this case, it seemed like we have so many fields to pass and
                    // it is better to label them and not use question marks
                    $query = "UPDATE products
                  SET name=:name, description=:description,
   price=:price,promotion_price=:promotion_price,category_name=:category_name,manufacture_date=:manufacture_date,expired_date=:expired_date,image=:image WHERE id = :id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // posted values
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                    $description = htmlspecialchars(strip_tags($_POST['description']));
                    $price = htmlspecialchars(strip_tags($_POST['price']));
                    $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                    $category_name = htmlspecialchars(strip_tags($_POST['category_name']));
                    $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                    $expired_date = htmlspecialchars(strip_tags($_POST['expired_date']));
                    $image = !empty($_FILES["image"]["name"])
                        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                        : "";
                    $image = htmlspecialchars(strip_tags($image));

                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    $errors = array();

                    if ($image) {
                        // upload to file to folder

                        // error message is empty
                        $file_upload_error_messages = "";
                        // make sure that file is a real image
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        $image_width = $check[0];
                        $image_height = $check[1];
                        if ($image_width != $image_height) {
                            $errors[] = "Only square size image allowed.";
                        }
                        // make sure submitted file is not too large, can't be larger than 1 MB
                        if ($_FILES['image']['size'] > (524288)) {
                            $errors[] = "<div>Image must be less than 512 KB in size.</div>";
                        }
                        if ($check !== false) {
                            // submitted file is an image
                        } else {
                            $errors[] = "<div>Submitted file is not an image.</div>";
                        }
                        // make sure certain file types are allowed
                        $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                        if (!in_array($file_type, $allowed_file_types)) {
                            $errors[] = "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                        }
                        // make sure file does not exist
                        if (file_exists($target_file)) {
                            $errors[] = "<div>Image already exists. Try to change file name.</div>";
                        }
                    }

                    if (empty($name)) {
                        $errors[] = 'Product name is required.';
                    }

                    if (empty($description)) {
                        $errors[] = 'Description is required.';
                    }


                    if (empty($price)) {
                        $errors[] = "Price is required.";
                    } elseif (!is_numeric($price)) {
                        $errors[] = "Price must be a numeric value.";
                    }

                    if ($promotion_price >= $price) {
                        $errors[] = 'Promotion price must be cheaper than original price.';
                    }

                    if ($manufacture_date > date('Y-m-d')) {
                        $errors[] = "Date of birth cannot be greater than the current date.";
                    }

                    if (empty($manufacture_date)) {
                        $errors[] = 'manufacture is required.';
                    } elseif ($expired_date <= $manufacture_date) {
                        $errors[] = 'Expired date must be later than manufacture date.';
                    }


                    if (!empty($errors)) {
                        echo "<div class='alert alert-danger m-3'>";
                        foreach ($errors as $displayError) {
                            echo $displayError . "<br>";
                        }
                        echo "</div>";
                    }
                    // bind the parameters
                    else {
                        // bind the parameters
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':promotion_price', $promotion_price);
                        $stmt->bindParam(':category_name', $category_name);
                        $stmt->bindParam(':manufacture_date', $manufacture_date);
                        $stmt->bindParam(':expired_date', $expired_date);
                        if ($image == "") {
                            $stmt->bindParam(":image", $row['image']);
                        } else {
                            $stmt->bindParam(':image', $target_file);
                        }
                        $stmt->bindParam(':id', $id);
                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was updated.</div>";
                            if ($image) {
                                if ($target_file !=  $row['image'] && $row['image'] != "") {
                                    unlink($row['image']);
                                }
                                // make sure submitted file is not too large, can't be larger than 1 MB
                                if ($_FILES['image']['size'] > (1024000)) {
                                    $errors[] = "<div>Image must be less than 1 MB in size.</div>";
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

                            // header("Location: product_read_one.php?id={$id}");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>



        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>


                <tr>
                    <td>promotion_price</td>
                    <td><input type='text' name='promotion_price' value="<?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td><select class="form-select" name="category_name">
                            <?php
                            // Fetch categories from the database
                            $query = "SELECT category_name FROM category";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            while ($category_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $category = $category_row['category_name'];

                                $selected = ($category == $row['category_name']) ? "selected" : "";
                                echo "<option value='" . $category . "' $selected>" . htmlspecialchars($category) . "</option>";
                            }
                            ?></select></td>
                </tr>
                <tr>
                    <td>manufacture_date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>expired_date</td>
                    <td><input type='date' name='expired_date' value="<?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td>
                        <?php
                        if ($image == "") {
                            echo '<img src="image/CS_image.jpg" width="100"> <br>';
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
                        <a href='product_read.php' class='btn btn-info'>Back to read products</a>

                    </td>
                </tr>
            </table>
        </form>



    </div>

</body>

</html>