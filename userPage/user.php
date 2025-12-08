<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rentels";
$message = '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$products = [];

$sql_fetch = "SELECT card_id, name,description, imgURL, price, Area, bedRooms, bathRooms FROM carddata ORDER BY card_id";
$result_fetch = $conn->query($sql_fetch);

if ($result_fetch) {
    while ($row = $result_fetch->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentals - Home Page</title>
    <link rel="stylesheet" href="user.css">
    <link rel="icon" href="../img/icon wbg.ico" type="image/x-icon">
</head>

<body>
    <div class="header" id="header">
        <a href=""><img class="headerImg" src="../img/project logo wbg.png" alt="header logo"></a>
        <nav class="navigationBar">
            <a class="navigationBarLink" href="">Home</a>
            <a class="navigationBarLink" href="">About Us</a>
            <a class="logOut-btn" href="logout.php" class="logout">Logout</a>
        </nav>
    </div>
    <div class="content" id="content">
        <div class="contentHeader">
            <h1>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
                welcome to Rental group<br>
            </h1>
            <span>A place to find a place</span>
            <h3>Find your dream house by us</h3>
            <a href="#cardContainer" class="contentHeader-btn"> view</a>
        </div>
        <div class="searchCardContainer">
            <div class="search">
                <img src="../svgs/solid/search.svg" alt="Search icon">
                <input type="search" id="search" onkeyup="search()" placeholder="Search...">
            </div>
        </div>
        <div class="cardContainer" id="cardContainer">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="card">
                        <img class="cardImg" src="<?php echo htmlspecialchars($product['imgURL']) ?>" alt="card img">
                        <div class="cardInfo">
                            <div class="cardDescription">
                                <h3 class="cardName"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <h3>$<?php echo htmlspecialchars($product['price']); ?>/mon</h3>
                            </div>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                            <div class="cardNavigation">
                                <div class="cardIcon">
                                    <p><?php echo htmlspecialchars($product['bedRooms']) ?><img src="../svgs/solid/bed.svg"
                                            alt=""></p>
                                    <p><?php echo htmlspecialchars($product['bathRooms']) ?><img src="../svgs/solid/bath.svg"
                                            alt=""></p>
                                </div>
                                <p class="area"><?php echo htmlspecialchars($product['Area']) ?> CM&sup3;</p>
                            </div>
                        </div>
                        <div class="cardButton">
                            <button class="interested-btn" onclick="openModal()">interested</button>
                        </div>
                        <div id="customAlert" class="modal">
                            <div class="modal-content">
                                <p class="modalMessage">Thank you for your interest!</p>
                                <p class="modalMessage">We will contact you soon.</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer" id="footer">
        <div class="footerLink">
            <a href="#">
                <img src="../svgs/brands/facebook.svg" alt="">
            </a>
            <a href="#">
                <img src="../svgs/brands/instagram.svg" alt="">
            </a>
            <a href="#">
                <img src="../svgs/brands/github.svg" alt="">
            </a>
            <a href="#">
                <img src="../svgs/brands/linkedin.svg" alt="">
            </a>
            <a href="mailto:">
                <img src="../svgs/solid/envelope.svg" alt="">
            </a>
        </div>
        <p>&copy; 2025 All rights reserved.</p>
    </div>
    <script src="user.js"></script>
</body>

</html>