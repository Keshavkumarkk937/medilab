<?php
session_start();
$isUser = isset($_SESSION['user']);
$isDoctor = isset($_SESSION['doctor']);

  if (isset($_SESSION)) { 
  print_r($_SESSION);}// to know user is logged in or not (for debugging)
  date_default_timezone_set('Asia/Kolkata'); // set your timezone here
?>
<header id="header" class="header sticky-top">
  <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
          <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">chopraprince077@gmail.com</a></i>
            <i class="bi bi-phone d-flex align-items-center ms-4" style="position: absolute; top: 10px; right: 10px; margin-right: 110px;"><span>+91 7814831983</span></i>
          </div>
        </div>
      </div><!-- End Top Bar -->

      <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
          <a href="index.php" class="logo d-flex align-items-center me-auto">
            <!--<img src="assets/img/logo.png" alt="#">-->
            <h1 class="sitename">Carewell</h1>
          </a>
          <nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="index.php">Home</a></li>

    <?php if ($isUser): ?>
      <li><a href="doctors.php">Doctors</a></li>
      <li><a href="appointment.php">Book Appointment</a></li>
      <li><a href="my_appointments.php">My Appointments</a></li>
      <li><a href="profile.php">My Profile</a></li>
      <li><a href="http://localhost/Medilab/actions.php?action=logout">Logout</a></li>  
      <a class="cta-btn d-none d-sm-block" href="appointment.php">Make an Appointment</a>

    
      <?php elseif ($isDoctor): ?>
      <li><a href="patients.php">My Patients</a></li>
      <li><a href="schedule.php">Manage Schedule</a></li>
      <li><a href="doctor_profile.php">Profile</a></li>
      <li><a href="http://localhost/Medilab/actions.php?action=logout">Logout</a></li>  
      <a class="cta-btn d-none d-sm-block" href="appointments.php">Appointments</a>

    <?php else: ?>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Register</a></li>
    <?php endif; ?>
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>

        </div>
  </div>
</header>