<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php include('head.php'); ?>
</head>
<body>
<?php include('header.php'); ?>
<!-- Doctors Section -->
<section id="doctors" class="doctors section">
<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Doctors</h2>
  <p>Meet our team of experienced and compassionate doctors, dedicated to providing the highest quality care. <br>Your health is in expert hands with our trusted medical professionals.</p>
</div><!-- End Section Title -->
<?php
  $cn=mysqli_connect("localhost","root","","medilab");
  $a=mysqli_query($cn,"select * from doctors");
  while($r=mysqli_fetch_array($a))
    {
      ?>
<div class="container mt-5">

  <div class="row gy-4">

    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
   
      <div class="team-member d-flex align-items-start">
        <div class="pic" style="height:100px; width: 100px; border-radius:50%;"><img src="ADMIN/img/<?php  echo $r[4]; ?>" class="img-fluid" alt=""></div>
        <div class="member-info">
          <h4><?php echo $r[1]; ?></h4>
          <span><?php echo $r[2]; ?></span>
          <p><?php echo $r[3]; ?></p>
          <div class="social">
            <a href="https://x.com/?lang=en"><i class="bi bi-twitter-x"></i></a>
            <a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a>
          </div>
        </div>
      </div>
      
    </div>
    </div>
         <!-- End Team Member -->
  </div>
  <?php } 
         ?>
</div>
</section><!-- /Doctors Section -->
<?php include('footer.php'); ?>   
</body>
</html>