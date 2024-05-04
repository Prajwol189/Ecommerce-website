
<?php
session_start();
include('server/config.php');
if(!isset($_SESSION['logged_in'])){
  header('location: login.php');
  exit;
}
if(isset($_GET['logout'])){
if(isset($_SESSION['logged_in'])){
  unset($_SESSION['logged_in']);
  unset($_SESSION['user_email']);
  unset($_SESSION['user_name']);
  header('location: login.php');
  exit;

}
}

if(isset($_POST['change_password'])){
    $password =$_POST['password'];
    $confirm_password= $_POST['confirmpassword'];
    $user_email=$_SESSION['user_email'];

    if($password !== $confirm_password){
      header( "Location: account.php?error=Passwords do not match" );
      
    }else if(strlen($password)<6){
        header("location account.php?error=password must be  at least 6 characters");
      //no error
    }else{
      $password = md5($_POST['password']);
     $stmt= $conn->prepare( "UPDATE users SET user_password = ? WHERE user_email = ?" );
     $stmt->bind_param('ss',$password, $user_email);
     
     if($stmt->execute()){
      header("location: account.php?message=password change sucesfuly");
     }else{
      header("location: account.php?error=password not change");

     }
}
}
//get order
 if(isset($_SESSION['logged_in'])) {
  $user_id=$_SESSION['user_id'];
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id= ? ");
  $stmt->bind_param('i',$user_id);
$stmt->execute();
$orders = $stmt->get_result();//array

 }

?>
<?php include('layout/header.php');?>
<!-- Account -->
<section class="my-5 py-5">
    <div class="container">
        <div class="row">
            <!-- Left Section -->
            <div class="mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                <!-- <p class="text-center" style="color:green"><?php if(isset($_GET['register_sucess'])){echo $_GET['register_sucess'];} ?></p> -->
                <!-- <p class="text-center" style="color:green"><?php if(isset($_GET['login_sucess'])){echo $_GET['login_sucess'];} ?></p> -->

                <h3 class="heading-account">Your Account</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p><span>Name:</span> <?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}?></p>
                    <p><span>Email:</span> <?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></p>
                    <p><button href="#orders" id="order-btn">Orders</button></p>
                    <p><button href="account.php?logout=1" id="logout-btn" style="background:red; color: white">Logout</button></p>
                </div>
            </div>

            <!-- Right Section -->
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                <!-- <p class="text-center" style="color:green"><?php if(isset($_GET['register_sucess'])){echo $_GET['register_sucess'];} ?></p>
                <p class="text-center" style="color:green"><?php if(isset($_GET['login_sucess'])){echo $_GET['login_sucess'];} ?></p>

                <h3>Account</h3>
                <!-- <hr class="mx-auto">
                <div class="account-info">
                    <!-- <p><span>Name:</span> <?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}?></p>
                    <p><span>Email:</span> <?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></p> --> 
                     
                
                </div>
            </div>
        </div>
    </div>
</section>

<!--Order-->
<section id="orders" class="order container my-5 py-3">
    <div class="container mt-5">
        <h2 class="font-weight-bolde text-center">Your Orders</h2>
        <hr class="mx-auto ">
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>id</th>
            <th>Cost</th>
            <th>Status</th>
            <th>Date</th>  
            <th>Detail</th>         
        </tr>
        <?php while($row=$orders->fetch_assoc()){?>
        <tr>
            <td><span><?php echo  $row['order_id']; ?></span></td>
            <td><span><?php echo  $row['order_cost']; ?></span></td>
            <td><span><?php echo  $row['order_status']; ?></span></td>
            <td><span><?php echo  $row['order_date']; ?></span></td>
            <td>
                <form method="POST" action="order_details.php">
                    <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status"/>
                    <input type="hidden" value="<?php echo $row['order_id'];?>" name="order_id"/>
                    <input class="btn order-details-btn" name="order_details_btn" type="submit" value="Details"/>
                </form>
            </td>
        </tr>
       <?php }?>
    </table>
</section>

<!-- Footer -->
<?php include('layout/footer.php');?>
