<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","restaurant_db");

$user_id = $_SESSION['user_id'];

// Fetch user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

$msg = "";

// Update profile
if(isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = "UPDATE users 
              SET name='$name', email='$email', phone='$phone', address='$address' 
              WHERE id='$user_id'";

    if(mysqli_query($conn, $query)) {
        $_SESSION['user_name'] = $name;
        $msg = "Profile updated!";
    }
}

// Change password
if(isset($_POST['change_password'])) {

    $old = $_POST['old_password'];
    $new = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    if(password_verify($old, $user['password'])) {

        mysqli_query($conn, "UPDATE users SET password='$new' WHERE id='$user_id'");
        $msg = "Password changed!";
    } else {
        $msg = "Wrong old password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<link rel="stylesheet" href="assets/css/style.css">

<style>
.container {
    width: 450px;
    margin: 60px auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
}

button {
    width: 100%;
    padding: 10px;
    background: #1e293b;
    color: white;
    border: none;
    cursor: pointer;
}

.msg {
    color: green;
    text-align: center;
}
</style>

</head>

<body>

<?php include("includes/header.php"); ?>

<div class="container">

<h2>My Profile 👤</h2>

<p class="msg"><?php echo $msg; ?></p>

<!-- Update Profile -->
<form method="post">
    <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    
    <input type="text" name="phone" placeholder="Mobile Number"
           value="<?php echo $user['phone'] ?? ''; ?>" required>

    <textarea name="address" placeholder="Address" required><?php echo $user['address'] ?? ''; ?></textarea>

    <button name="update">Update Profile</button>
</form>

<hr>

<!-- Change Password -->
<form method="post">
    <input type="password" name="old_password" placeholder="Old Password" required>
    <input type="password" name="new_password" placeholder="New Password" required>

    <button name="change_password">Change Password</button>
</form>

</div>

</body>
</html>