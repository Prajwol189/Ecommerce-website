<?php


include('config.php');
$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='haircare' LIMIT 4 ");
$stmt->execute();
$hair = $stmt->get_result();//array

?>