<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
  <title>New Order</title>
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
      <h1>New Order</h1>
    </div>
    <!-- html form to create product will be here -->
    <!-- PHP insert code will be here -->
    <?php
    date_default_timezone_set('asia/Kuala_Lumpur');
    // include database connection
    include 'config/database.php';

    $customer_query = "SELECT id, username FROM customer";
    $customer_stmt = $con->prepare($customer_query);
    $customer_stmt->execute();
    $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM products";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($_POST) {

      try {
        $error = array();
        $product_id = '';
        $quantity_array = $_POST['quantity'];
        $product_id = $_POST['product'];
        $customer = $_POST['customer'];
        $total_amount = 0;

        $status_query = "SELECT * FROM customer WHERE id=?";
        $status_stmt = $con->prepare($status_query);
        $status_stmt->bindParam(1, $customer);
        $status_stmt->execute();
        $status = $status_stmt->fetch(PDO::FETCH_ASSOC);
        //array 里面有一样的东西就会删除
        $noduplicate = array_unique($product_id);
        //check有多少个东西
        if (sizeof($noduplicate) != sizeof($product_id)) {
          foreach ($product_id as $key => $val) {
            if (!array_key_exists($key, $noduplicate)) {
              $error[] = "Duplicated products have been chosen ";
              unset($quantity_array[$key]);
            }
          }
        }
        $product_id = array_values($noduplicate);
        $quantity_array = array_values($quantity_array);
        $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($_POST['product']);

        if (empty($customer)) {
          $error[] = "You need to select the customer.";
        } else if ($status['status'] == "Inactive") {
          $error[] = "Inactive account can't make a order";
        }

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
          for ($x = 0; $x < $selected_product_count; $x++) {
            $price_query = "SELECT * FROM products WHERE id=?";
            $price_stmt = $con->prepare($price_query);
            $price_stmt->bindParam(1, $product_id[$x]);
            $price_stmt->execute();
            $prices = $price_stmt->fetch(PDO::FETCH_ASSOC);

            $amount =  ($prices['promotion_price'] != 0) ?  $prices['promotion_price'] * $quantity_array[$x] : $prices['price'] * $quantity_array[$x];
            $total_amount += $amount;
          }
          $order_date = date('Y-m-d H:i:s'); // get the current date and time
          $summary_query = "INSERT INTO order_summary SET customer_id=:customer, total_amount=:total_amount, order_date=:order_date";
          $summary_stmt = $con->prepare($summary_query);
          $summary_stmt->bindParam(':customer', $customer);
          $summary_stmt->bindParam(":total_amount", $total_amount);
          $summary_stmt->bindParam(':order_date', $order_date);
          $summary_stmt->execute();

          $order_id = $con->lastInsertId();
          // order detail


          $quantity = $_POST['quantity'];



          for ($i = 0; $i < count($product_id); $i++) {
            $details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
            $details_stmt = $con->prepare($details_query);
            $details_stmt->bindParam(':order_id', $order_id);
            $details_stmt->bindParam(':product_id', $product_id[$i]);
            $details_stmt->bindParam(':quantity', $quantity[$i]);
            $details_stmt->execute();
          }


          echo "<script>
            window.location.href = 'order_detail_read.php?id={$order_id}&action=create_order_successfully';
          </script>";
          $_POST = array();
        }
      } catch (PDOException $exception) {
        echo '<div class="alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
      }
    }

    ?>

    <!-- html form here where the product information will be entered -->
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
      <table class='table table-hover table-responsive table-bordered' id="row_del">

        <span>Select customer</span>
        <select class="form-select mb-3" name="customer">
          <option value=''>Select a customer</option>;
          <?php
          // Fetch categories from the database
          $query = "SELECT id, username FROM customer";
          $stmt = $con->prepare($query);
          $stmt->execute();
          $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
          for ($x = 0; $x < count($customers); $x++) {
            $customer_selected = isset($_POST["customer"]) && $customers[$x]['id'] == $_POST["customer"] ? "selected" : "";
            echo "<option value='{$customers[$x]['id']}' $customer_selected>{$customers[$x]['username']}</option>";
          }
          ?>
        </select>
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
                // Fetch products from the database


                // Generate select options
                for ($i = 0; $i < count($products); $i++) {
                  $product_selected = isset($_POST["product"]) && $products[$i]['id'] == $product_id[$x] ? "selected" : "";
                  echo "<option value='{$products[$i]['id']}' $product_selected>{$products[$i]['name']}</option>";
                }
                ?>
              </select>

            <td><input type="number" class="form-control" name="quantity[]" id="quantity" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'][$x] : 0; ?>"></td>
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