<?php
session_start();
include('config.php');
if(!isset($_SESSION['logged_in'])){
  header('location: ../login.php?message=please login or register to place and order');
  exit;
  


}



if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    // Update order status in the orders table
    $update_stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $update_stmt->bind_param('si', $order_status, $order_id);
    $update_stmt->execute();

    // Redirect to order details page or any other page as needed
    header("location: ../payment.php ");    exit;
 }// else {
//     header('location: ../order_details.php');
//     exit;
// }

  //if logged in
if(isset($_POST['place_order'])){
            //get user info and store to database 
            // $name=$_POST['name'];
            $name=$_SESSION['user_name'];
            // $email=$_POST['email'];
            $phone=$_POST['phone'];
            $address=$_POST['address'];
            $order_cost=$_SESSION["total"];
            $order_status="not paid";
            $user_id=$_SESSION['user_id'];
            $order_date= date('Y-m-d H:i:s', time());
            $stmt = $conn->prepare("INSERT INTO orders (user_name,order_cost, order_status, user_id, user_phone, user_address, order_date)
            VALUES (?,?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sisisss',$name,$order_cost,$order_status,$user_id,$phone,$address, $order_date );
            $stmt_status=$stmt->execute();
            if(!$stmt_status){
              header('location: index.php');
            }

            //store order info in database
            $order_id = $stmt->insert_id;

            //get product form cart
            foreach ($_SESSION['cart'] as $key => $value){
            $product= $_SESSION['cart'][$key];
            $product_id=$product['product_id'];
            $product_name=$product['product_name'];
            $product_image=$product['product_image'];
            $product_price=$product['product_price'];
            $product_quantity=$product['product_quantity'];

          //store each item
                $stmt1= $conn->prepare("INSERT INTO order_items(order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date)
                VALUES(?,?,?,?,?,?,?,?)");
                $stmt1->bind_param('iissiiis',$order_id,$product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id,$order_date );
                $stmt1->execute();
            }
            $_SESSION['order_id']=$order_id;
            
              //clear cart
              //unset($_SESSION['cart']);


            //inform user
            header("location: ../payment.php ");
            exit;


        } else{
          $name= $_SESSION['user_name'];
            // $email=$_POST['email'];
            $phone=$_POST['phone'];
            $city=$_POST['address'];
            $address=$_POST['address'];
            $order_cost=$_SESSION["total"];
            $order_status="CASH ON DELIVERY";
            $user_id=$_SESSION['user_id'];
            $order_date= date('Y-m-d H:i:s', time());
            $stmt = $conn->prepare("INSERT INTO `orders` (user_name,order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
            VALUES (?,?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sisissss',$name,$order_cost,$order_status,$user_id,$phone, $city,$address, $order_date );
            $stmt_status=$stmt->execute();
            if(!$stmt_status){
              header('location: index.php');
            }

            //store order info in database
            $order_id = $stmt->insert_id;

            //get product form cart
            foreach ($_SESSION['cart'] as $key => $value){
            $product= $_SESSION['cart'][$key];
            $product_id=$product['product_id'];
            $product_name=$product['product_name'];
            $product_image=$product['product_image'];
            $product_price=$product['product_price'];
            $product_quantity=$product['product_quantity'];

          //store each item
                $stmt1= $conn->prepare("INSERT INTO order_items (order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date)
                VALUES(?,?,?,?,?,?,?,?)");
                $stmt1->bind_param('iissiiis',$order_id,$product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id,$order_date);
                $stmt1->execute();
            }
            $_SESSION['order_id']=$order_id;
              //clear cart
              //unset($_SESSION['cart']);


            //inform user
            header("location: ../payment.php ");
        }






?>