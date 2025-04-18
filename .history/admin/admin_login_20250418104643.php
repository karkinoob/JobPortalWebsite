<!-- <?php
session_start();
require_once("../db.php");

$email = $password = "";
$loginErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ? AND type = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $emailDb, $passwordDb);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $passwordDb)) {
        $_SESSION["admin_id"] = $id;
        $_SESSION["admin_name"] = $name;
        header("Location: dashboard.php");
        exit();
    } else {
        $loginErr = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
        <p style="color:red;"><?php echo $loginErr; ?></p>
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html> -->
