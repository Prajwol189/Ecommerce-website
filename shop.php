<?php 
session_start();

include('layout/header.php');
include('server/config.php');

// Fetch products based on the selected category or show all products
// Get selected category from URL



// Handle search functionality
if(isset($_POST['search'])) {
    // Handle pagination
    if(isset($_GET['page_no']) && $_GET['page_no'] !== "") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }

    // Get selected category
    $category = $_POST['category'];

    // Count total records
    if($category == 'All') {
        $stmt1 = $conn->prepare("SELECT COUNT(*) as total_records FROM products");
    } else {
        $stmt1 = $conn->prepare("SELECT COUNT(*) as total_records FROM products WHERE product_category=?");
        $stmt1->bind_param('s', $category);
    }
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    // Pagination variables
    $total_records_per_page = 10;
    $offset = ($page_no - 1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";
    $total_no_of_page = ceil($total_records / $total_records_per_page);

    // Fetch products based on category and pagination
    if($category == 'All') {
        $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
    } else {
        $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category=? LIMIT $offset, $total_records_per_page");
        $stmt2->bind_param('s', $category);
    }
    $stmt2->execute();
    $products = $stmt2->get_result();
} else {
    // If search not initiated, fetch all products with pagination
    if(isset($_GET['page_no']) && $_GET['page_no'] !== "") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }

    // Count total records
    $stmt1 = $conn->prepare("SELECT COUNT(*) as total_records FROM products");
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    // Pagination variables
    $total_records_per_page = 10;
    $offset = ($page_no - 1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";
    $total_no_of_page = ceil($total_records / $total_records_per_page);

    // Fetch products with pagination
    $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
    $stmt2->execute();
    $products = $stmt2->get_result();
}
?>

<div class="" style="margin-top: 100px;">
    <div class="row">
        <!-- Side Menu -->
        <div class="col-lg-3 col-md-6 col-sm-12 bg-light">
            <div class="p-4">
                <h2 class="text-center mb-4 mt-5" style="color:#6AB04A;">Search Products</h2>
                <form action="shop.php" method="POST">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" aria-label="Category">
                            <option value="All">All</option>
                            <option value="haircare" <?php if(isset($category) && $category == 'haircare'){echo 'selected';}?>>Haircare</option>
                            <option value="Medicine" <?php if(isset($category) && $category == 'Medicine'){echo 'selected';}?>>Medicine</option>
                            <option value="Tea" <?php if(isset($category) && $category == 'Tea'){echo 'selected';}?>>Tea</option>
                            <option value="Cooking" <?php if(isset($category) && $category == 'Cooking'){echo 'selected';}?>>Cooking</option>
                        </select>
                    </div>
                    <button type="submit" name="search" class="btn btn-primary w-100">Search</button>
                </form>
            </div>
        </div>

        <!-- Ayurvedic Products -->
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="mt-5">
                <section id="feature" class="pb-5">
                    <div>
                        <h3 class="text-center mb-4" style="color:#8B4513;">Ayurvedic Products</h3>
                        <hr>
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            <?php while($row=$products->fetch_assoc()){?>
                            <div class="product text-center col-md-3 col-sm-6">
                                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image'];?>" />
                                <h5 class="p-name"><?php echo $row['product_name'];?></h5>
                                <h4 class="p-price">Rs <?php echo $row['product_price'];?></h4>
                                <a class="btn buy-btn" href="<?php echo "productonly.php?product_id=".$row['product_id'];?>">Buy Now</a>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.php');?>
