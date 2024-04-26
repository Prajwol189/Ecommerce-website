
<?php 
session_start();
include('layout/header.php');?>
<?php
  if(isset($_POST['add_to_cart'])){


    //already added
      if(isset($_SESSION['cart'])){
        $products_array_ids= array_column($_SESSION['cart'],"product_id");//all array of product id
        //added to cart or not
        if( !in_array($_POST['product_id'],$products_array_ids)){

        
          $product_id = $_POST['product_id'];
          $product_name = $_POST['product_name'];
          $product_price = $_POST['product_price'];
          $product_image = $_POST['product_image'];
          $product_quantity = $_POST['product_quantity'];
  
          $product_array= array(
                       'product_id' =>$product_id,
                       'product_name' =>$product_name,
                       'product_price' =>$product_price,
                       'product_image' =>$product_image,
                       'product_quantity' =>$product_quantity   
          ); 
          
          $_SESSION['cart'][$product_id]=$product_array;//

          //already addes
        }else{
          echo '<script>alert("This Product is already Added");</script>';
         // echo '<script>window.location="index.php";</script>';
        }

        //frist product
      }else{

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $product_array= array(
                     'product_id' =>$product_id,
                     'product_name' =>$product_name,
                     'product_price' =>$product_price,
                     'product_image' =>$product_image,
                     'product_quantity' =>$product_quantity   
        );
        $_SESSION['cart'][$product_id]=$product_array;//
      }
//calculate total
calculateTotalCart();
//remove cart  item
  }elseif(isset($_POST['remove_product'])){
   
    $product_id= $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    //calculate total
    calculateTotalCart();
  
}elseif(isset($_POST['edit_quantity'])){
  //get id
    $product_id = $_POST['product_id'];
    $product_quantity= $_POST['product_quantity'];
//array from session
   $product_array = $_SESSION['cart'][$product_id];
   //return back array 
   $product_array['product_quantity']=$product_quantity;
    
   $_SESSION['cart'][$product_id]=$product_array;

   //calculate total
   calculateTotalCart();



}else{
   //header('Location: index.php');
  }
  
  function calculateTotalCart(){
    $total = 0;
    foreach($_SESSION['cart'] as $key =>$value){
      $product = $_SESSION['cart'][$key];

      $price =$product['product_price'];
      $quantity =$product['product_quantity'];

      $total +=$price*$quantity;
  }
  $_SESSION['total']= $total ;
}

?>


      <!--CART-->
      <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">Your cart</h2>
            <hr>
        </div>

          <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php if(isset($_SESSION["cart"])){?>
            <?php foreach($_SESSION['cart'] as $key => $value){ ?>
            <tr>
            <td>
                <div class="product-info">
                    <img src="assets/imgs/<?php echo $value['product_image'];?>"/>
                    <div>
                        <p><?php echo $value['product_name'];?></p>
                        <small><?php echo $value['product_price'];?></small>
                        <br>
                        <form method="POST" action="cart.php">
                          <input type="hidden" name="product_id"  value="<?php echo $value['product_id'];?>"/>

                          <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                        </form>                   
                        </div> 
                </div>
            </td>
            <td>
                <form method="POST" action="cart.php">
                  <input type="hidden" name="product_id"  value="<?php echo $value['product_id'];?>"/>
                  <input type="number" name="product_quantity" value="<?php echo $value['product_quantity'];?>"/>
                  <input type="submit" class="edit-btn" name="edit_quantity" value="edit"/>

                </form>


            </td>
            <td>
                <span>rs</span>
                <span class="product-price"><?php echo $value['product_quantity']*  $value['product_price']?></span>
            </td>
            </tr>
           <?php } ?>
           <?php } ?>
           
        </table>
        
            <div class="cart-total">
                <table>
              
                    
                    <tr>
                        <td>total</td>
                        <?php  if(isset($_SESSION['cart'])) {?>
                        <td>rs<?php echo $_SESSION['total'];?></td>
                          <?php } ?>
                      </tr>
                </table>
            </div>
            <div class="checkout-container">
              <form method="POST" action="checkout.php">
                <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
            </div>
    </form>  
        </div>
      </section>


      <!-- Footer -->
      <?php include('layout/footer.php');?>