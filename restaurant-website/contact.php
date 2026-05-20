<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "restaurant_db");

$msg = "";
$error_msg = "";

if(isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contact (name, email, message)
              VALUES ('$name', '$email', '$message')";

    if(mysqli_query($conn, $query)) {
        $msg = "Message sent successfully!";
    } else {
        $error_msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - MyRestaurant</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("includes/header.php"); ?>

<!-- Contact Form -->
<div class="contact-container">
    <h2>Contact Us 📩</h2>

    <?php if($msg != ""): ?>
        <p class="msg success-msg"><?php echo $msg; ?></p>
    <?php endif; ?>

    <?php if($error_msg != ""): ?>
        <p class="msg error-msg"><?php echo $error_msg; ?></p>
    <?php endif; ?>

    <form method="post" class="contact-form">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" rows="4" required></textarea>
        <button type="submit" name="send">Send Message</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>