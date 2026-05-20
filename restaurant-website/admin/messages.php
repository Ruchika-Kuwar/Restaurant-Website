<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

// Delete message
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM contact WHERE id='$id'");
}

// Fetch messages
$result = mysqli_query($conn, "SELECT * FROM contact ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Messages</title>

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

/* Button */
.btn {
    padding: 6px 10px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
}

.delete {
    background: red;
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

<h2>Customer Messages 📩</h2>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['message']; ?></td>
    <td><?php echo $row['created_at']; ?></td>

    <td>
        <a class="btn delete"
           href="messages.php?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this message?')">
           Delete
        </a>

    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>