<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php include('head.php'); ?>
</head>
<body>
<?php include('header.php'); ?>
<!-- Services Section -->
 <section id="services" class="services section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Services</h2>
  <p>From hospitals to pharmacies and insurance, we provide complete, personalized healthcare tailored to your needs.</p>
</div><!-- End Section Title -->

<div class="container">

  <div class="row gy-4">
  <?php
                $cn=mysqli_connect("localhost","root","","Medilab");
                $a=mysqli_query($cn,"select * from services");
                while($r=mysqli_fetch_array($a))
                {

                ?>
    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
      <div class="service-item  position-relative">
      <div class="service-img">
        <img class="img-fluid" src="ADMIN/img/<?php  echo $r[3]; ?>" style="height: 130px; width:130px; border-radius: 20%; ">
      </div>
        <a href="#" class="stretched-link">
          <h3 class="pt-4"><?php echo $r[1]; ?></h3>
        </a>
        <p><?php echo $r[2]; ?></p>
      </div>
    </div><!-- End Service Item -->
    <?php } ?>
  </div>

</div>

</section><!-- /Services Section -->
<?php include('footer.php'); ?>   
</body>
</html>