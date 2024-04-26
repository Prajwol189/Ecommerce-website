

<?php
session_start();
include('server/config.php');
if(isset($_SESSION['logged_in'])){
  header('location: account.php');
  exit;
}
  if(isset($_POST['register'])){
   $name = $_POST['name'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $confirm = $_POST['retype-password'];

   if($password !== $confirm){
  header( "Location: register.php?error=Passwords do not match" );
   }
  else if(strlen($password)<6){
    header("location register.php?error=password must be  at least 6 characters");
  }
  //if no error
  else{
        $stmt1=$conn->prepare("SELECT count(*) FROM users where user_email=?");
        $stmt1->bind_param('s',$email);
        $stmt1->execute();
        $stmt1->bind_result($num_row);
        $stmt1->store_result();
        $stmt1->fetch();

        //if already registerthan
        if ($num_row !=0 ) {
          header("location: register.php?error=Email is already in use");
          //if no one is register
        }else{

            //create a user
          $stmt= $conn->prepare( "INSERT INTO users (user_name,user_email, user_password) 
                        VALUES (?, ?, ?)");

          $stmt->bind_param('sss', $name, $email,md5($password));

          if( $stmt->execute()){
            $user_id= $stmt->insert_id;
            $_SESSION['user_id']=$user_id;
            $_SESSION['user_email']= $email;
            $_SESSION['user_name']=$name;
            $_SESSION['logged_in']=true;
            header("location: login.php?register_sucess= You register sucessfully");
            
          }else{
            header("location: register.php?register= Account not created");

         }
  }

}
}
  
  

?>

<?php include('layout/header.php');?>
<!-- Register -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Resgister</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container login-container">
        <form id="register-form" action="register.php" method="POST">
        <p style="color: red;"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
            <div class="form-group">
                <label >Name</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
            </div>
            <div class="form-group">
                <label>Retype Password</label>
                <input type="password" class="form-control" id="register-retype-password" name="retype-password" placeholder="Retype-Password" required/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" id="register-btn" name="register">register</button>
            </div>
            <div class="form-group">
                <p class="login-link" href="login.php">have an account? <a href="#" id="login-url">Login</a></p>
            </div>
        </form>
    </div>
</section>




    <!-- Footer -->
    <?php include('layout/footer.php');?>