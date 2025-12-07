<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: adminPage/admin.php");
    } else {
        header("Location: userPage/user.php");
    }
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rentels";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if (isset($_POST['signup-btn'])) {
    $username = $conn->real_escape_string($_POST['userName']);
    $email = $conn->real_escape_string($_POST['Email']);
    $password = $_POST['pass'];
    $role = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user(username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        $message = "<div class='success-msg'>Registration successful! Please log in.</div>";
    } else {
        if ($conn->errno == 1062) {
            $message = "<div class='error-msg'>Username or email already exists.</div>";
        } else {
            $message = "<div class='error-msg'>Error during registration: " . $stmt->error . "</div>";
        }
    }
    $stmt->close();
}

if (isset($_POST['login-btn'])) {
    $username = $conn->real_escape_string($_POST['userName']);
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT user_id, username, password, role FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: adminPage/admin.php");
            } else {
                header("Location: userPage/user.php");
            }
            exit();
        } else {
            $message = "<div class='error-msg'>Invalid username or password.</div>";
        }
    } else {
        $message = "<div class='error-msg'>Invalid username or password.</div>";
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
    <link rel="stylesheet" href="Index.css">
    <link rel="icon" href="img/icon wbg.ico" type="image/x-icon">
    <title>Rentals - Login / Sign up</title>
</head>

<body>
    <?php echo $message; ?>
    <form class="login active" method="POST" action="index.php">
        <h3 class="loginHeader">Login</h3>
        <div class="inputGroup">
            <label for="userName">User Name</label>
            <input type="text" name="userName" placeholder="User Name...." required>
        </div>
        <div class="inputGroup">
            <label for="userName">password</label>
            <input type="password" name="pass" placeholder="Password...." required>
        </div>
        <button type="submit" name="login-btn" class="login-btn">Login</button>
        <p class="toggleText">I don't have an Account | <a class="toggleLink">Sign Up</a></p>
    </form>
    <form class="signUp" method="POST" action="index.php">
        <h3 class="loginHeader">Sign Up</h3>
        <div class="inputGroup">
            <label for="userName">User Name</label>
            <input type="text" name="userName" placeholder="User Name...." required>
        </div>
        <div class="inputGroup">
            <label for="userName">Email</label>
            <input type="email" name="Email" placeholder="Email@gmail.com...." required>
        </div>
        <div class="inputGroup">
            <label for="userName">password</label>
            <input type="password" name="pass" placeholder="Password...." minlength="8" required>
        </div>
        <div class="inputGroup">
            <label for="accountType">Account Type</label>
            <select name="role" id="role" required>
                <option value="none" selected> Select Role </option>
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
        </div>
        <button type="submit" class="login-btn" name="signup-btn">Sign Up</button>
        <p class="toggleText">You have an Account | <a class="toggleLink">login</a></p>
    </form>

    <script src="index.js"></script>
</body>

</html>