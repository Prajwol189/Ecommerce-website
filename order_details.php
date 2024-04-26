<?php
session_start();

include('server/config.php');

if(isset($_POST['order_details_btn'])&& isset($_POST['order_id'])){
$order_id=$_POST['order_id'];

$order_status = $_POST['order_status'];

$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
$stmt-> bind_param('i', $order_id);
$stmt->execute();
$order_details = $stmt->get_result();

// Retrieve order status from the orders table
$order_status_query = mysqli_query($conn, "SELECT order_status FROM orders WHERE order_id = '$order_id'");
$order_status_row = mysqli_fetch_assoc($order_status_query);
$order_status = $order_status_row['order_status'];

$order_total_price=calculateTotalOrderPrice($order_details);
}else{
    header('location: order_details.php');
    
}
function calculateTotalOrderPrice($order_details){
  $total = 0;
  while($row = mysqli_fetch_assoc($order_details)){
    $total += $row['product_price']* $row['product_quantity'];
  }

return $total ;
}

?>

<?php include('layout/header.php');?>



<!--Order_details-->

<section id="orders" class="order container my-5 py-3">
    <div class="container mt-5">
        <h2 class="font-weight-bolde text-center">Order Details</h2>
        <hr class="mx-auto ">
    </div>

      <table class="mt-5 pt-5 mx-auto">
        <tr>
            
            <th>Product </th>
           <th>Price</th>
            <th>Quantity</th>  
           
        </tr>

        <?php foreach($order_details as $row ){?>
        <tr>
            <td>
                <div class="product_info">
                    <img src="assets/imgs/<?php echo $row['product_image'];?>"/>
                    <div>
                        <p class="mt-3"><?php echo $row['product_name'];?></p>
                    </div>
                </div>
      
              <td>
                <span><?php echo  $row['product_price']; ?></span>
              </td>
              <td>
                <span><?php echo  $row['product_quantity']; ?></span>
              </td>
              </tr>
              <?php }?>
    </table>
    <?php if($order_status == "not paid") :?>
             <form style="float: right;" method="POST" action="payment.php">
             <input type="hidden" name="order_total_price" value="<?php echo $order_total_price;?>"/>
             <input type="hidden" name="order_id" value="<?php echo $order_id;?>"/>
             <input type="hidden" name="order_status" value="<?php echo $order_status;?>">
                <input type="submit" name="order_pay_btn"value="pay now" class="btn btn-primary"/>
             </form>
             <?php endif;  ?>
        
        
   
      
    
      
  </section>









 <!-- Footer -->
 <?php include('layout/footer.php');?>