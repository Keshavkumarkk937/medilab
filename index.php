<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head.php'); ?>
</head>
<body class="index-page">
<?php include('header.php'); ?>
  <main class="main">
    <!-- Hero Section -->
   
    <section id="hero" class="hero section light-background">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>WELCOME TO CAREWELL</h2>
          <p>Quick healthcare access anytime, anywhere with Carewell.</p>
        </div><!-- End Welcome -->

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3>Why Choose CAREWELL?</h3>
              <p>
              Choose Carewell for a hassle-free healthcare experience. It offers online consultations, easy appointment booking, and a digital pharmacy, ensuring quick and convenient access to medical services from home. With technology-driven solutions, Carewell improves accessibility and simplifies healthcare for both patients and providers.
            </div>
          </div><!-- End Why Box -->
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
    
      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>About Us</h3>
            <p>
            At Carewell, we believe that innovation is not just limited to medical science but also extends to how healthcare is delivered. Our mission is to make quality healthcare accessible, efficient, and patient-centric, ensuring a seamless experience for everyone.
            </p>
            <ul>
              <li>
              <i class="fa-solid fa-hand-holding-heart"></i>
                <div>
                  <h5>More Than Just Healthcare</h5>
                  <p>We see healthcare as more than a transaction; it is built on trust and a strong patient-doctor relationship that nurtures well-being.</p>
                </div>
              </li>
              <li>
              <i class="fa-solid fa-microchip"></i>
                <div>
                  <h5>Technology-Driven Care </h5>
                  <p>We embrace technology to enhance efficiency while ensuring that healthcare remains personalized and human-centered.</p>
                </div>
              </li>
              <li>
              <i class="fa-solid fa-mobile-screen-button"></i>
                <div>
                  <h5>Always Within Reach</h5>
                  <p>Our vision is to be available whenever and wherever you need us, making healthcare just a tap away.</p>
                </div>
              </li>
            </ul>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Services Section -->
 <section id="services" class="services section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Services</h2>
  <p>Explore our wide range of healthcare services designed to meet your needs with compassion, convenience, and care.</p>
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

    <!-- Appointment Section -->
    <section id="appointment" class="appointment section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Appointment</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="forms/appointment.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-4 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
              <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone" required="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 form-group mt-3">
              <input type="datetime-local" name="date" class="form-control datepicker" id="date" placeholder="Appointment Date" required="">
            </div>
            <div class="col-md-4 form-group mt-3">
              <select name="department" id="department" class="form-select" required="">
                <option value="">Select Department</option>
                <option value="Department 1">Department 1</option>
                <option value="Department 2">Department 2</option>
                <option value="Department 3">Department 3</option>
              </select>
            </div>
            <div class="col-md-4 form-group mt-3">
              <select name="doctor" id="doctor" class="form-select" required="">
                <option value="">Select Doctor</option>
                <option value="Doctor 1">Doctor 1</option>
                <option value="Doctor 2">Doctor 2</option>
                <option value="Doctor 3">Doctor 3</option>
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


    <!-- Testimonials Section -->
   <section id="testimonials" class="testimonials section">

<div class="container">

  <div class="row align-items-center">

    <div class="col-lg-5 info" data-aos="fade-up" data-aos-delay="100">
      <h3>Testimonials</h3>
      <p>Hear from our satisfied patients and healthcare professionals about how Carewell has made healthcare more accessible and convenient. From easy appointment booking to seamless online consultations, we’re committed to delivering the best experience. Join thousands who trust Carewell for their medical needs!
      </p>
    </div>

    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
      <div class="swiper init-swiper">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": "auto",
            "pagination": {
              "el": ".swiper-pagination",
              "type": "bullets",
              "clickable": true
            }
          }
        </script>
        <div class="swiper-wrapper">
          <div class="swiper-slide">
          <?php
                        $cn=mysqli_connect("localhost","root","","medilab");
                        $a=mysqli_query($cn,"select * from review");
                        while($r=mysqli_fetch_array($a))
                        {
                            ?>
            <div class="testimonial-item">
            
              <div class="d-flex">
                <img src="ADMIN/img/<?php  echo $r[3]; ?>" class="testimonial-img flex-shrink-0" alt="">
                <div>
                  <h3><?php echo $r[1]; ?></h3>
                  <h4><?php echo $r[2]; ?></h4>
                  <!--<div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>-->
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span><?php echo $r[4]; ?></span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->
          <?php } ?>  
        </div>
        <div class="swiper-pagination"></div>
      </div>

    </div>

  </div>

</div>
</section>

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

  </main>
  <?php include('footer.php'); ?>

</body>

</html>