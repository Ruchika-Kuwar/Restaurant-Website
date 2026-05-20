<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - MyRestaurant</title>

    <!-- Mobile Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
</head>

<body>

<!-- Navbar -->
<?php include("includes/header.php"); ?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to MyRestaurant 🍽️</h1>
        <p>Fresh • Delicious • Fast Delivery</p>
        <a href="menu.php" class="hero-btn">Order Now</a>
    </div>
</section>

<!-- Footer -->
<?php include("includes/footer.php"); ?>

</body>
</html>