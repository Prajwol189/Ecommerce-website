<?php


include('config.php');
$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='haircare' LIMIT 8 ");
$stmt->execute();
$hair_products = $stmt->get_result();//array

?>