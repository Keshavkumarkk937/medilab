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
    if (isset($_POST['submit']))
     {
        $cn=mysqli_connect("localhost","root","","medilab");
        $q="insert into contact(name,email,message) values('".$_POST["name"]."','".$_POST["email"]."','".$_POST["message"]."')";
        $a=mysqli_query($cn,$q);
        if ($a>0) {
            echo "<script>alert('Your Message Has been Sent, Thank You!');</script>";
        }
    }
    ?>
<!-- Contact Section -->
 <section id="contact" class="contact section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Contact</h2>
  <p>Have questions or need assistance? We’re here to help you anytime — just reach out!</p>
</div><!-- End Section Title -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="row gy-4">

    <div class="col-lg-4">
      <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
        <i class="bi bi-telephone flex-shrink-0"></i>
        <div>
          <h3>Call Us</h3>
          <p>+91 7814831983</p>
        </div>
      </div><!-- End Info Item -->

      <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
        <i class="bi bi-envelope flex-shrink-0"></i>
        <div>
          <h3>Email Us</h3>
          <p>chopraprince077@gmail.com</p>
        </div>
      </div><!-- End Info Item -->

    </div>

    <div class="col-lg-8">
    <form action="contact.php" method="post">

        <div class="row gy-4">

          <div class="col-md-6">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
          </div>

          <div class="col-md-6 ">
            <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
          </div>

          <div class="col-md-12">
            <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
          </div>

          <div class="col-md-12 text-center">
            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 20px;">Send Message</button>
          </div>

        </div>
      </form>
    </div><!-- End Contact Form -->

  </div>

</div>

</section><!-- /Contact Section -->
<?php include('footer.php'); ?>   
</body>
</html>