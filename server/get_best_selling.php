<?php


include('config.php');
$stmt = $conn->prepare("SELECT * FROM products LIMIT 8 ");
$stmt->execute();
$best_selling = $stmt->get_result();//array

?>