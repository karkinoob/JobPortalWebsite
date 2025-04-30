<?php
session_start();
include 'db.php'; // connect to database

// Fetch jobs
$result = mysqli_query($conn, "SELECT * FROM jobs WHERE valid_till >= CURDATE() ORDER BY created_at DESC");
$job_count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<input type="text" name="search" placeholder="Search by job title or company.." value="<?php echo isset($_GET['search'])> ? htmlspecialchars($)
<div class="container mt-5">
    <h2>Available Jobs (<?php echo $job_count; ?>)</h2>

    <?php
    if ($job_count > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title text-primary"><?php echo $row['job_title']; ?></h4>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['company_name']; ?> - <?php echo $row['job_category']; ?></h6>
                <p class="card-text"><?php echo substr($row['job_description'], 0, 100); ?>...</p>
                <p><strong>Location:</strong> <?php echo $row['address']; ?></p>
                <p><strong>Valid Till:</strong> <?php echo $row['valid_till']; ?></p>
                <a href="job_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
            </div>
        </div>
    <?php
        }
    } else {
        echo "<div class='alert alert-info'>No jobs found.</div>";
    }
    ?>
</div>

</body>
</html>


















<!-- <form method="GET" action="">
    <input type="text" name="search" placeholder="Search by job title or company..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit">Search</button>
</form> -->
