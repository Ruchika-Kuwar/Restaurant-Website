<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "restaurant_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If cart is empty
if(empty($_SESSION['cart'])) {
    echo "Cart is empty!";
    exit();
}

// Calculate total
$total = 0;
foreach($_SESSION['cart'] as $item){
    $total += $item['price'] * $item['qty'];
}

// Place Order
if(isset($_POST['place_order'])) {

    $user_id = $_SESSION['user_id'];   // ✅ IMPORTANT FIX

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Insert order (FIXED)
    $query = "INSERT INTO orders (user_id, customer_name, phone, address, total, status)
              VALUES ('$user_id', '$name', '$phone', '$address', '$total', 'Pending')";

    mysqli_query($conn, $query);

    $order_id = mysqli_insert_id($conn);

    // Insert order items
    foreach($_SESSION['cart'] as $item) {

        $item_name = $item['name'];
        $price = $item['price'];
        $qty = $item['qty'];

        $q = "INSERT INTO order_items (order_id, item_name, price, quantity)
              VALUES ('$order_id', '$item_name', '$price', '$qty')";

        mysqli_query($conn, $q);
    }

    // Clear cart
    unset($_SESSION['cart']);

    echo "<script>alert('Order placed successfully'); window.location='order_history.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        .container {
            width: 40%;
            margin: auto;
            background: white;
            padding: 20px;
            margin-top: 50px;
            border-radius: 5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            background: green;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        .total-box {
            background: #eee;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 18px;
        }
    </style>
</head>

<body>

<div class="container">

<h2>Checkout 🧾</h2>

<!-- Total -->
<div class="total-box">
    <strong>Total: ₹<?php echo $total; ?></strong>
</div>

<!-- Form -->
<form method="post">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="text" name="phone" placeholder="Phone Number" required>
    <textarea name="address" placeholder="Address" required></textarea>

    <button type="submit" name="place_order">Place Order</button>
</form>

<br>
<a href="cart.php">← Back to Cart</a>

</div>

</body>
</html>