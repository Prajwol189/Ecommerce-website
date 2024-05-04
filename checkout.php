

<?php
  session_start();

include('layout/header.php');?>
<?php

  //let user in
  if(!empty($_SESSION['cart'])){

//send user home page
  }else{
    header('location: index.php');
  }



?>
<section class="my-5 py-5">
    <div class="container">
        <div class="row">
            <!-- Left Section -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="mt-3 pt-5">
                    <div class="text-center">
                        <h2>Account</h3>
                        <hr class="mx-auto">
                    </div>
                    <div class="account-info">
                        <p><span>Name:</span> <?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}?></p>
                        <p><span>Email:</span> <?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></p>
                     
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="mt-3 pt-5">
                    <div class="text-center">
                        <h2 class="font-weight-bold">Check out</h2>
                        <hr class="mx-auto">
                    </div>
                    <div class="container login-container">
                        <form id="checkout-form" action="server/place_order.php" method="POST">
                            <p class="text-center" style="color:red;"><?php if(isset($_GET['message'])){ echo $_GET['message'];}?></p>
                            <?php if(isset($_GET['message'])){?>
                                <a href="login.php"class="btn btn-primary">Login</a>
                            <?php } ?>
                            <!--<div class="form-group checkout-small-element">
                                <label >Name</label>
                                <input type="text" class="form-control" id="checkout-name" name="name" value="<?php echo $_SESSION['user_name'];?>" disabled/>
                            </div>-->
                            <div class="form-group checkout-small-element">
                                <label>Add Phone</label>
                                <input type="text" class="form-control" id="checkout-phone" name="phone" placeholder="number" required/>
                            </div>
                         
                            <div class="form-group checkout-large-element">
                                <label>Address</label>
                                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="address" required/>
                            </div>
                            <div class="form-group checkout-btn-container">
                                <p>Total Amount: Rs <?php echo  $_SESSION['total']; ?></p>
                                <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order"/>
                                <input type="submit" class="btn" id="checkout-btn" name="cod" value="Cash on Delivery"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


      <!--checkout-->
     


    <?php include('layout/footer.php');?>