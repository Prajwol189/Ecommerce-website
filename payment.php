<?php

  session_start();
  if(isset($_POST['order_pay_btn'])){
    $order_status=$_POST['order_status'];
    $order_total_price=$_POST['order_total_price'];
  

  }
  include('layout/header.php');
?>

      <!--payment-->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="font-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container login-container">
          <?php if(isset($_SESSION['total'])&& $_SESSION['total'] !=0){?>
            <p>Total Price : <?php echo $_SESSION['total'];?></p>
            <p>Order Place Sucessfully<p>         
            <?php }else if(isset($_POST['order_status'])&& $_POST['order_status']=="UNPAID"){?>
            <p>Total payment:$<?php echo $_POST['order_total_price'];?></p>
              <p>Order Place Sucessfully<p>
          <?php } else{?>

            <p>Your cart  is empty </p>
          <?php }?>

          </div>
    </section>


    <?php include('layout/footer.php');?>