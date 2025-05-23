<?php
session_start(); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php

// Handle login form submission
if (isset($_POST['submit'])) {
    $cn = mysqli_connect("localhost", "root", "", "medilab");

    $username = mysqli_real_escape_string($cn, $_POST['name']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE name = '$username'";
    $result = mysqli_query($cn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['password'] === $password) { // plain-text check for now
          $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            //'email' => $user['email']
          ]; // Store user's data in the session
            
          header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<body>
<?php
    // if (isset($_POST['submit']))
    //  {
    //     $cn=mysqli_connect("localhost","root","","medilab");
    //     $q="insert into contact(name,email,message) values('".$_POST["name"]."','".$_POST["email"]."','".$_POST["message"]."')";
    //     $a=mysqli_query($cn,$q);
    //     if ($a>0) {
    //         echo "<script>alert('Your Message Has been Sent, Thank You!');</script>";
    //     }
    // }
?>
<!-- Contact Section -->
 <section id="contact" class="contact section" style="display:flex; justify-content:center;">
 <div class="" style="min-width: 1200px; box-shadow: 0 4px 10px #d3d3d3; padding: 25px;">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>User Login</h2>
  <p>Login to our website to access more features. Your data will be kept safe and private.</p>
  <?php 
  if(isset($error));
  echo "<div style='color:red;'>  $error  </div>";
  ?>
</div><!-- End Section Title -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="row gy-4">



    <div class="col-lg-12">
    <form action="login.php" method="post">

        <div class="row gy-4">

          <div class="col-md-12">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
          </div>

          <div class="col-md-12 ">
            <input type="text" class="form-control" name="password" placeholder="Your Email" required="">
          </div>

          <div class="col-md-12 text-center">
            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 20px; padding: 10px 15px 10px 15px;">Login</button>
          </div>
          <div class="col-md-12 text-center">
                                <p>Looking for doctor login? Click <a href="doctor_login.php">here</a>.</p>
                            </div>
      </form>
    </div><!-- End Contact Form -->

  </div>

</div>
  </div>
</section><!-- /Contact Section -->
<?php include('footer.php'); ?>   
</body>