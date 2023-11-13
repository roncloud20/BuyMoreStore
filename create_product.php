<?php
    // Creating the page title and adding the header page 
    $pagetitle = "Create Product";
    require_once "assets/header.php";

    // Creating a connection to the database
    require_once 'assets/db_connect.php';

    // Validation  
    $pierr = $pnerr = $iperr = $sperr = $pderr = "";
    $product_image = $product_name = $product_category = $initial_price = $selling_price = $product_description = "";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize the input parameters pass by users to avoid XSS vulnerabilities
        function sanitizeInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // function priceValidate($data, $errormsg) {
        //     if(preg_match('/^[1-9]\d$/', $data )) {
        //         $errormsg = "";
        //     } else {
        //         $errormsg = "Invalid price value";
        //     }
        // }

        $product_name = sanitizeInput($_POST['product_name']);
        $product_category = sanitizeInput($_POST['product_category']);
        $initial_price = sanitizeInput($_POST['initial_price']);
        $selling_price = sanitizeInput($_POST['selling_price']);
        $product_description = sanitizeInput($_POST['product_description']);

        // $initial_price = $initial_price;
        // $selling_price = priceValidate($selling_price;

        // if ($initial_price <= $selling_price) {
        //     $iperr = "Initial price is greater than Selling price";
        //     $sperr = "Selling price is less than Initial price";
        // } else {
        //     $iperr = $sperr = ""
        // }

        if ($selling_price >= $initial_price) {
            $iperr = "Initial price is less than Selling price";
            $sperr = "Selling price is greater than Initial price";
        } else {
            $iperr = $sperr = "";
        }

    }
?>

<form action="" method="post">
    <h1>Create a Product</h1>
    <input type="file" id="image" name="product_image" onchange="previewImage()" required/> <br/>
    <span><?php echo $pierr; ?></span>
    <img src="" id="imagePreview" style="max-width: 300px; max-height: 300px;"/>
    <input type="text" name="product_name" placeholder="Enter Product Name" required/>
    <span><?php echo $pnerr; ?></span>
    <select name="product_category" required>
        <option value="Home Appliances">Home Appliances</option>
        <option value="Kitchen Appliances">Kitchen Appliances</option>
        <option value="Electronic Gadgets" selected>Electronic Gadgets</option>
        <option value="Office Equiptment">Office Equiptment</option>
        <option value="Groceries">Groceries</option>
    </select>
    <input type="text" name="initial_price" placeholder="Enter Initial Price" required>
    <span><?php echo $iperr; ?></span>
    <input type="text" name="selling_price" placeholder="Enter Selling Price" required>
    <span><?php echo $sperr; ?></span>
    <textarea name="product_description" placeholder="Enter Product Description" required width="100%"></textarea>
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