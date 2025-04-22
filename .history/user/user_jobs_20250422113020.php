<?php
include 'db.php'; // DB connection

$sql = "SELECT * FROM jobs ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>



<h2>Available Jobs</h2>

<?php while($row = mysqli_fetch_assoc($result)): ?>
  <div class="job-card">
    <h3><?php echo $row['title']; ?></h3>
    <p><strong>Company:</strong> <?php echo $row['company']; ?></p>
    <p><strong>Location:</strong> <?php echo $row['address']; ?></p>
    <p><strong>Deadline:</strong> <?php echo $row['valid_till']; ?></p>
    <a href="job_detail.php?id=<?php echo $row['id']; ?>">View Details</a>
  </div>
<?php endwhile; ?>
