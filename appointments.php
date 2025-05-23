<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor']['id'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctorId = $_SESSION['doctor']['id'];

// Connect to database
$cn = mysqli_connect("localhost", "root", "", "Medilab");
if (!$cn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch appointments for the logged-in doctor
$query = "
    SELECT a.*, u.name AS patient_name, u.email, u.contact
    FROM appointment a
    JOIN users u ON a.user_id = u.id
    WHERE a.doctor_id = $doctorId
    ORDER BY a.date DESC, a.start_time ASC
";

$result = mysqli_query($cn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('head.php'); ?>

</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">My Appointments</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= date("g:i A", strtotime($row['start_time'])) ?> - <?= date("g:i A", strtotime($row['end_time'])) ?></td>
                        <td><?= htmlspecialchars($row['patient_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['contact']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                        <td>
                            <?php
                                switch ($row['status']) {
                                    case 0: echo '<span class="badge bg-warning">Pending</span>'; break;
                                    case 1: echo '<span class="badge bg-success">Confirmed</span>'; break;
                                    case 2: echo '<span class="badge bg-danger">Cancelled</span>'; break;
                                    default: echo '<span class="badge bg-secondary">Unknown</span>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No appointments found.
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>

</body>
</html>
