<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user']['id'];

// Connect to database
$cn = mysqli_connect("localhost", "root", "", "Medilab");
if (!$cn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch user's appointments with doctor details
$query = "
    SELECT a.*, d.name AS doctor_name, d.education
    FROM appointment a
    JOIN doctors d ON a.doctor_id = d.id
    WHERE a.user_id = $userId
    ORDER BY a.date DESC, a.start_time DESC
";

$result = mysqli_query($cn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('head.php'); ?>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">My Appointments</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Dr. <?= htmlspecialchars($row['doctor_name']) ?> (<?= htmlspecialchars($row['education']) ?>)</h6>
                            <p class="card-text mb-1"><strong>Date:</strong> <?= htmlspecialchars($row['date']) ?></p>
                            <p class="card-text mb-1"><strong>Time:</strong> <?= date("g:i A", strtotime($row['start_time'])) ?> - <?= date("g:i A", strtotime($row['end_time'])) ?></p>
                            <p class="card-text"><strong>Message:</strong> <?= nl2br(htmlspecialchars($row['message'])) ?: 'N/A' ?></p>
                            <span class="badge bg-info text-dark">Status: <?= $row['status'] == 1 ? 'Confirmed' : 'Pending' ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            No appointments found. <a href="appointment.php" class="alert-link">Book now</a>
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
</body>
</html>
