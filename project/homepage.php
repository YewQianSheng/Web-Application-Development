<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Home</title>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="homepage.php">Home</a>
                        </li>

                        <li class="nav-item text-end">
                            <a class="nav-link" href="login_page.php">Login</a>

                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <?php
        include "config/database.php";
        $customer_query = "SELECT * FROM customer ORDER BY id ASC";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT * FROM products ORDER BY id ASC";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_summary_query = "SELECT * FROM order_summary ORDER BY order_id ASC";
        $order_summary_stmt = $con->prepare($order_summary_query);
        $order_summary_stmt->execute();
        $order_summaries = $order_summary_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_detail_query = "SELECT * FROM order_details ORDER BY order_id ASC";
        $order_detail_stmt = $con->prepare($order_detail_query);
        $order_detail_stmt->execute();
        $order_details = $order_detail_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="welcome py-5 text-left">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-4">Welcome to Company Name</h1>
                    <p class="lead">We provide innovative solutions for your business.</p>
                    <a href="#contact" class="btn btn-primary btn-lg">Get in touch</a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center m-auto ">
            <div class="col border border-3 shadow-lg p-2 text-center bg-secondary-subtle">
                <h2 class="fs-4">Total Number of Customers</h2>
                <p class="mt-3 fs-4"><?php echo count($customers); ?></p>
            </div>
            <div class="col border border-3 shadow-lg p-2 text-center bg-secondary-subtle">
                <h2 class="fs-4">Total Number of Products</h2>
                <p class="mt-3 fs-4"><?php echo count($products); ?></p>
            </div>
            <div class="col border border-3 shadow-lg p-2 text-center bg-secondary-subtle">
                <h2 class="fs-4">Total Number of Orders</h2>
                <p class="mt-3 fs-4"><?php echo count($order_summaries); ?></p>
            </div>
        </div>
        <div class="container bg-dark bg-opacity-25 py-5">
            <h2 class="mx-5 text-dark text-center">An Overview of Order</h2>
            <div class="container my-5 justify-content-around">
                <div class="col border border-3 shadow  text-center bg-secondary-subtle">
                    <h3>Latest Order ID and Summary</h3>
                    <p class="mt-3"><span>Customer Name :</span>
                        <?php
                        $latest_order_query = "SELECT * FROM order_summary WHERE order_id=(SELECT MAX(order_id) FROM order_summary)";
                        $latest_order_stmt = $con->prepare($latest_order_query);
                        $latest_order_stmt->execute();
                        $latest_order = $latest_order_stmt->fetch(PDO::FETCH_ASSOC);

                        $customer_id = $latest_order['customer_id'];

                        $latest_customer_name_query = "SELECT * FROM customer where id=?";
                        $latest_customer_name_stmt = $con->prepare($latest_customer_name_query);
                        $latest_customer_name_stmt->bindParam(1, $customer_id);
                        $latest_customer_name_stmt->execute();
                        $latest_names = $latest_customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                        echo $latest_names['first_name'] . " " . $latest_names['last_name'];
                        ?>
                    </p>
                    <p><span>Order Date :</span>
                        <?php echo $latest_order['order_date']; ?>
                    </p>
                    <p><span>Total Amount :</span>
                        <?php echo "RM " . number_format((float)$latest_order['total_amount'], 2, '.', ''); ?>
                    </p>
                </div>
                <div class="col border border-3 shadow  text-center bg-secondary-subtle mt-3">
                    <h3>Highest Purchased Amount Order</h3>
                    <p class="mt-3"><span>Customer Name :</span>
                        <?php
                        $highest_order_query = "SELECT * FROM order_summary WHERE total_amount=(SELECT MAX(total_amount) FROM order_summary)";
                        $highest_order_stmt = $con->prepare($highest_order_query);
                        $highest_order_stmt->execute();
                        $highest_order = $highest_order_stmt->fetch(PDO::FETCH_ASSOC);

                        $customer_id = $highest_order['customer_id'];

                        $highest_customer_name_query = "SELECT * FROM customer where id=?";
                        $highest_customer_name_stmt = $con->prepare($highest_customer_name_query);
                        $highest_customer_name_stmt->bindParam(1, $customer_id);
                        $highest_customer_name_stmt->execute();
                        $highest_names = $highest_customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                        echo $highest_names['first_name'] . " " . $highest_names['last_name'];
                        ?>
                    </p>
                    <p><span>Order Date :</span>
                        <?php echo $highest_order['order_date']; ?>
                    </p>
                    <p><span>Total Amount :</span>
                        <?php echo "RM " . number_format((float)$highest_order['total_amount'], 2, '.', ''); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="container bg-dark bg-opacity-50 py-5">
            <h2 class="mx-5 text-white text-center">An Overview of Our Product</h2>
            <div class="container my-5 justify-content-around">
                <div class="col border border-3 shadow text-center bg-secondary-subtle">
                    <h3>Top 5 Selling Products</h3>
                    <?php
                    $top_product_query = "SELECT product_id, SUM(quantity) AS total_quantity FROM order_details GROUP BY product_id ORDER BY total_quantity DESC";
                    $top_product_stmt = $con->prepare($top_product_query);
                    $top_product_stmt->execute();
                    $top_products = $top_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < 5; $i++) {
                        if (!empty($top_products[$i])) {
                            $top_product_id = $top_products[$i]['product_id'];
                            $top_product_name_query = "SELECT * FROM products WHERE id=?";
                            $top_product_name_stmt = $con->prepare($top_product_name_query);
                            $top_product_name_stmt->bindParam(1, $top_product_id);
                            $top_product_name_stmt->execute();
                            $top_product_names = $top_product_name_stmt->fetch(PDO::FETCH_ASSOC);
                            echo "<p>" . $top_product_names['name'] . " (" . $top_products[$i]['total_quantity'] . " SOLD)";
                        } else {
                            echo "";
                        }
                    }
                    ?>
                </div>
                <div class="col border border-3 shadow text-center bg-secondary-subtle mt-3">
                    <h3>3 Products Never Purchased</h3>
                    <?php
                    $no_purchased_product_query = "SELECT id FROM products WHERE NOT EXISTS(SELECT product_id FROM order_details WHERE order_details.product_id=products.id)";
                    $no_purchased_product_stmt = $con->prepare($no_purchased_product_query);
                    $no_purchased_product_stmt->execute();
                    $no_purchased_products = $no_purchased_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < 3; $i++) {
                        if (!empty($no_purchased_products[$i])) {
                            $no_purchased_product_id = $no_purchased_products[$i]['id'];
                            $no_purchased_product_name_query = "SELECT * FROM products WHERE id=?";
                            $no_purchased_product_name_stmt = $con->prepare($no_purchased_product_name_query);
                            $no_purchased_product_name_stmt->bindParam(1, $no_purchased_product_id);
                            $no_purchased_product_name_stmt->execute();
                            $no_purchased_product_name = $no_purchased_product_name_stmt->fetch(PDO::FETCH_ASSOC);
                            echo "<p>" . $no_purchased_product_name['name'] . "</p>";
                        } else {
                            echo "";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>