<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "restaurant_db");

$error = "";

if(isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        if(password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: dashboard.php");
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "Admin not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg,#141e30,#243b55);
    display:flex;justify-content:center;align-items:center;height:100vh;
}
.box {
    background:white;padding:30px;border-radius:10px;width:300px;text-align:center;
}
input,button {width:100%;padding:10px;margin:10px 0;}
button {background:#243b55;color:white;border:none;}
.error {color:red;}
</style>
</head>
<body>

<div class="box">
<h2>Admin Login</h2>
<?php if($error) echo "<p class='error'>$error</p>"; ?>

<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>

</body>
</html>