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
      <h1>New Order</h1>
    </div>

    <!-- html form to create product will be here -->
    <!-- PHP insert code will be here -->
    <?php
    date_default_timezone_set('asia/Kuala_Lumpur');
    // include database connection
    include 'config/database.php';
    if ($_POST) {
      try {
        $error = array();
        $quantity_array = $_POST['quantity'];
        $product_id = $_POST['product'];
        $customer = $_POST['customer'];
        if (empty($customer)) {
          $error[] = "You need to select the customer.";
        }

        foreach ($product_id as $product) {
          if (empty($product)) {
            $error[] = "You need to select the product.";
          }
        }

        foreach ($quantity_array as $quantity) {
          if (empty($quantity)) {
            $error[] = "Please fill in the quantity for all products.";
          }
          if ($quantity == 0) {
            $error[] = "Quantity cannot be zero.";
          }
        }

        if (!empty($error)) {
          echo "<div class='alert alert-danger role='alert'>";
          foreach ($error as $error_message) {
            echo $error_message . "<br>";
          }
          echo "</div>";
        } else {

          $order_date = date('Y-m-d H:i:s'); // get the current date and time
          $summary_query = "INSERT INTO order_summary SET customer_id=:customer, order_date=:order_date";
          $summary_stmt = $con->prepare($summary_query);
          $summary_stmt->bindParam(':customer', $customer);
          $summary_stmt->bindParam(':order_date', $order_date);
          $summary_stmt->execute();

          $order_id = $con->lastInsertId();
          // order detail


          $quantity = $_POST['quantity'];

          $details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
          $details_stmt = $con->prepare($details_query);

          for ($i = 0; $i < count($product_id); $i++) {

            $details_stmt->bindParam(':order_id', $order_id);
            $details_stmt->bindParam(':product_id', $product_id[$i]);
            $details_stmt->bindParam(':quantity', $quantity[$i]);
            $details_stmt->execute();
          }
          echo "<div class='alert alert-success'>Order successfully.</div>";
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

          // Generate select options
          foreach ($customers as $customer) {
            $customer_id = $customer['id'];
            $customer_name = $customer['username'];
            echo "<option value='$customer_id'>$customer_name</option>";
          } ?>
        </select>
        <br>
        <tr>
          <td class="text-center">#</td>
          <td class="text-center">Product</td>
          <td class="text-center">Quantity</td>
          <td class="text-center">Action</td>
        </tr>


        <tr class="pRow">
          <td class="text-center">1</td>
          <td><select class="form-select" name="product[]">
              <option value=''>Select a product</option>;
              <?php
              // Fetch products from the database
              $query = "SELECT id, name FROM products";
              $stmt = $con->prepare($query);
              $stmt->execute();
              $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

              // Generate select options
              foreach ($products as $product) {
                echo "<option value='{$product['id']}'>{$product['name']}</option>";
              } ?>
            </select>

          <td><input class="form-control" type="number" name="quantity[]"></td>
          <td><input href='#' onclick='deleteRow(this)' class='btn d-flex justify-content-center btn-danger mt-1' value="Delete" /></td>
          </td>
        </tr>


      </table>
      <input type='submit' value='Save' class='btn btn-primary' />
      <td colspan="4">
        <input type="button" value="Add More Product" class="btn btn-success add_one" />
      </td>
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