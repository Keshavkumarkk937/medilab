<?php 
  session_start();
  if (isset($_SESSION)) { 
  print_r($_SESSION);}// to know user is logged in or not (for debugging)
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
              <li><a href="#hero" class="active">Home<br></a></li>
              <li><a href="about.php">About</a></li>
              <li><a href="service.php">Services</a></li>
              <li><a href="department.php">Departments</a></li>
              <li><a href="doctors.php">Doctors</a></li>
              <li><a href="review.php">Testimonials</a></li>
              <li><a href="contact.php">Contact</a></li>
              <?php 
                if(isset($_SESSION['user'])){ ?>
                  <li><a href="http://localhost/Medilab/actions.php?action=logout">Logout</a></li>

              <?php }else { ?>
                  <li><a href="http://localhost/Medilab/login.php">Login</a></li>

              <?php } ?>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
          </nav>
          <a class="cta-btn d-none d-sm-block" href="appointment.php">Make an Appointment</a>

        </div>
  </div>
</header>