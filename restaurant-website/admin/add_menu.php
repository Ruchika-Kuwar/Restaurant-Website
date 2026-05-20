<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

$msg = "";

if(isset($_POST['add'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "../assets/images/" . $image);

    $query = "INSERT INTO menu (name, price, image)
              VALUES ('$name', '$price', '$image')";

    if(mysqli_query($conn, $query)) {
        $msg = "Item Added Successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Menu</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f4f6f9;
}

.container {
    width: 400px;
    margin: 80px auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
}

button {
    width: 100%;
    padding: 10px;
    background: #22c55e;
    border: none;
    color: white;
    cursor: pointer;
}

.msg {
    color: green;
    text-align: center;
}
</style>
</head>

<body>

<div class="container">

<h2>Add Food Item 🍔</h2>

<p class="msg"><?php echo $msg; ?></p>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Food Name" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="file" name="image" required>
    <button name="add">Add Item</button>
</form>

<br>
<a href="manage_menu.php">← Back</a>

</div>

</body>
</html>