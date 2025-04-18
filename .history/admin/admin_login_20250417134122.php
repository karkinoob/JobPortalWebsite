<?php
session_start();
include ''../frontend/db.php''; // database connection

$loginErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ? AND type = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $emailDb, $passwordDb);
        $stmt->fetch();

        if (password_verify($password, $passwordDb)) {
            $_SESSION["admin_id"] = $id;
            $_SESSION["admin_name"] = $name;
            $_SESSION["admin_email"] = $emailDb;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $loginErr = "Invalid password";
        }
    } else {
        $loginErr = "No admin found with this email";
    }

    $stmt->close();
}
?>

<!-- HTML form -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <p style="color:red;"><?php echo $loginErr; ?></p>
</body>
</html>
