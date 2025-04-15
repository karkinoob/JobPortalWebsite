<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
          crossorigin="anonymous">
</head>

<body>
<?php
include 'db.php'; 

$name = $email = $contact = $password = "";
$nameErr = $emailErr = $contactErr = $passwordErr = "";
$success = "";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) $nameErr = "Name is required";
    else $name = test_input($_POST["name"]);

    if (empty($_POST["email"])) $emailErr = "Email is required";
    else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) $emailErr = "Invalid email format";
    else $email = test_input($_POST["email"]);

    if (empty($_POST["contact"])) $contactErr = "Contact number is required";
    else $contact = test_input($_POST["contact"]);

    if (empty($_POST["password"])) $passwordErr = "Password is required";
    else if (strlen($_POST["password"]) < 6) $passwordErr = "Password must be at least 6 characters";
    else $password = password_hash(test_input($_POST["password"]), PASSWORD_DEFAULT);

    if (!$nameErr && !$emailErr && !$contactErr && !$passwordErr) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, contact_number, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $contact, $password);
        if ($stmt->execute()) {
            $success = "Registration successful. <a href='login.php'>Login now</a>";
            $name = $email = $contact = "";
        } else {
            $emailErr = "Email already exists or failed to register.";
        }
        $stmt->close();
    }
}
?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Register</h2>
                <form>
                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input type="username" class="form-control" id="exampleusername" aria-describedby="userhelp">
                    </div>

                    <div class="mb-3">
                        <label for="Email" class="form-label">Email address</label>
                        <input type="tel" class="form-control" id="Email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </form>

                <div class="mt-3 text-center">
                    <a href="login.php" class="text-decoration-none">Already have an account? <strong>Login</strong></a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
            crossorigin="anonymous"></script>
</body>

</html>