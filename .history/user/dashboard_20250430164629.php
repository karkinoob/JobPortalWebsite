<?php
session_start();

if (!isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_type"] === "admin") {
    header("Location: ../admin/admin_dashboard.php");
    exit();
}

include '../db.php';

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

$stmt = $conn->prepare("SELECT id, job_title, job_description FROM jobs ORDER BY id DESC");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($job_id, $job_title, $job_description);

$jobList = [];
while ($stmt->fetch()) {
    $jobList[] = [
        'id' => $job_id,
        'title' => $job_title,
        'description' => $job_description
    ];
}
$stmt->close();

// echo '<pre>';
// print_r($jobList);
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">User Dashboard</span>

            <div class="dropdown ms-auto">
                <button class="btn btn-dark dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User" width="32" height="32" class="rounded-circle me-2">
                    <span><?= htmlspecialchars($user_name) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li class="dropdown-header text-center">
                        <div><strong><?= htmlspecialchars($user_name) ?></strong></div>
                        <small class="text-muted"><?= htmlspecialchars($user_email) ?></small>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="edit_profile.php">Edit Profile</a></li>
                    <li><a class="dropdown-item text-danger" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="card-body">
        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search job title or description">
        </div>

        <div id="jobResults">
            <?php if (!empty($jobList)): ?>
                <div class="list-group">
                    <?php 
                    $count = 0;
                    foreach ($jobList as $key => $job): 
                        // echo $key;
                        ?>
                        <div class="list-group-item">
                            <!-- <h1>
                                <?php
                                    if($count == 0){
                                        echo 'first';
                                    }else{
                                        echo $count;
                                    }
                                ?>
                                <?= ($count==0) ? ('first') : $count ?>
                            </h1> -->
                            <h5 class="mb-1"><?= htmlspecialchars($job['title']) ?></h5>
                            <p class="mb-1"><?= htmlspecialchars($job['description']) ?></p>
                            <div class="d-flex">
                                <a href="job_detail.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-primary me-2">View Details</a>
                                <a href="apply_job.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-success">Apply</a>
                            </div>
                        </div>
                    <?php $count++; endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">No jobs listed yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            const query = $(this).val().trim();
            $.ajax({
                url: 'search_jobs.php',
                method: 'GET',
                data: {
                    q: query
                },
                success: function(response) {
                    $('#jobResults').html(response);
                },
                error: function() {
                    $('#jobResults').html('<p class="text-danger">Error loading results.</p>'); 
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</html>