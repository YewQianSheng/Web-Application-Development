<?php include "session.php" ?>
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
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        if ($action == 'record_updated') {
            echo "<div class='alert alert-success m-3'>product record was updated.</div>";
        }
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
            $noduplicate = array_unique($product_id);
            if (sizeof($noduplicate) != sizeof($product_id)) {
                foreach ($product_id as $key => $val) {
                    if (!array_key_exists($key, $noduplicate)) {
                        $error[] = "Duplicated products have been chosen ";
                        unset($quantity[$key]);
                    }
                }
            }
            $product_id = array_values($noduplicate);
            $quantity = array_values($quantity);

            $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($order_details);

            try {
                if (isset($selected_product_count)) {
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        if ($product_id[$i] == "") {
                            $error[] = " Please choose the product for NO " . $i + 1 . ".";
                        }

                        if ($quantity[$i] == 0 || empty($quantity[$i])) {
                            $error[] = "Quantity Can not be zero or empty.";
                        } else if ($quantity[$i] < 0) {
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
                    $total_amount = 0;
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        $price_query = "SELECT * FROM products WHERE id=?";
                        $price_stmt = $con->prepare($price_query);
                        $price_stmt->bindParam(1, $product_id[$i]);
                        $price_stmt->execute();
                        $prices = $price_stmt->fetch(PDO::FETCH_ASSOC);

                        $amount =  ($prices['promotion_price'] != 0) ?  $prices['promotion_price'] * $quantity[$i] : $prices['price'] * $quantity[$i];
                        $total_amount += $amount;
                    }
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time
                    $summary_query = "UPDATE order_summary SET  total_amount=:total_amount, order_date=:order_date WHERE order_id=:order_id";
                    $summary_stmt = $con->prepare($summary_query);
                    $summary_stmt->bindParam(":order_id", $order_id);
                    $summary_stmt->bindParam(":total_amount", $total_amount);
                    $summary_stmt->bindParam(':order_date', $order_date);
                    $summary_stmt->execute();
                    echo "<script>
                    window.location.href = 'order_update.php?order_id={$order_id}&action=record_updated';
                  </script>";
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
                <input type="text" readonly class="form-control" value="<?php echo $customer[$order_summaries['customer_id'] - 1]['username'] ?>">
                <br>

                <tr>
                    <td class="text-center">#</td>
                    <td class="text-center">Product</td>
                    <td class="text-center">Quantity</td>
                    <td class="text-center">Action</td>
                </tr>

                <?php
                $product_keep = empty($error) ? count($order_details) : count($noduplicate);
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