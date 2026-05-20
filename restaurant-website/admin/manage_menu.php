<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

// Delete item
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM menu WHERE id='$id'");
}

$result = mysqli_query($conn, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Menu</title>

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
    padding: 20px 0;
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

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.add-btn {
    background: #22c55e;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
}

/* Cards */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px,1fr));
    gap: 20px;
    margin-top: 20px;
}

.card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.card-body {
    padding: 15px;
    text-align: center;
}

.price {
    color: green;
    font-weight: bold;
}

.btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
    color: white;
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
    <a href="logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content">

<div class="topbar">
    <h2>Manage Menu 🍔</h2>
    <a class="add-btn" href="add_menu.php">+ Add Item</a>
</div>

<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="card">
    <img src="../assets/images/<?php echo $row['image']; ?>">
    
    <div class="card-body">
        <h3><?php echo $row['name']; ?></h3>
        <p class="price">₹<?php echo $row['price']; ?></p>

        <a class="btn" style="background:blue;"
           href="edit_menu.php?id=<?php echo $row['id']; ?>">
           Edit
      </a>

        <a class="btn delete"
           href="manage_menu.php?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this item?');">
           Delete
        </a>
    </div>
</div>

<?php } ?>

</div>

</div>

</body>
</html>