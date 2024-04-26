
<?php
session_start();
include('server/config.php');
if(isset($_SESSION['logged_in'])){
  header("Location: account.php");
  exit;
}
if (isset($_POST['login_btn'])){
    $email=$_POST['email'];
    $password=md5($_POST['password']) ;  //encrypt password before storing in database
    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? AND user_password=? LIMIT 1");

    $stmt->bind_param('ss', $email, $password);
 

    if($stmt->execute()){
      $stmt->bind_result($user_id,$username,$user_email,$user_password);
      $stmt->store_result();
        if($stmt->num_rows()==1){
          $stmt->fetch() ;
          $_SESSION['user_id']=$user_id;
          $_SESSION['user_name']=$username;
          $_SESSION['user_email']=$user_email;
          $_SESSION['logged_in']=true;

          header('location: account.php?login_sucess=login sucessfully');

        }else{
          header("location: login.php?error=There no account with these credintail");

        }
    }else{
      //error
      header("location: login.php?error=somthing is worng");
    }
} 


?>
<?php include('layout/header.php');?>

<!-- Login -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Login</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container login-container">
        <form id="login-form" action="login.php" method="POST">
          <p style="color:red"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" id="login-btn" name="login_btn">Login</button>
            </div>
            <div class="form-group">
                <a href="register.php" id="register-url" class="btn">Dont have?Register here</a>
            </div>
        </form>
    </div>
</section>




<?php include('layout/footer.php');?>