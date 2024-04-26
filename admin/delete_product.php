<?php session_start();
 include('../server/config.php'); ?>

?>


<?php
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Check if product ID is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->bind_param('i', $product_id);

    // Execute the delete statement
    if ($stmt->execute()) {
        header('Location: products.php?deleted_successfully=Product has been deleted successfully');
        exit();
    } else {
        header('Location: products.php?deleted_failure=Could not delete product');
        exit();
    }
} else {
    // If product ID is not provided in the URL
    header('Location: products.php');
    exit();
}
?>
