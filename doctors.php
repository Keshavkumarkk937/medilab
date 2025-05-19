<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php include('head.php'); ?>
</head>

<style>
  .doctor-card {
    border: 1px solid #e0e0e0;
    padding: 25px 20px;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 12px #cce3ff;
    transition: 0.3s ease-in-out;
  }

  .doctor-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 16px #aacfff;
    background-color: #1977cc;
    color: #fff;
  }

  .doctor-card img {
    height: 150px;
    width: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #007bff33;
    margin-bottom: 10px;
  }

  .doctor-card h3 {
    font-weight: bold;
    color: #002f6c;
  }

  .doctor-card p {
    font-size: 15px;
    color: #444;
    margin-bottom: 5px;
  }
</style>
<body>
<?php include('header.php'); ?>
<!-- Services Section -->
<section id="doctors" class="section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Doctors</h2>
    <p>Meet our team of experienced and specialized healthcare professionals dedicated to your care.</p>
  </div>

  <div class="container">
    <div class="row gy-4">

    <?php
      $cn = mysqli_connect("localhost", "root", "", "Medilab");
      $query = mysqli_query($cn, "SELECT * FROM doctors");
      while ($r = mysqli_fetch_assoc($query)) {
    ?>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative doctor-card">
          <div class="service-img text-center">
            <img class="img-fluid" src="ADMIN/img/<?php echo htmlspecialchars($r['pic']); ?>" alt="Doctor Image">
          </div>
          <h3 class="pt-3 text-center"><?php echo ucwords(htmlspecialchars($r['name'])); ?></h3>
          <p>Education: <?php echo htmlspecialchars($r['designation']); ?></p>
          <p>Specialization: <?php echo htmlspecialchars($r['specialization']); ?></p>
          <p>Experience in Years: <?php echo htmlspecialchars($r['experience_in_years']); ?></p>
          <p>Email: <?php echo htmlspecialchars($r['email']); ?></p>
          <p>Contact No: <?php echo htmlspecialchars($r['phone']); ?></p>
          <div class="col-md-12 text-center">
            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 20px; padding: 10px 45px 10px 45px;">Book</button>
          </div>
        </div>
        
      </div>
    <?php } ?>

    </div>
  </div>
</section><!-- /doctors Section -->
<?php include('footer.php'); ?>   
</body>
</html>