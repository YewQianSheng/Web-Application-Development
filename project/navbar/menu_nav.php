<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login_page.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-warning py-0">
        <a class="navbar-brand py-0" href="#"><img src="image/Logo.png" alt="logo" height="100"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end me-3 ms-3" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Product
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="product_create.php">Create Product</a></li>
                        <li> <a class="dropdown-item" href="product_read.php">Read Product</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Customer
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                        <li> <a class="dropdown-item" href="customer_read.php">Read Customer</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Category
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="category_create.php">Create Category</a></li>
                        <li> <a class="dropdown-item" href="category_read.php">Read Category</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Order
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="order_create.php">New Order</a></li>
                        <li> <a class="dropdown-item" href="order_list_read.php">Order Read</a></li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a class="nav-link" aria-current="page" href="contact_form.php">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="?logout=true">Logout</a>

                </li>

            </ul>
        </div>

    </nav>
</body>

</html>