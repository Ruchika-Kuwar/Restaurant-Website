<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

// Delete order
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM orders WHERE id='$id'");
    mysqli_query($conn, "DELETE FROM order_items WHERE order_id='$id'");
}

// Update status
if(isset($_POST['update_status'])) {
    $id = $_POST['order_id'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id='$id'");
}

// Fetch orders
$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Orders</title>

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

/* Table */
table {
    width: 100%;
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

/* Status colors */
.pending { color: orange; font-weight: bold; }
.preparing { color: blue; font-weight: bold; }
.delivered { color: green; font-weight: bold; }

/* Buttons */
.btn {
    padding: 6px 10px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    margin-right: 5px;
    font-size: 14px;
}

.view { background: #3b82f6; }
.delete { background: red; }

select, button {
    padding: 5px;
    margin-top: 5px;
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
    <a href="logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content">

<h2>Manage Orders 📦</h2>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['customer_name']; ?></td>
    <td>₹<?php echo $row['total']; ?></td>

    <td class="<?php echo strtolower($row['status']); ?>">
        <?php echo $row['status']; ?>
    </td>

    <td>

        <!-- ✅ VIEW BUTTON -->
        <a class="btn view" href="order_details.php?id=<?php echo $row['id']; ?>">
            View
        </a>

        <!-- ❌ DELETE BUTTON -->
        <a class="btn delete"
           href="orders.php?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this order?')">
           Delete
        </a>

        <!-- 🔄 STATUS UPDATE -->
        <form method="post">
            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">

            <select name="status">
                <option <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
                <option <?php if($row['status']=="Preparing") echo "selected"; ?>>Preparing</option>
                <option <?php if($row['status']=="Delivered") echo "selected"; ?>>Delivered</option>
            </select>

            <button name="update_status">Update</button>
        </form>

    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>