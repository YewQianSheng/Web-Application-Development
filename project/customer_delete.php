<?php
// include database connection
include 'config/database.php';
try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    //exists example
    // SELECT name FROM products WHERE EXISTS(SELECT products.id FROM order_detail WHERE order_detail.product_id=products.id)
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    // delete query
    $query = "DELETE FROM customer WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: customer_read.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
// show error
catch(PDOException $exception){
    echo "<div class = 'alert alert-danger'>";
    echo $exception->getMessage();
    echo "</div>";
}
