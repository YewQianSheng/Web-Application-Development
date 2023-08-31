<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Read Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Latest compiled and minified Bootstrap CSS -->
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php
        include 'navbar/menu_nav.php';
        ?>
        <form class="d-flex" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
            <input class="form-control me-2 mb-2" type="text" name="search" placeholder="Search" aria-label="Search" value="<?php echo isset($_GET['search_keyword']) ? htmlspecialchars($_GET['search_keyword'], ENT_QUOTES) : ''; ?>">
            <button class="btn btn-outline-success mb-2" type="submit">Search</button>
        </form>

        <div class="page-header">
            <h1>Read Customers</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        if ($action == 'failed') {
            echo "<div class='alert alert-danger'>This customer make a order.</div>";
        }
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT id, username, first_name, last_name, email, status,image FROM customer";
        if (!empty($searchKeyword)) {
            $query .= " WHERE username LIKE :keyword OR first_name LIKE :keyword OR last_name LIKE :keyword OR email LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY id DESC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }
        // delete message prompt will be here

        // select all data

        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='customer_create.php' class='btn btn-primary mb-3'>Create New Customers</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Username</th>";
            echo "<th class='col-1'>Image</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>email</th>";
            echo "<th class='col-2'>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td><a class='link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover link-dark text-dark' href='customer_read_one.php?id={$id}' >{$username}</a></td>";
                echo "<td>";
                echo ($image == "")
                    ? "<img src='image/customer_img.jpg' width='100' height='100'>"
                    : "<img src='" . ($image) . "' width='100' height='100'>";
                echo "</td>";
                echo "<td>{$first_name}</td>";
                echo "<td>{$last_name}</td>";
                echo "<td>{$email}</td>";
                echo "<td>";
                // read one record
                // echo "<a href='customer_read_one.php?id={$id}' class='btn btn-info me-3'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='customer_update.php?id={$id}' class='btn btn-primary me-3'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_customer({$id});'  class='btn btn-danger mx-1'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }


            // end table
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>



    </div> <!-- end .container -->
    <script type='text/javascript'>
        // confirm record deletion
        function delete_customer(id) {

            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'customer_delete.php?id=' + id;
            }
        }
    </script>
    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>