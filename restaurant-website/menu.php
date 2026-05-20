<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "restaurant_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add to Cart Logic
if(isset($_POST['add_to_cart'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Create cart if not exists
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If item already exists → increase quantity
    if(isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'qty' => 1
        ];
    }

    echo "<script>alert('Item added to cart');</script>";
}

// Fetch menu data
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f4f4;
        }

        nav {
            background: #333;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 15px;
            text-decoration: none;
            font-size: 18px;
        }

        nav a:hover {
            color: orange;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .menu-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .card {
            background: white;
            width: 220px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .price {
            color: green;
            font-weight: bold;
        }

        button {
            background: orange;
            border: none;
            padding: 10px;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: darkorange;
        }

        
    .footer {
           background: #1e293b;
           color: #cbd5e1;
           padding: 40px 20px 10px;
           margin-top: 40px;
    }

    .footer-bottom {
          text-align: center;
          margin-top: 20px;
          border-top: 1px solid #475569;
          padding-top: 10px;
          font-size: 14px;
    }
        .no-data {
            text-align: center;
            color: red;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<?php include("includes/header.php"); ?>

<h2>Our Menu 🍽️</h2>

<div class="menu-container">

<?php if(mysqli_num_rows($result) > 0) { ?>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="card">
            <img src="assets/images/<?php echo htmlspecialchars($row['image']); ?>">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p class="price">₹<?php echo $row['price']; ?></p>

            <!-- Add to Cart Form -->
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>

        </div>

    <?php } ?>

<?php } else { ?>

    <p class="no-data">No menu items available</p>

<?php } ?>

</div>
 <?php include("includes/footer.php"); ?>

</body>
</html>