<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

// Stats
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];

$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as revenue FROM orders"))['revenue'];

$total_menu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM menu"))['total'];

// Recent Orders
$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f4f6f9;
}

/* Sidebar */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #1e293b;
    position: fixed;
}

.sidebar h2 {
    color: white;
    text-align: center;
    padding: 20px;
}

.sidebar a {
    display: block;
    color: #cbd5e1;
    padding: 15px;
    text-decoration: none;
}

.sidebar a:hover {
    background: #334155;
}

/* Content */
.content {
    margin-left: 220px;
    padding: 20px;
}

/* Cards */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
    gap: 20px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card h3 {
    margin: 0;
}

.value {
    font-size: 22px;
    font-weight: bold;
    margin-top: 10px;
}

/* Table */
table {
    width: 100%;
    margin-top: 20px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background: #1e293b;
    color: white;
}

tr:nth-child(even) {
    background: #f2f2f2;
}
</style>

</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="orders.php">Orders</a>
    <a href="manage_menu.php">Menu</a>
    <a href="messages.php">Messages</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content">

<h2>Dashboard 📊</h2>

<div class="cards">

    <div class="card">
        <h3>Total Orders</h3>
        <div class="value"><?php echo $total_orders; ?></div>
    </div>

    <div class="card">
        <h3>Total Revenue</h3>
        <div class="value">₹<?php echo $total_revenue ?? 0; ?></div>
    </div>

    <div class="card">
        <h3>Menu Items</h3>
        <div class="value"><?php echo $total_menu; ?></div>
    </div>

</div>

<h3 style="margin-top:30px;">Recent Orders</h3>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Total</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($orders)) { ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['customer_name']; ?></td>
    <td>₹<?php echo $row['total']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>