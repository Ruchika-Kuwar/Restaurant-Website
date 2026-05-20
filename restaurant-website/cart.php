<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Remove item
if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
}

// Increase quantity
if(isset($_GET['inc'])) {
    $id = $_GET['inc'];
    $_SESSION['cart'][$id]['qty'] += 1;
}

// Decrease quantity
if(isset($_GET['dec'])) {
    $id = $_GET['dec'];
    if($_SESSION['cart'][$id]['qty'] > 1) {
        $_SESSION['cart'][$id]['qty'] -= 1;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        .container {
            width: 70%;
            margin: auto;
        }

        .item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        a {
            margin: 5px;
            text-decoration: none;
            padding: 5px 10px;
            background: orange;
            color: white;
            border-radius: 3px;
        }

        .remove {
            background: red;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
        }
        
    </style>
</head>

<body>

<div class="container">

<h2>Your Cart 🛒</h2>

<a href="checkout.php" style="
    background: green;
    padding: 10px;
    color: white;
    text-decoration: none;
    border-radius: 5px;">
    Proceed to Checkout
</a>

<?php
if(!empty($_SESSION['cart'])) {

    $total = 0;

    foreach($_SESSION['cart'] as $id => $item) {

        $subtotal = $item['price'] * $item['qty'];
        $total += $subtotal;
?>

    <div class="item">
        <h3><?php echo $item['name']; ?></h3>
        <p>Price: ₹<?php echo $item['price']; ?></p>

        <p>
            Quantity:
            <a href="cart.php?dec=<?php echo $id; ?>">-</a>
            <?php echo $item['qty']; ?>
            <a href="cart.php?inc=<?php echo $id; ?>">+</a>
        </p>

        <p>Subtotal: ₹<?php echo $subtotal; ?></p>

        <a class="remove" href="cart.php?remove=<?php echo $id; ?>">Remove</a>
    </div>

<?php } ?>

    <p class="total">Total: ₹<?php echo $total; ?></p>

<?php } else { ?>

    <p>Your cart is empty</p>

<?php } ?>

<br>
<a href="menu.php">← Back to Menu</a>

</div>

</body>
</html>