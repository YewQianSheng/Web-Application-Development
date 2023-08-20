<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');


    $customer_exist_query = "SELECT id FROM customer WHERE EXISTS (SELECT customer_id FROM order_summary WHERE order_summary.customer_id = customer.id)";
    $customer_exist_stmt = $con->prepare($customer_exist_query);
    $customer_exist_stmt->execute();
    $customers = $customer_exist_stmt->fetchAll(PDO::FETCH_ASSOC);

    // delete query
    $query = "DELETE FROM customer WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    for ($i = 0; $i < count($customers); $i++) {
        if ($id == $customers[$i]['id'])
            $error = 1;
    }
    if (isset($error)) {
        header("Location: customer_read.php?action=failed");
    } else if ($stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header("Location: customer_read.php?action=deleted");
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
