<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');


    $customer_exist_query = "SELECT COUNT(*) FROM order_summary WHERE customer_id = ?";
    $customer_exist_stmt = $con->prepare($customer_exist_query);
    $customer_exist_stmt->bindParam(1, $id);
    $customer_exist_stmt->execute();
    $customers = $customer_exist_stmt->fetchColumn();


    $image_query = "SELECT image FROM customer WHERE id=?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);


    // delete query
    $query = "DELETE FROM customer WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    if ($customers > 0) {
        header("Location: customer_read.php?action=failed");
    } else {
        if ($stmt->execute()) {
            if ($image['image'] != "") {
                if (file_exists($image['image'])) {
                    unlink($image['image']);
                }
            }
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: customer_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
