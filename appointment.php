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

  <form action="forms/appointment.php" method="post" role="form" class="php-email-form" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-4 form-group">
        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
      </div>
      <div class="col-md-4 form-group mt-3 mt-md-0">
        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
      </div>
      <div class="col-md-4 form-group mt-3 mt-md-0">
        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 form-group mt-3">
        <input type="datetime-local" name="date" class="form-control" id="date" required>
      </div>
      <div class="col-md-4 form-group mt-3">
        <input type="file" name="file" class="form-control" placeholder="Submit your report">
      </div>
      <div class="col-md-4 form-group mt-3">
        <select name="doctor" id="doctor" class="form-select" required>
          <option value="">Select Doctor</option>
          <?php
          $query2 = mysqli_query($cn, "SELECT * FROM doctors");
          while ($doctor = mysqli_fetch_assoc($query2)) {
              echo '<option value="' . htmlspecialchars($doctor['id']) . '">' . ucwords(htmlspecialchars($doctor['name'])) . '</option>';
          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group mt-3">
      <textarea class="form-control" name="message" rows="5" placeholder="Message (Optional)"></textarea>
    </div>
    <div class="mt-3">
      <div class="loading">Loading</div>
      <div class="error-message"></div>
      <div class="sent-message">Your appointment request has been sent successfully. Thank you!</div>
      <div class="text-center"><button type="submit">Make an Appointment</button></div>
    </div>
  </form>

</div>

</section><!-- /Appointment Section -->

<?php include('footer.php'); ?>   
</body>
</html>
