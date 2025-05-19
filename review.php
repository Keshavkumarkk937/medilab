<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head.php'); ?>
</head>
<body>
<?php include('header.php'); ?>
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
<div class="container-fluid" style="background-color: #fcf1f0">
        <div class="row">
            <h4 class="h4 text-center mt-3 pt-3"><u>Reviews</u></h4>
            <div class="container text-center mt-3 mb-5 pt-3" style="height:200px; width: 400px; background-color: #fae3e1">
                <strong class="text-dark">We Value your Feedback!</strong>
                <a class="btn btn-success btn-lg mt-3" href="review.php">Add Review</a>
            </div>
        </div>
    </div><!-- /Testimonials Section -->

<?php include('footer.php'); ?>   
</body>
</html>