    <?php 
    session_start();
    include('layout/header.php'); ?>
  
    <?php include('server/config.php'); ?>

    <?php
    if (isset($_GET['status']) && $_GET['status'] === "Completed") {
        $order_id = $_SESSION['order_id'];
        $stmt = $conn->prepare("UPDATE orders SET order_status = 'paid' WHERE order_id = ?");
        $stmt->bind_param('i', $order_id);
        $stmt->execute();

        // Close the database connection
        $conn->close();

        // Redirect to the desired page
        echo '<script>alert("Order placed successfully.")</script>';
        echo '<script>
            setTimeout(function() {
                window.location.href = "http://localhost:8000/index.php";
            }, 0);
        </script>';

        exit; // Ensure script execution stops after redirection
    }
    ?>

    <!-- Home Section -->
    <section>
        <!-- Swiper Container -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide" id="home">
                    <div class="container" style="color: #8B4513;">
                        <h5>Herbal medicines and product</h5>
                        <h1>Best Price</h1>
                        <p>Harmony in Nature, Healing in Ayurveda</p>
                        <button>Buy now</button>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide" id="home">
                    <div class="container" style="color: #8B4513;">
                        <h5>Herbal medicines and product and ajfsajfskfj</h5>
                        <h1>Best Price</h1>
                        <p>Harmony in Nature, Healing in Ayurveda</p>
                        <button>Buy now</button>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <!-- End of Swiper Container -->
    </section>
    <!-- End of Home Section -->

    <!-- Select Category Section 
    <section id="Products">
        <div class="container text-center mt-5">
            
            <h2>Select Category</h2>
            <div class="categories">
                <a href="shop.php?category=cooking" class="category-button">
                    <img src="health.jpg" alt="Cooking"> Cooking
                </a>
                <a href="shop.php?category=Medicine" class="category-button <?php if(isset($category) && $category == 'Medicine'){echo 'active';}?>">
                    <img src="personalcare.jpg" alt="Medicine"> Medicine
                </a>
                <a href="shop.php?category=Tea" class="category-button">
                    <img src="medicine.jpg" alt="Tea"> Tea
                </a>
                <a href="shop.php?category=haircare" class="category-button">
                    <img src="nutraceuticals.jpg" alt="Haircare"> Haircare
                </a>
            </div>
        </div>
    </section>-->
    <!-- Best Selling Products Section -->
    <!-- Best Selling Products Section -->
    <section id="feature" class="my-5 pb-5">
    <!-- Container for Best Selling Section -->
    <div class="container">
        <!-- Heading for Best Selling Products -->
        <h2 class="text-center">Best Selling Products</h2>
        
        <!-- Swiper Container for Best Selling Section -->
        <div class="swiper mySwiperBestSelling">
            <div class="swiper-wrapper">
               
                <?php include('server/get_best_selling.php'); ?>
                <?php while($row = $best_selling->fetch_assoc()) { ?>
                    <div class="swiper-slide">
                            
                                    <div class="">
                                        <div class="product text-center">
                                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                                            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                                            <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                                            <a href="<?php echo "productonly.php?product_id=".$row['product_id']; ?>"> <button class="buy-btn">Buy now</button></a>
                                        </div>
                                    </div>
                            
                        </div>
                   
                <?php } ?>
            </div>
            <!-- Navigation Buttons -->
            <div class="swiper-button-next" style="color: green"></div>
            <div class="swiper-button-prev" style="color: green"></div>
            <!-- Pagination -->
            <!-- <div class="swiper-pagination"></div> -->
        </div>
        <!-- End of Swiper Container -->
    </div>
    <!-- End of Container for Best Selling Section -->
</section>

    <!-- Banner Section -->
    <section id="banner">
        <div class="container" class="md-5">
            <h4 style="color:white;"> Best Sale Offer</h4>
            <h1>Collection of <br>all ayurvedic product</h1>
            <button class="text-uppercase">Buy</button>
        </div>
    </section>
    <section id="feature" class="my-5 pb-5">
    <!-- Container for Best Selling Section -->
    <div class="container">
        <!-- Heading for Best Selling Products -->
        <h2 class="text-center">New arrival</h2>
        
        <!-- Swiper Container for Best Selling Section -->
        <div class="swiper mySwiperBestSelling">
            <div class="swiper-wrapper">
               
                <?php include('server/get_best_selling.php'); ?>
                <?php while($row = $best_selling->fetch_assoc()) { ?>
                    <div class="swiper-slide">
                            
                                    <div class="">
                                        <div class="product text-center">
                                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                                            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                                            <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                                            <a href="<?php echo "productonly.php?product_id=".$row['product_id']; ?>"> <button class="buy-btn">Buy now</button></a>
                                        </div>
                                    </div>
                            
                        </div>
                   
                <?php } ?>
            </div>
            <!-- Navigation Buttons -->
            <div class="swiper-button-next" style="color: green"></div>
            <div class="swiper-button-prev" style="color: green"></div>
            <!-- Pagination -->
            <!-- <div class="swiper-pagination"></div> -->
        </div>
        <!-- End of Swiper Container -->
    </div>
    <!-- End of Container for Best Selling Section -->
</section>
<section id="feature" class="my-5 pb-5">
    <!-- Container for Best Selling Section -->
    <div class="container">
        <!-- Heading for Best Selling Products -->
        <h2 class="text-center">Hair Product</h2>
        
        <!-- Swiper Container for Best Selling Section -->
        <div class="swiper mySwiperBestSelling">
            <div class="swiper-wrapper">
               
                <?php include('server/get_haircare.php'); ?>
                <?php while($row = $hair_products->fetch_assoc()) { ?>
                    <div class="swiper-slide">
                            
                                    <div class="">
                                        <div class="product text-center">
                                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                                            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                                            <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                                            <a href="<?php echo "productonly.php?product_id=".$row['product_id']; ?>"> <button class="buy-btn">Buy now</button></a>
                                        </div>
                                    </div>
                            
                        </div>
                   
                <?php } ?>
            </div>
            <!-- Navigation Buttons -->
            <div class="swiper-button-next" style="color: green"></div>
            <div class="swiper-button-prev" style="color: green"></div>
            <!-- Pagination -->
            <!-- <div class="swiper-pagination"></div> -->
        </div>
        <!-- End of Swiper Container -->
    </div>
    <!-- End of Container for Best Selling Section -->
</section>

    <!-- Footer -->
    <?php include('layout/footer.php'); ?>

    <!-- JavaScript for Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiperFeature = new Swiper("#feature .swiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
            autoplay: {
                delay: 1120,
            },
        navigation: {
            nextEl: '#feature .swiper-button-next',
            prevEl: '#feature .swiper-button-prev',
        },
        pagination: {
            el: '#feature .swiper-pagination',
            clickable: true,
        },
    });
</script>
    <!-- <script>
        var mySwiper = new Swiper('.mySwiper', {
            loop: true,
            autoplay: {
                delay: 1000000000, // 3 seconds
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper for Best Selling Section
            var mySwiperBestSelling = new Swiper('.mySwiperBestSelling', {
                loop: true,
                autoplay: {
                    delay: 4000, // 4 seconds
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
            
            // Custom code to change one product at a time
            setInterval(function() {
                mySwiperBestSelling.slideNext(); // Change one product
            }, 4000); // Repeat every 4 seconds
        });

    </script> -->
