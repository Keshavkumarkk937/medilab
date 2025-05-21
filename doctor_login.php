<?php
session_start();
include('head.php');
include('header.php');

$error = "";

// Handle login form submission
if (isset($_POST['submit'])) {
    $cn = mysqli_connect("localhost", "root", "", "medilab");

    if (!$cn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($cn, $_POST['name']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM doctors WHERE name = '$username'";
    $result = mysqli_query($cn, $sql);
    $doctor = mysqli_fetch_assoc($result);

    if ($doctor) {
        // Note: This is a plain-text comparison. Recommended to use password_hash in production.
        if ($doctor['password'] === $password) {
            $_SESSION['doctor'] = [
                'id' => $doctor['id'],
                'name' => $doctor['name'],
                'email' => $doctor['email']
            ];
            header("Location: index.php"); // Redirect to a dedicated doctor dashboard
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Doctor not found!";
    }
}
?>
<body>

<!-- Doctor Login Section -->
<section id="contact" class="contact section" style="display:flex; justify-content:center;">
    <div class="" style="min-width: 1200px; box-shadow: 0 4px 10px #d3d3d3; padding: 25px;">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Doctor Login</h2>
            <p>Login to access your dashboard and manage appointments securely.</p>
            <?php 
            if (!empty($error)) {
                echo "<div style='color:red;'>$error</div>";
            }
            ?>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-12">
                    <form action="doctor_login.php" method="post">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control" placeholder="Doctor's Name" required>
                            </div>

                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 20px; padding: 10px 15px;">Login</button>
                            </div>

                            <div class="col-md-12 text-center">
                                <p>Looking for user login? Click <a href="login.php">here</a>.</p>
                            </div>
                        </div>
                    </form>
                </div><!-- End Form -->
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>   
</body>
