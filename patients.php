<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor']['id'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctorId = $_SESSION['doctor']['id'];

// Connect to DB
$cn = mysqli_connect("localhost", "root", "", "Medilab");
if (!$cn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch unique patients who booked appointments with this doctor
$query = "
    SELECT DISTINCT u.id, u.name, u.email, u.contact, u.dob
    FROM appointment a
    JOIN users u ON a.user_id = u.id
    WHERE a.doctor_id = $doctorId
    ORDER BY u.name ASC
";

$result = mysqli_query($cn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Patients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('head.php'); ?>
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">My Patients</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Date of Birth</th>
                        <!-- Optional: Add actions like view history -->
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['contact']) ?></td>
                        <td><?= htmlspecialchars($row['dob']) ?></td>
                        <!-- <td><a href="patient_history.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View History</a></td> -->
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No patients found.
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>

</body>
</html>
