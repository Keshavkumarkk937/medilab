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
select {
    width: 200px;
    padding: 8px;
    border-radius: 8px;
    border: 2px solid #007bff;
    background-color: #f4faff;
    font-size: 16px;
    color: #333;
    outline: none;
    margin-bottom: 15px;
    transition: 0.3s;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

select:hover, select:focus {
    border-color: #0056b3;
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
}

.image-preview {
    width: 300px;
    height: 200px;
    border: 2px solid #007bff;
    background-color: #f4faff;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 15px;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    color: #666;
    font-size: 14px;
    transition: 0.3s;
    position: relative;
    text-align: center;
    line-height: 200px; /* vertically center text if no image */
}
.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    position: absolute;
    top: 10;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    display: block;
}

.image-preview:hover {
    border-color: #0056b3;
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    color: #444;
}

table {
		margin-left: auto;
		margin-right: auto;
		text-align: center;
	}
	td{
		padding: 10px;
	}
	th{
		color:whitesmoke;
		font-size: 18px;
	}
	h1{
		text-align: center;
		padding-bottom: 10px;
		font-family: cursive;
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
	if(isset($_POST["update"]))
	{
		if ($_FILES["pic"]["name"]!="")
		{
			$n=$_FILES["pic"]["name"];
			$target_file="img/".$n;
			$p=move_uploaded_file($_FILES["pic"]["tmp_name"],$target_file);
		}
		else
		{
			$n=$_POST["h1"];
		}
		$cn=mysqli_connect("localhost","root","","medilab");
		$q="update review set name='".$_POST["name"]."',profession='".$_POST["profession"]."',pic='".$n."',detail='".$_POST["detail"]."' where id='".$_POST["selectid"]."'";	
		$a=mysqli_query($cn,$q);
		if ($a>0)
		 {
			echo "<script>alert('record updated');</script>";
		}
	}
	?>
	
	<?php
	if(isset($_POST["delete"]))
	{
		$cn=mysqli_connect("localhost","root","","medilab");
		$q="delete from review where id='".$_POST["selectid"]."'";
		$a=mysqli_query($cn,$q);
		if ($a>0)
		 {
			echo "<script>alert('Record Deleted');</script>";
		}
	}
	?>

	<?php
	if (isset($_POST["selectid"]))
	 {
		$cn=mysqli_connect("localhost","root","","medilab");
		$res="select * from review where id='".$_POST["selectid"]."'";
		$a=mysqli_query($cn,$res);
		$r=mysqli_fetch_array($a);
		$pic=$r[3];
		$name=$r[1];
		$profession=$r[2];
		$detail=$r[4];
	}
	?>
    <div class="container">
        <h2>Your Opinion Matters</h2>
        <form name="form" method="POST" enctype="multipart/form-data">
        <table>
			<tr>
				<td>
					<select name="selectid" class="select-dropdown" name="selectid" onchange="this.form.submit()">
						<option>select</option>
						<?php
						$cn=mysqli_connect("localhost","root","","medilab");
						$q=mysqli_query($cn,"select * from review");
						while ($r=mysqli_fetch_array($q))
						 {
							if (isset($_POST["selectid"])) 
							{
								if ($_POST["selectid"]==$r[0])
								 {
									echo "<option selected=selected>".$r[0]."</option>";
								}
								else
								{
									echo "<option>".$r[0]."</option>";
								}
							}
							else
							{
								echo "<option>".$r[0]."</option>";
							}
						}
						?>
					</select>
				</td>
			</tr>
        </table>		
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php if(isset($_POST["selectid"])){echo $name;}?>">
            </div>

            <div class="form-group">
                <label for="designation">Profession:</label>
                <input type="text" id="profession" name="profession" value="<?php if(isset($_POST["selectid"])){echo $profession;}?>">
            </div>
            <label for="image" style="margin-top:10px; margin-bottom:10px;">image:</label>
            <div class="image-preview">
                <tr>
                <td><img src="<?php if(isset($_POST['selectid'])) { echo "img/".$pic;} ?>" height="300px" width="150px">
                <input type="hidden" name="h1" value="<?php if(isset($_POST["selectid"])){echo $pic;}?>">
                </td>
                </tr>
            </div>

            <div class="form-group">
                <label for="pic">Picture:</label>
				<input type="file" id="pic" name="pic">
            </div>

            <div class="form-group">
                <label for="pic">Detail:</label>
				<textarea id="message" name="detail" rows="4"><?php if(isset($_POST["selectid"])){echo $detail;}?></textarea>
            </div>

            <button type="submit" name="update" value="update" class="submit-btn">Update</button>
            <button type="submit" name="delete" value="Delete" class="submit-btn">Delete</button>
        </form>
    </div>
<?php include('footer.php'); ?>
</body>
</html>
