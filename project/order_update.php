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
        <?php
        include 'navbar/menu_nav.php';
        ?>
        <div class="page-header">
            <h1>Update Order</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');
        date_default_timezone_set('asia/Kuala_Lumpur');
        // include database connection
        include 'config/database.php';
        $customer_query = "SELECT id, username FROM customer";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customer = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT id, name FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_summary_query = "SELECT * FROM order_summary WHERE order_id=:id";
        $order_summary_stmt = $con->prepare($order_summary_query);
        $order_summary_stmt->bindParam(":id", $order_id);
        $order_summary_stmt->execute();
        $order_summaries = $order_summary_stmt->fetch(PDO::FETCH_ASSOC);

        $order_detail_query = "SELECT * FROM order_details WHERE order_id=:order_id";
        $order_detail_stmt = $con->prepare($order_detail_query);
        $order_detail_stmt->bindParam(":order_id", $order_id);
        $order_detail_stmt->execute();
        $order_details = $order_detail_stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($_POST) {
            $product_id = $_POST["product"];
            $quantity = $_POST["quantity"];
            if (sizeof($noduplicate) != sizeof($product_id)) {
                foreach ($product_id as $key => $val) {
                    if (!array_key_exists($key, $noduplicate)) {
                        $error[] = "Duplicated products have been chosen ";
                        array_splice($product_id, $key, 1);
                        array_splice($quantity_array, $key, 1);
                    }
                }
            }
            $product_id = array_values($noduplicate);
            $quantity = array_values($quantity);

            print_r($product_id);
            print_r($quantity);
            $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($order_details);

            try {
                if (isset($selected_product_count)) {
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        if ($product_id[$i] == "") {
                            $error[] = " Please choose the product for NO " . $i + 1 . ".";
                        }

                        if ($quantity_array[$i] == 0 || empty($quantity_array[$i])) {
                            $error[] = "Quantity Can not be zero or empty.";
                        } else if ($quantity_array[$i] < 0) {
                            $error[] = "Quantity Can not be negative number.";
                        }
                    }
                }

                if (!empty($error)) {
                    echo "<div class='alert alert-danger role='alert'>";
                    foreach ($error as $error_message) {
                        echo $error_message . "<br>";
                    }
                    echo "</div>";
                } else {
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $order_date = date('Y-m-d H:i:s');
                    $delete_details_query = "DELETE FROM order_details WHERE order_id=:order_id";
                    $delete_details_stmt = $con->prepare($delete_details_query);
                    $delete_details_stmt->bindParam(":order_id", $order_id);
                    $delete_details_stmt->execute();

                    // Insert updated order details into the database
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        $order_details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                        $order_details_stmt = $con->prepare($order_details_query);
                        $order_details_stmt->bindParam(":order_id", $order_id);
                        $order_details_stmt->bindParam(":product_id", $product_id[$i]);
                        $order_details_stmt->bindParam(":quantity", $quantity[$i]);
                        $order_details_stmt->execute();
                    }
                    echo "<div class='alert alert-success' role='alert'>Order Placed Successfully.</div>";
                    $_POST = array();
                }
            } catch (PDOException $exception) {
                echo '<div class="alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
            }
        }

        ?>

        <!-- html form here where the product information will be entered -->
        <form action="" method="POST">
            <table class='table table-hover table-responsive table-bordered' id="row_del">

                <span>Customer Name</span>
                <input type="text" class="form-control" value="<?php echo $customer[$order_summaries['customer_id']]['username'] ?>">
                <br>

                <tr>
                    <td class="text-center">#</td>
                    <td class="text-center">Product</td>
                    <td class="text-center">Quantity</td>
                    <td class="text-center">Action</td>
                </tr>

                <?php
                $product_keep = (!empty($error)) ? $selected_product_count : 1;
                for ($x = 0; $x < $product_keep; $x++) {
                ?>
                    <tr class="pRow">
                        <td class="col-1">
                            <?php echo $x + 1; ?>
                        </td>
                        <td><select class="form-select" name="product[]">
                                <option value=''>Select a product</option>;

                                <?php
                                // Generate select options
                                for ($i = 0; $i < count($products); $i++) {
                                    $product_selected = $products[$i]['id'] == $order_details[$x]['product_id'] ? "selected" : "";
                                    echo "<option value='{$products[$i]['id']}' $product_selected>{$products[$i]['name']}</option>";
                                }
                                ?>
                            </select>

                        <td><input type="number" class="form-control" name="quantity[]" id="quantity" value="<?php echo $order_details[$x]['quantity'] ?>"></td>
                        <td><input href='#' onclick='deleteRow(this)' class='btn d-flex justify-content-center btn-danger mt-1' value="Delete" /></td>
                        </td>
                    <?php

                } ?>
                    </tr>


            </table>
            <input type='submit' value='Save' class='btn btn-primary' />
            <td colspan="4">
                <input type="button" value="Add More Product" class="btn btn-success add_one" />
            </td>
            <a href='order_list_read.php' class='btn btn-danger'>Back to order list</a>
        </form>
        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var rows = document.getElementsByClassName('pRow');
                    // Get the last row in the table
                    var lastRow = rows[rows.length - 1];
                    // Clone the last row
                    var clone = lastRow.cloneNode(true);
                    // Insert the clone after the last row
                    lastRow.insertAdjacentElement('afterend', clone);

                    // Loop through the rows
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                }
            }, false);

            function deleteRow(r) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var i = r.parentNode.parentNode.rowIndex;
                    document.getElementById("row_del").deleteRow(i);

                    var rows = document.getElementsByClassName('pRow');
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                } else {
                    alert("You need order at least one item.");
                }
            }
        </script>



    </div>
    <!-- end .container -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>