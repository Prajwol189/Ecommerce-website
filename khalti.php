

    <?php
   


  
    session_start();

    // Include database connection
    include('server/config.php');

    // Retrieve user details from the session
    $user_id = $_SESSION['user_id'];

    // Fetch user details from the database
    $res = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'") or die('Query failed');
    if(mysqli_num_rows($res) > 0){
        while($rows = mysqli_fetch_assoc($res)){
            $fullname = $rows['user_name'];
            $email = $rows['user_email'];
            // $phone = $rows['phone'];
            // Adjust other user details if necessary
            
        }
    }

    // Check if order_id session variable is set
    if(isset($_SESSION['order_id'])) {
        $order_id = $_SESSION['order_id'];
    
        // Retrieve order details from the database based on the order ID
        // $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
        // $stmt->bind_param('i', $order_id);
        // $stmt->execute();
        // $order_details = $stmt->get_result();

        // // Calculate the total amount for the order
        // $grand_total = 0;
        // if(mysqli_num_rows($order_details) > 0){
        //     while($fetch_cart = mysqli_fetch_assoc($order_details)){
        //         $total_price = ($fetch_cart['product_price'] * $fetch_cart['product_quantity']);
        //         $grand_total += $total_price;
        //     }
        //     // Convert amount to paisa (multiply by 100)
        //     $grand_total *= 100;
        // }


        $stmt = $conn->prepare("SELECT SUM(product_price * product_quantity) AS total_amount FROM order_items WHERE order_id = ?");
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $order_details = $stmt->get_result();
        
      
        // Check if the query returned any result
        if($order_details->num_rows > 0) {
            // Fetch the total amount from the result
            $row = $order_details->fetch_assoc();
            $grand_total = $row['total_amount'];
            echo "Total amount fetched successfully: $grand_total";
            // Convert amount to paisa (multiply by 100)
            $grand_total *= 100;
            
        } else {
            // Set default grand total to 0 if no result found
            echo("NO result found");
            $grand_total = 0;
        }

        // Prepare data for Khalti payment API
        echo($grand_total);
        $data = array(
            // "return_url" => "http://localhost/Bhangro%20Latest/cart.php",
            "return_url" => "http://localhost:8000/index.php",
            "website_url" => "http://localhost:8000/index.php",
            "amount" => $grand_total,
            // "amount" => 1000,
            "purchase_order_id" => "Order01",
            "purchase_order_name" => "Test Order",
            "customer_info" => array(
                "name" => $fullname,
                "email" => $email,
                //  "phone" => $phone
            ),
  
        );

        $post_data = json_encode($data);

        // Initialize cURL session for Khalti payment API
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Key 1108918e499a4580a0cb3296b286d8e3', // Replace with your Khalti secret key
                'Content-Type: application/json',
            ),
        ));

        // Execute cURL request
        $response = curl_exec($curl);

        // Handle response from Khalti payment API
        if ($response === false) {
            echo curl_error($curl);
        } else {
            $response_array = json_decode($response, true);
            if (!empty($response_array['payment_url'])) {
                // Redirect to Khalti payment page
                unset($_SESSION['cart']);
                header("Location: " . $response_array['payment_url']);
                exit;
            } else {
                // Handle case where payment_url is empty
                echo "Payment initiation failed or payment URL is empty.";
            }
        }

        // Close cURL session
        curl_close($curl);

        // Output Khalti payment API response
        echo $response;
    } else {
        die('Order ID not provided.');
    }
    ?>