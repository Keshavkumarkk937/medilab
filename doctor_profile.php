<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor']['id'])) {
    header("Location: doctor_login.php"); // Redirect to login if not logged in
    exit();
}

$doctorId = $_SESSION['doctor']['id'];

// Connect to database
$cn = mysqli_connect("localhost", "root", "", "Medilab");
if (!$cn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch doctor profile data
$query = "SELECT * FROM doctors WHERE id = $doctorId LIMIT 1";
$result = mysqli_query($cn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Doctor profile not found.");
}

$doctor = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Doctor Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <?php include('head.php'); ?>

</head>
<body>

<?php include('header.php'); ?>

<div class="container my-5">
    <h2 class="mb-4 text-center">My Profile</h2>
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h4 class="card-title mb-3"><?= htmlspecialchars($doctor['name']) ?></h4>
            <p><strong>Email:</strong> <?= htmlspecialchars($doctor['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($doctor['contact']) ?></p>
            <p><strong>Specialization:</strong> <?= htmlspecialchars($doctor['specialization']) ?></p>
            <p><strong>Experience:</strong> <?= htmlspecialchars($doctor['experience']) ?> years</p>
            <p><strong>Qualification:</strong> <?= htmlspecialchars($doctor['qualification']) ?></p>
            <p><strong>Appointment Duration:</strong> <?= htmlspecialchars($doctor['appointment_duration']) ?> minutes</p>
            <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($doctor['address'])) ?></p>
            <!-- Add more fields if needed -->

            <div class="mt-4 text-center">
                <a href="doctor_edit_profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>
