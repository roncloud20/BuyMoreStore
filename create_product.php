<?php
    // Creating the page title and adding the header page  Hello
    $pagetitle = "Create Product";
    require_once "assets/header.php";

    // Creating a connection to the database
    require_once 'assets/db_connect.php';

    // Validation  
    $pierr = $pnerr = $iperr = $sperr = $pderr = "";
    $product_image = $product_name = $product_category = $initial_price = $selling_price = $product_description = $vendor_id =  "";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize the input parameters pass by users to avoid XSS vulnerabilities
        function sanitizeInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Capturing the input parameters
        $product_name = sanitizeInput($_POST['product_name']);
        $product_category = sanitizeInput($_POST['product_category']);
        $initial_price = sanitizeInput($_POST['initial_price']);
        $selling_price = sanitizeInput($_POST['selling_price']);
        $product_description = sanitizeInput($_POST['product_description']);
        $product_image = $_FILES['product_image'];
        $vendor_id = $_SESSION['user_id'];

        if ($selling_price >= $initial_price) {
            $iperr = "Initial price is less than Selling price";
            $sperr = "Selling price is greater than Initial price";
        } else {
            $iperr = $sperr = "";
        }

        // Validate Image 
        $uploadDirectory = "uploads/";
        $maxFileSize = 3 * 1024 * 1024;
        if ($product_image['size'] <= $maxFileSize) {
            if(isset($product_image) && $product_image['error'] === 0) {
                $tempFilePath = $product_image['tmp_name'];
    
                $imageInfo = getimagesize($tempFilePath);
                
                if($imageInfo !== false) {
                    $newFileName = uniqid('product_') . "." . pathinfo($product_image['name'], PATHINFO_EXTENSION);
    
                    $targetFilePath = $uploadDirectory . $newFileName;
    
                    if(move_uploaded_file($tempFilePath, $targetFilePath)) {
                        echo "Successfully uploaded as " . $newFileName;
                    } else {
                        $pierr = 'Upload failed'; 
                    }
                } else {
                    $pierr = "No image found";
                }
            } else {
                $pierr = "No image found";
            }
    
        } else {
            $pierr = "Image Size is bigger than 3mb";
        }

        // $pierr = $pnerr = $iperr = $sperr = $pderr = "";
        if (empty($pierr) && empty($pnerr) && empty($iperr) && empty($sperr) && empty($pderr)){
            $sql = "INSERT INTO products(product_name, product_category, product_description, initial_price, selling_price, product_image, vendor_id) VALUES ('$product_name','$product_category','$product_description','$initial_price','$selling_price','$targetFilePath', '$vendor_id')";
        }

        if(mysqli_query($conn, $sql)) {
            echo "<h1>Product Created Successfully</h1>";
            $product_image = $product_name = $product_category = $initial_price = $selling_price = $product_description = $vendor_id =  "";
        } else {
            echo "<h1>Product Creation Failed</h1>";
        }
        
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <h1>Create a Product</h1>
    <input type="file" id="image" name="product_image" onchange="previewImage()"/> <br/>
    <span><?php echo $pierr; ?></span>
    <img src="" id="imagePreview" style="max-width: 300px; max-height: 300px;"/>
    <input type="text" name="product_name" placeholder="Enter Product Name"/>
    <span><?php echo $pnerr; ?></span>
    <select name="product_category" required>
        <option value="Electronics">Electronics</option>
        <option value="Fashion">Fashion</option>
        <option value="Home and Furniture">Home and Furniture</option>
        <option value="Beauty and Personal Care">Beauty and Personal Care</option>
        <option value="Books and Stationery">Books and Stationery</option>
        <option value="Sports and Outdoors">Sports and Outdoors</option>
        <option value="Toys and Games">Toys and Games</option>
        <option value="Health and Wellness">Health and Wellness</option>
        <option value="Automotive">Automotive</option>
        <option value="Jewelry and Watches">Jewelry and Watches</option>
        <option value="Music and Instruments">Music and Instruments</option>
        <option value="Art and Craft Supplies">Art and Craft Supplies</option>
        <option value="Pet Supplies">Pet Supplies</option>
        <option value="Grocery and Gourmet">Grocery and Gourmet</option>
        <option value="Travel and Luggage">Travel and Luggage</option>
    </select>
    <input type="number" name="initial_price" placeholder="Enter Initial Price">
    <span><?php echo $iperr; ?></span>
    <input type="number" name="selling_price" placeholder="Enter Selling Price">
    <span><?php echo $sperr; ?></span>
    <textarea name="product_description" placeholder="Enter Product Description" width="100%"></textarea>
    <span><?php echo $pderr; ?></span>

    <input type="submit" value="Create Product">
</form>

<script>
    function previewImage() {
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(imageInput.files[0]);
        }
    }
</script>

<?php

?>