<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/css/bootstrap.min.css">
     <?php include('head.php'); ?>
<style type="text/css">
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #e9f7ef;
}

/* Container for the form */
.form {
    margin-top: 200px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
} 

/* Heading Styling */
h2 {
    margin-top: 1%;
    text-align: center;
    color: #1977cc;
    font-size: 2rem;
    margin-bottom: 20px;
    font-weight: 600;
}

/* Form layout 
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
} */

/* Form group styling */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

/* Label Styling */
label {
    font-size: 1rem;
    color: #333;
    font-weight: 500;
}

/* Input and Textarea Styling */
input[type="text"], textarea, input[type="file"] {
    padding: 12px;
    font-size: 1rem;
    border: 2px solid #ddd;
    border-radius: 10px;
    transition: border-color 0.3s ease-in-out;
}

/* Input Focus */
input[type="text"]:focus, textarea:focus, input[type="file"]:focus {
    border-color: #4CAF50;
    outline: none;
}

/* Styling for the message (textarea) */
textarea {
    resize: vertical;
    min-height: 100px;
}

/* File input customization */
input[type="file"] {
    padding: 5px;
}

/* Button Styling */
button.submit-btn {
    margin-top: 1%;
    margin-bottom: 1%;
    margin-left: 48%;
    padding: 12px 20px;
    font-size: 1.1rem;
    background-color:  #1977cc;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: 600;
}

/* Button Hover Effect */
button.submit-btn:hover {
    background-color: #45a049;
}

/* Button Focus */
button.submit-btn:focus {
    outline: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }
}
</style>
</head>
<body>
<?php include('header.php'); ?>
<?php
    if (isset($_POST['submit']))
	 {
		$n=$_FILES["pic"]["name"];
		$target_file="img/".$n;
		$p=move_uploaded_file($_FILES["pic"]["tmp_name"],$target_file);
		$cn=mysqli_connect("localhost","root","","medilab");
        $q="insert into review(id,name,profession,pic,detail) values('".$n."','".$_POST["name"]."','".$_POST["profession"]."','".$n."','".$_POST["detail"]."')";
        $a=mysqli_query($cn,$q);
        if ($a>0) {
            echo "<script>alert('record inserted');</script>";
        }
    }
    ?>
    <div class="container">
        <h2>Your Opinion Matters</h2>
        <form name="form" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="designation">Profession:</label>
                <input type="text" id="profession" name="profession" placeholder="Enter your designation">
            </div>

            <div class="form-group">
                <label for="message">Picture:</label>
				<input type="file" id="pic" name="pic">
            </div>

            <div class="form-group">
                <label for="pic">Detail:</label>
				<textarea id="message" name="detail" placeholder="Write a message" rows="4" required></textarea>
            </div>

            <button type="submit" name="submit" id="submit" class="submit-btn">Submit</button>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
