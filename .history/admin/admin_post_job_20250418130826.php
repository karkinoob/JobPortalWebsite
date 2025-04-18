<?php
session_start();


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post New Job</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f2f2f2; }
        .form-container {
            background: white; padding: 30px; width: 500px; margin: auto;
            border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label { font-weight: bold; }
        input[type="text"], input[type="date"], textarea, select {
            width: 100%; padding: 10px; margin: 5px 0 15px;
        }
        input[type="submit"] {
            padding: 10px 20px; background: green; color: white; border: none;
            cursor: pointer; border-radius: 5px;
        }
        input[type="submit"]:hover { background: darkgreen; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Post a New Job</h2>
    <form action="admin_store_job.php" method="POST">
        <label>Company Name:</label>
        <input type="text" name="company_name" required>

        <label>Job Title:</label>
        <input type="text" name="job_title" required>

        <label>Job Description:</label>
        <textarea name="job_description" rows="5" required></textarea>

        <label>Address:</label>
        <input type="text" name="address" required>

        <label>Category:</label>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="IT">IT</option>
            <option value="AI">AI</option>
            <option value="Design">Design</option>
            <option value="Sales">Sales</option>
            <option value="Support">Support</option>
        </select>

        <label>Valid Till:</label>
        <input type="date" name="valid_till" required>

        <input type="submit" value="Post Job">
    </form>
</div>

</body>
</html>
