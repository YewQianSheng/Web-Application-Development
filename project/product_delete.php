<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');


    $product_exist_query = "SELECT COUNT(*) FROM order_details WHERE product_id = ?";
    $product_exist_stmt = $con->prepare($product_exist_query);
    $product_exist_stmt->bindParam(1, $id);
    $product_exist_stmt->execute();
    $products = $product_exist_stmt->fetchAll(PDO::FETCH_ASSOC);

    $image_query = "SELECT image FROM products WHERE id=?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);
    // delete query
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    if ($products > 0) {
        header("Location: product_read.php?action=failed");
    } else if ($stmt->execute()) {
        unlink("uploads/" . $image['image']);
        // redirect to read records page and
        // tell the user record was deleted
        header("Location: product_read.php?action=deleted");
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
