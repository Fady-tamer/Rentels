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

$mess = [];

$sql_fetch = "SELECT card_id, card_name, user_id, user_email FROM interested ORDER BY card_id DESC";
$result_fetch = $conn->query($sql_fetch);

if ($result_fetch) {
    while ($row = $result_fetch->fetch_assoc()) {
        $messages[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentals - Messages</title>
    <link rel="stylesheet" href="messages.css">
    <link rel="icon" href="../img/icon wbg.ico" type="image/x-icon">
</head>

<body>
    <div class="header" id="header">
        <a href=""><img class="headerImg" src="../img/project logo wbg.png" alt="header logo"></a>
        <nav class="navigationBar">
            <a class="navigationBarLink" href="admin.php">
                <img src="../svgs/solid/home.svg" alt="">
                <p>Admin Dashboard</p>
            </a>
            <a class="logOut-btn" href="logout.php" class="logout">
                <img src="../svgs/solid/arrow-right-from-bracket.svg" alt="">
                <p>Logout</p>
            </a>
        </nav>
    </div>
    <div class="page-container">
        <div class="title-box">
            <h2 class="page-title">Messages</h2>
        </div>
        <div class="messages-container">
            <?php foreach ($messages as $message): ?>
                <div class="message-card">
                    <p class="msg-product-name"><?php echo htmlspecialchars(string: $message['card_name']); ?></p>
                    <div>
                        <p class="msg-product-id">Card ID: <?php echo $message['card_id']; ?></p>
                        <p class="msg-product-id">User ID: <?php echo $message['user_id']; ?></p>
                    </div>
                    <p class="msg-product-email">Contact Email: <?php echo $message['user_email']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="admin.js"></script>
</body>

</html>