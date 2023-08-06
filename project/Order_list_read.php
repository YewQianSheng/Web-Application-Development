<!DOCTYPE HTML>
<html>

<head>
    <title>List of order sumarry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container p-0 bg-light">
        <?php
        include 'navbar/menu_nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Order Summary</h1>
        </div>

        <?php
        include 'config/database.php';

        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT order_summary.order_id, customer.first_name, customer.last_name, order_summary.order_date FROM order_summary INNER JOIN customer ON order_summary.customer_id = customer.id";
        if (!empty($searchKeyword)) {
            $query .= " WHERE customer.first_name LIKE :keyword OR customer.last_name LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY order_summary.order_id ASC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pt-2">
            <a href="order_create.php" class="btn btn-primary m-b-1em">Create New Order</a>
        </div>';

        echo '<div class="p-3">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search customer name..." value="' . str_replace('%', '', $searchKeyword) . '">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>';

        if ($num > 0) {
            echo "<div class='p-3'>";
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Customer Name</th>";
            echo "<th>Order Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$first_name} {$last_name}</td>";
                echo "<td>{$order_date}</td>";
                echo "<td class='col-3'>";
                echo "<a href='order_detail_read.php?id={$order_id}' class='btn btn-primary m-r-1em text-white mx-2'>Read Order Details</a>";
                echo "<a href='order_update.php?order_id={$order_id}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";
                echo "</td>";

                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo '<div class="p-3">
                <div class="alert alert-danger">No records found.</div>
            </div>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>