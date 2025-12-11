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

if (isset($_POST['interested-btn'])) {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $card_id = $_POST['card_id'];
    $card_name = $_POST['card_name'];

    $stmt = $conn->prepare("INSERT INTO interested (card_id, card_name, user_id, user_email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $card_id, $card_name, $user_id, $user_email);

    if ($stmt->execute()) {
        $message = "<p class='success-msg' >Your interest has been recorded!</p>";
    } else {
        $message = "<p class='error-msg' >Error recording your interest: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentals - Home Page</title>
    <link rel="stylesheet" href="userr.css">
    <link rel="icon" href="../img/icon wbg.ico" type="image/x-icon">
</head>

<body>
    <div class="header" id="header">
        <a href=""><img class="headerImg" src="../img/project logo wbg.png" alt="header logo"></a>
        <nav class="navigationBar">
            <a class="navigationBarLink" href="">
                <img src="../svgs/solid/home.svg" alt="">
                <p>Home</p>
            </a>
            <a class="logOut-btn" href="logout.php" class="logout">
                <img src="../svgs/solid/arrow-right-from-bracket.svg" alt="">
                <p>Logout</p>
            </a>
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
            <div class="message">
                <?php echo $message; ?>
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
                            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
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
                        <form class="cardButton" method="post" action="user.php">
                            <input type="hidden" name="card_id" value="<?php echo htmlspecialchars($product['card_id']); ?>">
                            <input type="hidden" name="card_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                            <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                            <button class="interested-btn" name="interested-btn">interested</button>
                        </form>
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
    <script src="userr.js"></script>
</body>

</html>