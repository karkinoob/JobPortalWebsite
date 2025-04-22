<?php
include '<div class="">db.php'; // DB connection

$sql = "SELECT * FROM jobs ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Query failed: " . mysqli_error($conn);
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo "No jobs found.";
}

?>



<h2>Available Jobs</h2>

<?php while($row = mysqli_fetch_assoc($result)): ?>
  <div class="job-card">
    <h3><?php echo $row['title']; ?></h3>
    <p><strong>Company:</strong> <?php echo $row['company_name']; ?></p>
    <p><strong>Location:</strong> <?php echo $row['address']; ?></p>
    <p><strong>Deadline:</strong> <?php echo $row['valid_till']; ?></p>
    <a href="job_detail.php?id=<?php echo $row['id']; ?>">View Details</a>
  </div>
<?php endwhile; ?>
