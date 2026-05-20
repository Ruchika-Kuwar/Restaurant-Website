<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include("includes/header.php"); ?>

<h2 style="text-align:center;">My Orders 📦</h2>

<div style="width:80%; margin:auto;">

<?php
$result = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY id DESC");

if(mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {
?>

<div style="background:#f9f9f9; padding:15px; margin:15px 0; border-left:5px solid #1e293b;">

    <p><strong>Order ID:</strong> <?php echo $row['id']; ?></p>
    <p><strong>Total:</strong> ₹<?php echo $row['total']; ?></p>
    <p><strong>Status:</strong> <?php echo $row['status']; ?></p>

</div>

<?php
    }

} else {
    echo "<p>No orders found.</p>";
}
?>

</div>

</body>
</html>