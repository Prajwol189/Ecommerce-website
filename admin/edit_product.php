<?php include('header.php'); ?>

<?php

if($_GET['product_id']){
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();

    $products = $stmt->get_result();
    
    // Check if the product exists


    }elseif(isset($_POST['edit_btn'])) {

    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $offer = $_POST['offer'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?, discount_price=?, product_category=? WHERE product_id=?");
    
    $stmt->bind_param('sssssi', $title, $description, $price, $offer, $category, $product_id);

    if($stmt->execute()) {
        header('Location: products.php?edit_success_message=Product has been updated');
    } else {
        header('Location: products.php?edit_failure_message=Error, try again');
    }

} else {
    header('Location: products.php');
    exit;
}

?>

<div class="container-fluid">
    <div class="row" style="min-height: 1000px">
        <?php include('sidemenu.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <!-- Add any buttons or toolbar elements here -->
                    </div>
                </div>
            </div>

            <h2>Edit Product</h2>

            <div class="table-responsive mx-auto container">
                <form id="edit-form" method="POST" action="edit_product.php">
                    <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                    <div class="form-group mt-2">
                        <?php foreach($products as $product){?>
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>" />
                            <label>Title</label>
                            <input type="text" class="form-control" id="product-name" value="<?php echo $product['product_name'];?>" name="title" placeholder="Title">
                    </div>
                    <div class="form-group mt-2">
                        <label>Description</label>
                        <input type="text" class="form-control" id="product-desc" value="<?php echo $product['product_description'];?>" name="description" placeholder="Description">
                    </div>
                    <div class="form-group mt-2">
                        <label>Price</label>
                        <input type="number" class="form-control" id="product-price" value="<?php echo $product['product_price'];?>" name="price" placeholder="Price">
                    </div>
                    <div class="form-group mt-2">
                        <label>Category</label>
                        <select class="form-select" id="category" name="category" aria-label="Category">
                            <option value="All">All</option>
                            <option value="haircare" <?php if(isset($category) && $category == 'haircare'){echo 'selected';}?>>Haircare</option>
                            <option value="Medicine" <?php if(isset($category) && $category == 'Medicine'){echo 'selected';}?>>Medicine</option>
                            <option value="Tea" <?php if(isset($category) && $category == 'Tea'){echo 'selected';}?>>Tea</option>
                            <option value="Cooking" <?php if(isset($category) && $category == 'Cooking'){echo 'selected';}?>>Cooking</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label>Offer</label>
                        <input type="text" class="form-control" id="product-offer" value="<?php echo $product['discount_price'];?>" name="offer" placeholder="Offer">
                    </div>
                    <button type="submit" class="btn btn-primary" name="edit_btn">Edit</button>
                    <?php }?>
                </form>
            </div>
        </main>
    </div>
</div>
