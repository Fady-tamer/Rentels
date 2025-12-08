<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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

if (isset($_POST['card-btn'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = (float) $_POST['price'];
    $description = $conn->real_escape_string($_POST['description']);
    $image_url = $conn->real_escape_string($_POST['imgURL']);
    $area = (float) $_POST['area'];
    $bed_rooms = (int) $_POST['bed-rooms'];
    $bath_rooms = (int) $_POST['bath-rooms'];

    $stmt = $conn->prepare("INSERT INTO carddata (name, description, imgURL, price, Area, bedRooms, bathRooms) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $description, $image_url, $price, $area, $bed_rooms, $bath_rooms);

    if ($stmt->execute()) {
        $message = "<div class='success-msg'>✅ Product added successfully!</div>";
    } else {
        $message = "<div class='error-msg'>❌ Error: " . $stmt->error . "</div>";
    }
}

$products = [];

$sql_fetch = "SELECT card_id, name,description, imgURL, price, Area, bedRooms, bathRooms FROM carddata ORDER BY card_id";
$result_fetch = $conn->query($sql_fetch);

if ($result_fetch) {
    while ($row = $result_fetch->fetch_assoc()) {
        $products[] = $row;
    }
}

if (isset($_POST['delete_card'])) {
    $card_id = filter_input(INPUT_POST, 'card_id', FILTER_VALIDATE_INT);
    $stmt = $conn->prepare("DELETE FROM carddata WHERE card_id = ?");
    $stmt->bind_param("i", $card_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $message .= "<div class='success-msg'>Product deleted successfully.</div>";
        header("Location: admin.php");
    } else {
        $message .= "<div class='error-msg'>Error deleting product: " . $conn->error . "</div>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentals - Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" href="../img/icon wbg.png" type="image/x-icon">
</head>

<body>
    <div class="header" id="header">
        <a href=""><img class="headerImg" src="../img/project logo wbg.png" alt="header logo"></a>
        <nav class="navigationBar">
            <a class="navigationBarLink" href="">Admin Dashboard</a>
            <a class="navigationBarLink" onclick="displayAddCard()">Add Card</a>
            <a class="logOut-btn" href="logout.php" class="logout">Logout</a>
        </nav>
    </div>
    <div class="content" id="content">
        <?php echo $message; ?>
        <div class="cardContainer" id="cardContainer">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="card">
                        <img class="cardImg" src="<?php echo htmlspecialchars($product['imgURL']) ?>" alt="card img">
                        <div class="cardInfo">
                            <div class="cardDescription">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <h3>$<?php echo htmlspecialchars($product['price']); ?></h3>
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
                        <form action="admin.php" method="POST" class="cardButton">
                            <input type="hidden" name="card_id" value="<?php echo $product['card_id'] ?>">
                            <button type="submit" name="delete_card">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="CardForm" id="CardForm">
        <form class="addCardForm" action="admin.php" method="POST">
            <h1 class="formHeader">Add Card</h1>
            <div class="inputGroup">
                <label for="userName">Name</label>
                <input type="text" name="name" placeholder="Name...." required>
            </div>
            <div class="inputGroup">
                <label for="userName">Description</label>
                <input type="text" name="description" placeholder="Description...." required>
            </div>
            <div class="inputGroup">
                <label for="userName">img</label>
                <input type="text" name="imgURL" placeholder="img url...." required>
            </div>
            <div class="inputGroup">
                <label for="userName">Price</label>
                <input type="number" name="price" placeholder="Price...." required>
            </div>
            <div class="inputGroup">
                <label for="userName">Area</label>
                <input type="number" name="area" placeholder="Area...." required>
            </div>
            <div class="inputGroup">
                <label for="userName">Bed Rooms</label>
                <input type="number" name="bed-rooms" placeholder="3" required>
            </div>
            <div class="inputGroup">
                <label for="userName">Bath Room</label>
                <input type="number" name="bath-rooms" placeholder="2" required>
            </div>
            <div class="form-btn">
                <button type="submit" name="card-btn" class="submit-btn">Submit</button>
                <a class="cancel-btn" onclick="cancelAddCard()">Cancel</a>
            </div>
        </form>
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
    <script src="admin.js"></script>
</body>

</html>