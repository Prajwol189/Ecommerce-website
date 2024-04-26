<?php
session_start();
include('../server/config.php');
if(isset($_SESSION['admin_logged_in'])){
  header('location: dashboard.php');
  exit;
}
if (isset($_POST['login_btn'])){
    $email=$_POST['email'];
    $password=md5($_POST['password']) ;  //encrypt password before storing in database
    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email, admin_password FROM admins WHERE admin_email=? AND admin_password=? LIMIT 1");

    $stmt->bind_param('ss', $email, $password);
 

    if($stmt->execute()){
      $stmt->bind_result($admin_id,$admin_name,$admin_email,$admin_password);
      $stmt->store_result();
        if($stmt->num_rows()==1){
          $stmt->fetch() ;
          $_SESSION['admin_id']=$admin_id;
          $_SESSION['admin_name']=$admin_name;
          $_SESSION['admin_email']=$admin_email;
          $_SESSION['admin_logged_in']=true;

          header('location: dashboard.php?login_sucess=login sucessfully');

        }else{
          header("location: login.php?error=There no account with these credintail");
        }
    }else{
      //error
      header("location: login.php?error=somthing is worng");
    }
} 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard</title>
    <style>
        /* Reset default margin and padding */
        body, h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }

        /* Center the login container */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f1f1f1; /* Set a background color */
        }

        /* Login form container */
        .login-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .login-container input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 0;
            cursor: pointer;
            border-radius: 3px;
            width: 100%;
        }

        .login-container input[type="submit"]:hover {
            background-color: #555;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="login-form" action="login.php" method="post">
            <div class="error-message" id="error-message"></div>
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="submit" name="login_btn" value="Login">
        </form>
    </div>
</body>
</html>
