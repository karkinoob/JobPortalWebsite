<?php
session_start(); 

include "helper.php"; 
include 'db.php'; 

if (isset($_SESSION["admin_id"])) { 
    header("Location: ../admin/admin_dashboard.php"); 
    exit();
}

$email = $password = ""; 
$emailErr = $passwordErr = $loginErr = ""; 


if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    if (empty($_POST["email"])) { 
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($emailErr) && empty($passwordErr)) {

        $stmt = $conn->prepare("SELECT id, name, email, type, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $emailDb,  $type, $passwordDb);
        $stmt->fetch();



        if ($stmt->num_rows > 0 && password_verify($password, $passwordDb)) {

            $_SESSION["user_id"] = $id;
            $_SESSION["user_name"] = $name;
            $_SESSION["user_email"] = $email;
            $_SESSION["user_type"] = $type;


            if ($type === "user") {
                header("Location: /user/dashboard.php");
            } else {
                header("Location: ../admin/admin_dashboard.php");
            }
            exit();
        } else {
            $loginErr = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login</h2>

                <?php if ($loginErr) echo "<div class='alert alert-danger'>$loginErr</div>"; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                        <small class="text-danger"><?= $emailErr ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-danger"><?= $passwordErr ?></small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <a href="signup.php" class="text-decoration-none">Don't have an account? <strong>Sign Up</strong></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>