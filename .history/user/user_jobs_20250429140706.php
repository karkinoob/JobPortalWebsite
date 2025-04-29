<?php
session_start();
include '../db.php';

$sql = "SELECT * FROM jobs ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<h2>Available Jobs</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
  <?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="job-card" style="border:1px solid #ccc; padding:15px; margin-bottom:10px;">
      <h3><?php echo $row['job_title']; ?></h3>
      <p><strong>Company:</strong> <?php echo $row['company_name']; ?></p>
      <p><strong>Location:</strong> <?php echo $row['address']; ?></p>
      <p><strong>Category:</strong> <?php echo $row['job_category']; ?></p>
      <p><strong>Deadline:</strong> <?php echo $row['valid_till']; ?></p>
      <a href="job_detail.php?id=<?php echo $row['id']; ?>">View Details</a>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <p>No jobs available.</p>
<?php endif; ?>
