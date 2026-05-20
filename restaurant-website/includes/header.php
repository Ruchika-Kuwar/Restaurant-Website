<?php
// Start session safely
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<!-- HAMBURGER -->
<div class="menu-toggle" onclick="openSidebar()">☰</div>

<!-- SIDEBAR (LEFT SLIDE MENU) -->
<div id="sidebar" class="sidebar">

    <!-- CLOSE BUTTON -->
    <span class="close-btn" onclick="closeSidebar()">×</span>

    <!-- MENU LINKS -->
    <a href="index.php">🏠 Home</a>
    <a href="about.php">📄 About</a>
    <a href="menu.php">🍔 Menu</a>
    <a href="cart.php">🛒 Cart</a>
    <a href="contact.php">📩 Contact</a>

    <hr style="border-color:#334155;">

    <?php if(isset($_SESSION['user_id'])) { ?>

        <a href="profile.php">👤 My Profile</a>
        <a href="order_history.php">📦 My Orders</a>
        <a href="logout.php">🚪 Logout</a>

    <?php } else { ?>

        <a href="login.php">🔐 User Login</a>
        <a href="admin/login.php">🛠️ Admin Login</a>
        <a href="register.php">📝 Register</a>

    <?php } ?>

</div>

<!-- OVERLAY -->
<div id="overlay" onclick="closeSidebar()"></div>

<!-- NAVBAR -->
<div class="navbar">

    <!-- LOGO -->
    <div class="logo">🍽️ MyRestaurant</div>

    <!-- DESKTOP MENU -->
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="contact.php">Contact</a>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">

        <?php if(isset($_SESSION['user_id'])) { ?>

            <div class="profile" onclick="toggleDropdown()">
                👤 <?php echo $_SESSION['user_name']; ?>

                <div class="dropdown" id="userDropdown">
                    <a href="profile.php">My Profile</a>
                    <a href="order_history.php">My Orders</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>

        <?php } else { ?>

            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>

        <?php } ?>

    </div>

</div>

<!-- JAVASCRIPT -->
<script>

// OPEN SIDEBAR
function openSidebar() {
    document.getElementById("sidebar").style.left = "0";
    document.getElementById("overlay").style.display = "block";
}

// CLOSE SIDEBAR
function closeSidebar() {
    document.getElementById("sidebar").style.left = "-260px";
    document.getElementById("overlay").style.display = "none";
}

// TOGGLE USER DROPDOWN
function toggleDropdown() {
    let dropdown = document.getElementById("userDropdown");

    // Close all first
    document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');

    // Toggle current
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
}

// CLOSE DROPDOWN WHEN CLICK OUTSIDE
document.addEventListener("click", function(e) {
    if (!e.target.closest('.profile')) {
        document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');
    }
});

</script>