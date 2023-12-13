<?php
    $pagetitle = "Cart";
    require_once "assets/header.php";

    // Check if the cart is empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    
        require_once 'assets/db_connect.php';

        // Fetch products from the cart
        $cart_products = $_SESSION['cart'];
        $in_clause = implode(',', $cart_products);

        $sql = $conn->prepare("SELECT * FROM products WHERE product_id IN ($in_clause)");
        $sql->execute();
        $result = $sql->get_result();
        $cart_items = $result->fetch_all(MYSQLI_ASSOC);

        echo "<h1>Your Shopping Cart</h1>";

        foreach ($cart_items as $item) {
            echo "<div class='card'>";
            echo "<h2>{$item['product_name']}</h2>";
            echo "<span class='price'>&#8358;" . number_format($item['selling_price'], 2, '.', ',') . "</span>";
            echo "<p>{$item['product_description']}</p>";
            echo "<p><a href='product_details.php?product_id={$item['product_id']}'>View Details</a></p>";
            echo "</div>";
        }
    } else {
        echo "<h1>Your Shopping Cart is Empty</h1>";
    }
?>
