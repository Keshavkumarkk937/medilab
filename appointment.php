<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('head.php'); ?>
</head>
<body>

<?php include('header.php'); ?>

<?php

$cn = mysqli_connect("localhost", "root", "", "Medilab");

if (!$cn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch logged-in user data
$userData = [];
if (isset($_SESSION['user']['id'])) {
    $userId = $_SESSION['user']['id'];
    $query = mysqli_query($cn, "SELECT * FROM users WHERE id = $userId");

    if ($query && mysqli_num_rows($query) > 0) {
        $userData = mysqli_fetch_assoc($query);
    }
} else {
    die("User not logged in.");
}

// Fetch doctors
$doctors = [];
$query2 = mysqli_query($cn, "SELECT * FROM doctors");
while ($row = mysqli_fetch_assoc($query2)) {
    $doctors[] = $row;
}

// Handle form submission
if (isset($_POST['title']) && isset($_POST['doctor'])) {

    // Sanitize inputs
    $title = mysqli_real_escape_string($cn, $_POST['title']);
    $message = mysqli_real_escape_string($cn, $_POST['message']);
    $doctorId = (int)$_POST['doctor'];
    $appointmentDate = mysqli_real_escape_string($cn, $_POST['date']);
    $start_time = mysqli_real_escape_string($cn, $_POST['time']);
    $end_time = $_POST['end_time'];

    // Insert into database
    $insertQuery = "INSERT INTO appointment (user_id, doctor_id, date, start_time,end_time, title, message)
                    VALUES ($userId, $doctorId, '$appointmentDate', '$start_time', '$end_time', '$title', '$message')";
    
    if (mysqli_query($cn, $insertQuery)) {
        echo "<script>alert('Appointment booked successfully.'); window.location.href='appointment.php';</script>";
    } else {
        echo "Error: " . mysqli_error($cn);
    }
}
?>

<!-- Appointment Section -->
<section id="appointment" class="appointment section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Appointment</h2>
  <p>Book your appointment with ease and convenience — anytime, anywhere.
     Get timely care from our trusted medical professionals.</p>
</div><!-- End Section Title -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <form action="appointment.php" method="post" role="form" class="form">
    <div class="row">
      <div class="col-md-3 form-group">
        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" value="<?= $userData['name']?>" required readonly>
      </div>
      <div class="col-md-3 form-group mt-3 mt-md-0">
        <input type="text" class="form-control" name="email" id="email" placeholder="Your Email"  value="<?= $userData['email']?>" required readonly>
      </div>
      <div class="col-md-3 form-group mt-3 mt-md-0">
        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone"  value="<?= $userData['contact']?>" required readonly>
      </div>
      <div class="col-md-3 form-group mt-3 mt-md-0">
        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone"  value="<?= $userData['dob']?>" required readonly>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 form-group mt-3">
        <input type="date" name="date" class="form-control" id="date" required>
      </div>

      <div class="col-md-3 form-group mt-3">
        <input type="time" name="time" class="form-control" id="date" required>
      </div>

      <div class="col-md-3 form-group mt-3">
        <input type="time" name="end_time" class="form-control" id="date" required>
      </div>

      <!-- <div class="col-md-3 form-group mt-3">
        <select name="end_time" id="end_time" class="form-select" required>
          <option value="">Select Duration</option>
          <option value="15">15 Minutes</option>
          <option value="30">30 Minutes</option>
          <option value="45">45 Minutes</option>
          <option value="60">1 Hour</option>
        </select>
      </div> -->

      <div class="col-md-3 form-group mt-3">
        <select name="doctor" id="doctor" class="form-select" required>
          <option value="">Select Doctor</option>
          <?php
            $doctors = [];
            $query2 = mysqli_query($cn, "SELECT * FROM doctors");
            
            while ($row = mysqli_fetch_assoc($query2)) {
                $doctors[] = $row;
            }
            foreach ($doctors as $doctor) {
              echo '<option value="' . htmlspecialchars($doctor['id']) . '">' . ucwords(htmlspecialchars($doctor['name'])) . '</option>';
            }
          ?>
        </select>
      </div>
    </div>


    <div class="form-group mt-3">
    <div class="col-md form-group">
        <input type="text" name="title" class="form-control" id="name" placeholder="Disease" value="" required>
      </div>
    </div>
    <div class="form-group mt-3">
      <textarea class="form-control" name="message" rows="5" placeholder="Message (Optional)"></textarea>
    </div>

    <div class="mt-3">
      <div class="loading">Loading</div>
      <div class="error-message"></div>
      <div class="sent-message">Your appointment request has been sent successfully. Thank you!</div>

      <div class="text-center">
        <button type="submit" name="submit" class="btn btn-primary">Make an Appointment</button>      
      </div>
    </div>
  </form>

</div>

</section><!-- /Appointment Section -->

<?php include('footer.php'); ?>   
</body>
</html>
