<?php
    $pagetitle = "Add to cart";
    require_once "assets/header.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];

            // Initialize the cart if it doesn't exist in the session
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            // Add the product to the cart
            if (!in_array($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $product_id;
                echo 'Product added to cart successfully.';
            } else {
                echo 'Product is already in the cart.';
            }
        }
    }
?>
