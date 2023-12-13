<?php
    
    require_once 'assets/db_connect.php';

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        $sql = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $sql->bind_param("i", $product_id);
        $sql->execute();
        $result = $sql->get_result();
        $product = $result->fetch_assoc();
        
        $pagetitle = $product['product_name'];
        require_once "assets/header.php";

        if ($product) {
            echo "<h1>Product Details</h1>";
            echo "<div class='card'>";
            echo "<h2>{$product['product_name']}</h2>";
            echo "<span class='price'>&#8358;" . number_format($product['selling_price'], 2, '.', ',') . "</span>";
            echo "<p>{$product['product_description']}</p>";
            echo "<p><a href='add_to_cart.php?product_id={$product['product_id']}'>Add to Cart</a></p>";
            echo "</div>";
        } else {
            echo "<h1>Product not found</h1>";
        }
    } else {
        echo "<h1>Invalid product ID</h1>";
    }
?>
