<?php
include 'db.php';

$job_id = $_GET['id'];
$sql = "SELECT * FROM jobs WHERE id = $job_id";
$result = mysqli_query($conn, $sql);
$job = mysqli_fetch_assoc($result);
?>

<h2><?php echo $job['title']; ?></h2>
<p><strong>Company:</strong> <?php echo $job['company_name']; ?></p>
<p><strong>Location:</strong> <?php echo $job['address']; ?></p>
<p><strong>Category:</strong> <?php echo $job['job_category']; ?></p>
<p><strong>Deadline:</strong> <?php echo $job['valid_till']; ?></p>
<p><strong>Description:</strong> <?php echo $job['description']; ?></p>

<?php if(isset($_SESSION['user_id'])): ?>
  <a href="apply_job.php?id=<?php echo $job['id']; ?>">Apply Now</a>
<?php else: ?>
  <p><a href="login.php">Login</a> to apply.</p>
<?php endif; ?>
