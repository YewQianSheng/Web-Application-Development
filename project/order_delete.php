<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    // delete from order_details
    $query_order_details = "DELETE FROM order_details WHERE order_id = ?";
    $stmt_order_details = $con->prepare($query_order_details);
    $stmt_order_details->bindParam(1, $id);
    $order_details_deleted = $stmt_order_details->execute();

    // delete from order_summary
    $query_order_summary = "DELETE FROM order_summary WHERE order_id = ?";
    $stmt_order_summary = $con->prepare($query_order_summary);
    $stmt_order_summary->bindParam(1, $id);
    $order_summary_deleted = $stmt_order_summary->execute();

    if ($order_details_deleted && $order_summary_deleted) {
        // redirect to read records page and
        // tell the user records were deleted
        header('Location: order_list_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
} catch (PDOException $exception) {
    echo "<div class='alert alert-danger'>";
    echo $exception->getMessage();
    echo "</div>";
}
