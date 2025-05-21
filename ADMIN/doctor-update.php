<?php
session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$conn = mysqli_connect("localhost", "root", "", "medilab");

// Handle Update
if (isset($_POST["update"])) {
    $pic = $_POST["existing_pic"];
    if ($_FILES["pic"]["name"] != "") {
        $pic = $_FILES["pic"]["name"];
        $target = "img/" . $pic;
        move_uploaded_file($_FILES["pic"]["tmp_name"], $target);
    }

    $sql = "UPDATE doctors SET 
        name = '{$_POST['name']}',
        designation = '{$_POST['designation']}',
        specialization = '{$_POST['specialization']}',
        experience_in_years = {$_POST['experience_in_years']},
        email = '{$_POST['email']}',
        password = '{$_POST['password']}',
        phone = '{$_POST['phone']}',
        location = '{$_POST['location']}',
        bio = '{$_POST['bio']}',
        appointment_duration = {$_POST['appointment_duration']},
        pic = '{$pic}'
        WHERE id = {$doctor_id}";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profile updated successfully.');</script>";
    } else {
        echo "<script>alert('Update failed.');</script>";
    }
}

// Fetch doctor details
$result = mysqli_query($conn, "SELECT * FROM doctors WHERE id = $doctor_id");
$doctor = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <?php include('head.php'); ?>
    <style>
        .form-group { margin-bottom: 15px; } 
        img { max-height: 120px; }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<div class="container" style="margin-top:30px; margin-bottom:30px;">
    <h2 class="text-center">Update Your Profile</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>ID (Read-Only)</label>
            <input type="text" class="form-control" value="<?php echo $doctor['id']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input name="name" type="text" class="form-control" value="<?php echo $doctor['name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Designation</label>
            <input name="designation" type="text" class="form-control" value="<?php echo $doctor['designation']; ?>" required>
        </div>
        <div class="form-group">
            <label>Specialization</label>
            <input name="specialization" type="text" class="form-control" value="<?php echo $doctor['specialization']; ?>" required>
        </div>
        <div class="form-group">
            <label>Experience (Years)</label>
            <input name="experience_in_years" type="number" class="form-control" value="<?php echo $doctor['experience_in_years']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="<?php echo $doctor['email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input name="password" type="text" class="form-control" value="<?php echo $doctor['password']; ?>" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input name="phone" type="text" class="form-control" value="<?php echo $doctor['phone']; ?>" required>
        </div>
        <div class="form-group">
            <label>Location</label>
            <input name="location" type="text" class="form-control" value="<?php echo $doctor['location']; ?>">
        </div>
        <div class="form-group">
            <label>Bio</label>
            <input name="bio" type="text" class="form-control" value="<?php echo $doctor['bio']; ?>">
        </div>
        <div class="form-group">
            <label>Appointment Duration (minutes)</label>
            <input name="appointment_duration" type="number" class="form-control" value="<?php echo $doctor['appointment_duration']; ?>">
        </div>
        <div class="form-group">
            <label>Current Profile Picture</label><br>
            <?php if (!empty($doctor['pic'])): ?>
                <img src="img/<?php echo $doctor['pic']; ?>" alt="Doctor Picture">
            <?php else: ?>
                <p>No image uploaded</p>
            <?php endif; ?>
            <input type="hidden" name="existing_pic" value="<?php echo $doctor['pic']; ?>">
        </div>
        <div class="form-group">
            <label>Change Picture</label>
            <input name="pic" type="file" class="form-control">
        </div>
        <button name="update" type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php include('footer.php'); ?>
</body>
</html>
