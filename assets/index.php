
<?php
    // Creating the page title and adding the header page 
    $pagetitle = "Welcome to BuyMore Store";
    require_once "assets/header.php";
    require_once 'assets/db_connect.php';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
?>
<h1>Welcome <?php echo $user['first_name']; ?></h1>
<p><?php echo $user['email']; ?></p>
<?php
    } else {
        echo "<h1>Welcome</h1>";
    }

?>

<?php
    $sql = $conn->prepare("SELECT * FROM products ORDER BY product_update DESC");
    $sql->execute();
    $result = $sql->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
?>
<link rel="stylesheet" href="assets/main.css"/>
<h1>All Products</h1>
<div class="products">
    <?php foreach ($items as $item): ?>
        <div class="card">
            <img src="<?php echo $item['product_image']?>" alt="<?php echo $item['product_name']?>"/>
            <h2><?php echo $item['product_name']?></h2>
            <span class="price init">&#8358;<?php echo number_format($item['initial_price'], 2, '.', ',') ?></span>
            <span class="price">&#8358;<?php echo number_format($item['selling_price'], 2, '.', ',') ?></span>
            <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px;"><?php echo $item['product_description'] ?></p>
            <p><button>Add to Cart</button></p>
        </div>
    <?php endforeach; ?>
</div>