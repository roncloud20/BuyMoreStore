<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pagetitle; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <?php session_start(); ?>
    <h1>BuyMore Store</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') { ?>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="">Display Users</a></li>
                <li><a href="">Display Vendors</a></li>
                <li><a href="">Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php } else if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'user'){ ?>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php } else if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'vendor') {?>
                <li><a href="create_product.php">Create Product</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="">Inventory</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php } else {?>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="register.php">Register</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>