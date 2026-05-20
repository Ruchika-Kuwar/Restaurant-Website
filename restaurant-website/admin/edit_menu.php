<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

$id = $_GET['id'];

// Fetch existing data
$result = mysqli_query($conn, "SELECT * FROM menu WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

$msg = "";

// Update logic
if(isset($_POST['update'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];

    // If new image uploaded
    if(!empty($_FILES['image']['name'])) {

        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, "../assets/images/" . $image);

        $query = "UPDATE menu SET name='$name', price='$price', image='$image' WHERE id='$id'";
    } else {
        $query = "UPDATE menu SET name='$name', price='$price' WHERE id='$id'";
    }

    if(mysqli_query($conn, $query)) {
        $msg = "Updated Successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Menu</title>

<style>
body {
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

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
}

button {
    width: 100%;
    padding: 10px;
    background: blue;
    color: white;
    border: none;
}

img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}
</style>
</head>

<body>

<div class="container">

<h2>Edit Item ✏️</h2>

<p style="color:green;"><?php echo $msg; ?></p>

<form method="post" enctype="multipart/form-data">

    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
    
    <input type="number" name="price" value="<?php echo $row['price']; ?>" required>

    <p>Current Image:</p>
    <img src="../assets/images/<?php echo $row['image']; ?>">

    <input type="file" name="image">

    <button name="update">Update Item</button>

</form>

<br>
<a href="manage_menu.php">← Back</a>

</div>

</body>
</html>