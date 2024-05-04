<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/style.css"/>
    <style>
        .navbar-search {
            /* Take remaining space */
        }

        .navbar-search input[type="text"] {
            width: 100%;
            border: none;
            border-radius: 20px;
            padding: 10px 15px;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-search button {
            border: none;
            background-color: #6AB04A;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .navbar-search button:hover {
            background-color: #5d9442;
        }

        .new-nav-link{
            padding: 0 !important;
            font-weight: bold;
            font-size: 18px;
        }

        .nav-content{
            align-items: center !important;
        }

        .search-button{
            border-radius: 0 5px 5px 0 !important;
        }

        .form-control{
            border-radius: 5px 0 0 5px !important;
            width: 400px;
        }
    </style>
</head>
<body>
    <!-- Include jQuery before Bootstrap's JavaScript bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>




    <!-- Include Bootstrap bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!--navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="nav-container align-items-center">
            <div class="d-flex">
                <img class="logo" src="assets/imgs/logo2.png"/>
                <h2 class="brand">RishiAyurved</h2>
            </div>
            <div class="navbar-search">
                <form class="d-flex">
                    <input class="form-control " type="search" placeholder="Search" aria-label="Search">
                    <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            
            <!-- Navbar Toggler Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="nav-buttons align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav nav-content mb-2 mb-lg-0 gap-4">
                    <li class="nav-item">
                        <a class="nav-link new-nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link new-nav-link" href="shop.php">Shop</a>
                    </li>
                    <?php
                    if(isset($_SESSION['user_name'])) { // Check if user is logged in
                        
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle new-nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $_SESSION['user_name'] . '</a>';
                        echo '<ul class="dropdown-menu " aria-labelledby="navbarDropdown" style="z-index:1031;">';
                        echo '<li><a class="dropdown-item" href="account.php">My Account</a></li>';
                        echo '<li><a class="dropdown-item" href="account.php?logout=1">Logout</a></li>';
                        echo '</ul>';
                        echo '</li>';
                    } else {
                        // If user is not logged in, display login and register options
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link login" href="login.php" >Login</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link register " href="register.php">Register</a>';
                        echo '</li>';
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
