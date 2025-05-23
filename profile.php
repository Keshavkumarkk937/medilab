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
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user data
$query = mysqli_query($cn, "SELECT * FROM users WHERE id = $userId");
if (!$query || mysqli_num_rows($query) == 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('head.php'); ?>

</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">My Profile</h2>

    <div class="card mx-auto shadow" style="max-width: 500px;">
        <div class="card-body">
            <h5 class="card-title">Welcome, <?= htmlspecialchars($user['name']) ?></h5>
            <hr>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Contact:</strong> <?= htmlspecialchars($user['contact']) ?></p>
            <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['dob']) ?></p>
            <a href="edit_profile.php" class="btn btn-primary mt-3">Edit Profile</a>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>
