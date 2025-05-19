<?php
session_start();
$cn = mysqli_connect("localhost", "root", "", "medilab");

if (!$cn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['action'])) { 
    $action = $_GET['action'];

    // Logout
    if ($action === 'logout') {
        //echo "Helllow wordls";
         session_destroy();
         header("Location: login.php");
        exit;
    }

    // Delete Doctor
    elseif ($action === 'deleteDoctor' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        mysqli_query($cn, "DELETE FROM doctors WHERE id=$id");
        header("Location: ADMIN/doctor.php");
        exit;
    }

}
?>
