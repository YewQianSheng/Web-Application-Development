<?php include "session.php" ?>
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
        <?php
        include 'navbar/menu_nav.php';
        ?>
        <?php
        include 'config/database.php';

        $cusquery = "SELECT COUNT(*) FROM customer";
        $proquery = "SELECT COUNT(*) FROM products";
        $orquery = "SELECT COUNT(*) FROM order_summary";

        $cus = $con->query($cusquery)->fetchColumn();
        $pro = $con->query($proquery)->fetchColumn();
        $or = $con->query($orquery)->fetchColumn();

        // Query for latest order
        $latestquery = "
            SELECT
                customer.username,
                order_summary.order_id,
                order_summary.order_date,
                order_details.product_id,
                order_details.quantity,
                products.name,
                products.price,
                products.promotion_price
            FROM
                order_summary
            INNER JOIN
                order_details ON order_summary.order_id = order_details.order_id
            INNER JOIN
                products ON order_details.product_id = products.id
            INNER JOIN
                customer ON order_summary.customer_id = customer.id
            ORDER BY
                order_id DESC
            LIMIT 1
        ";
        $lateststmt = $con->prepare($latestquery);
        $lateststmt->execute();

        // Query for customer with most orders
        $mostquery = "
            SELECT
                customer.username,
                order_summary.order_date,
                COUNT(order_id) AS count
            FROM
                order_summary
            INNER JOIN
                customer ON customer.id = order_summary.order_id
            GROUP BY
                customer_id
            ORDER BY
                COUNT(order_id) DESC
            LIMIT 1
        ";
        $moststmt = $con->prepare($mostquery);
        $moststmt->execute();

        // Query for top 5 ordered products
        $topquery = "
            SELECT
                products.name,
                products.description,
                category.category_name
            FROM
                order_details
            INNER JOIN
                products ON products.id = order_details.product_id
            INNER JOIN
                category ON category.id = products.id
            GROUP BY
                order_details.product_id
            LIMIT 5
        ";
        $topstmt = $con->prepare($topquery);
        $topstmt->execute();
        $counttop = $topstmt->rowCount();

        // Query for products that haven't been ordered
        $nobuyquery = "
            SELECT
                products.name,
                products.description,
                category.category_name
            FROM
                products
            INNER JOIN
                category ON category.id = products.id
            WHERE NOT EXISTS (
                SELECT
                    products.id
                FROM
                    order_details
                WHERE
                    order_details.product_id = products.id
            )
            LIMIT 3
        ";
        $nobuystmt = $con->prepare($nobuyquery);
        $nobuystmt->execute();
        $countnobuy = $nobuystmt->rowCount();

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

        <div class="d-flex justify-content-around">
            <div class="text-center shadow p-5 m-5 bg-body-tertiary rounded flex-fill">
                <h1><?php echo $cus; ?></h1>
                <br>
                <h5>Customers Registered</h5>
            </div>
            <div class="text-center shadow p-5 m-5 bg-body-tertiary rounded flex-fill">
                <h1><?php echo $pro; ?></h1>
                <br>
                <h5>Products Available</h5>
            </div>
            <div class="text-center shadow p-5 m-5 bg-body-tertiary rounded flex-fill">
                <h1><?php echo $or; ?></h1>
                <br>
                <h5>Orders Created</h5>
            </div>
        </div>

        <!-- Display latest order details -->
        <div class="text-center shadow p-5 m-5 bg-body-tertiary rounded">
            <?php
            $total = 0;
            while ($latestrow = $lateststmt->fetch(PDO::FETCH_ASSOC)) {
                extract($latestrow);
                $theprice = ($promotion_price < $price && $promotion_price > 0) ? $promotion_price : $price;
                $total = $quantity * $theprice;

                echo "<h5>Our Latest Order Made By</h5>";
                echo "<h5><strong>$username</strong></h5>";
                echo "<h5>Bought <strong>$quantity</strong> <strong>$name</strong></h5>";
                echo "<h5>Order Date: <strong>$order_date</strong></h5>";
                echo "<h5>Total Price: <strong>RM $total</strong></h5>";
            }
            ?>
        </div>

        <!-- Display customer with most orders -->
        <div class="text-center shadow p-5 m-5 bg-body-tertiary rounded">
            <?php
            while ($mostrow = $moststmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<h5>Customer with Most Orders:</h5>";
                echo "<h5><strong>$username</strong> (Order Count: <strong>{$mostrow['count']}</strong>)</h5>";
                echo "<h5>Order Date: <strong>{$mostrow['order_date']}</strong></h5>";
            }
            ?>
        </div>

        <!-- Display top 5 ordered products -->
        <div class="text-center shadow p-5 m-5 bg-body-tertiary rounded">
            <h5>Top 5 Products Ordered by Customers</h5>
            <div class="d-flex justify-content-around flex-wrap">
                <?php
                for ($i = 0; $i < $counttop; $i++) {
                    echo "<div class='shadow p-5 m-5 bg-body-tertiary rounded text-start' style='width:25rem;'>";
                    $toprow = $topstmt->fetch(PDO::FETCH_ASSOC);
                    echo "<h5><strong>{$toprow['name']}</strong></h5>";
                    echo "<h5>Categories: <strong>{$toprow['category_name']}</strong></h5>";
                    echo "<h5>Description: <strong>{$toprow['description']}</strong></h5>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <!-- Display new products not ordered -->
        <div class="text-center shadow p-5 m-5 bg-body-tertiary rounded">
            <h5>New Products From The Store</h5>
            <div class="d-flex justify-content-around flex-wrap">
                <?php
                for ($i = 0; $i < $countnobuy; $i++) {
                    echo "<div class='shadow p-5 m-5 bg-body-tertiary rounded text-start' style='width:25rem;'>";
                    $nobuyrow = $nobuystmt->fetch(PDO::FETCH_ASSOC);
                    echo "<h5><strong>{$nobuyrow['name']}</strong></h5>";
                    echo "<h5>Categories: <strong>{$nobuyrow['category_name']}</strong></h5>";
                    echo "<h5>Description: <strong>{$nobuyrow['description']}</strong></h5>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>