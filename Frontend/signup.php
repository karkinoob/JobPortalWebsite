<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <form action="register.php"></form>
    <h1>Signup</h1>
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
    </div>
    <div>
        <label for="contactnumber">ContactNumber:</label>
        <input type="text" name="Phone Number"> 
    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="text" name="password" id="password">
    </div>
    <div>
        <label for="passwordagain">PasswordAgain:</label>
        <input type="text" name="passwordagain" id="passwordagain">
    </div>
    <button type="submit">Register</button>
    <footer>Already Register? <a href="login.php">Login Here</a></footer>
</body>
</html>