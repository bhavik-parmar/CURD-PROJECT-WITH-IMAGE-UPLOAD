<?php
include('DBconnection.php');


if (isset($_POST['btnsub'])) {
    $eid = $_POST['editid']; // Use hidden input to retrieve editid

    //Getting Post Values
    $fname = $_POST['name'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $msg = $_POST['msg'];
    $img = $_POST['img'];
    

    

    $query = "UPDATE form_info SET  fname='$fname', company='$company', email='$email', phone='$phone', msg='$msg' WHERE ID='$eid'";
    $result = mysqli_query($con, $query); // Use $conn for the database connection
    if ($result) {
        echo "<script>alert('You have successfully updated the data');</script>";
        echo "<script type='text/javascript'> document.location ='view.php'; </script>";
    } else {
        echo "<script>alert('Something Went Wrong. Please try again');</script>";
    }
}

if (isset($_GET['editid'])) {
    $eid = $_GET['editid'];
    $ret = mysqli_query($con, "SELECT * FROM form_info WHERE ID='$eid'");

    // Check if the query was successful
    if (!$ret) {
        echo "<script>alert('Error fetching data: " . mysqli_error($con) . "');</script>";
        exit; // Stop further execution
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        form input, form textarea {
            width: calc(100% - 20px); /* Adjust width to account for padding */
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
            margin: 0 auto; /* Center the input fields */
        }

        form input:focus, form textarea:focus {
            border-color: #007bff;
        }

        textarea {
            height: 150px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            margin: 0 auto; /* Center the submit button */
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .file-upload {
            margin: 0 auto; /* Center the file upload input */
        }

        .file-upload input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 20px); /* Adjust width to account for padding */
        }
        .file-preview {
            width: 80px; /* Set width for the preview */
            height: 80px; /* Set height for the preview */
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            margin-right: 10px; /* Space between image preview and input */
        }

        .file-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Maintain aspect ratio */
        }

        .alert {
            color: #d9534f;
            text-align: center;
            margin-top: 20px;
        
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Your Details..</h2>
    <form action="edit.php" method="post">
    <input type="hidden" name="editid" value="<?php echo $eid; ?>">
    <?php if (isset($ret) && mysqli_num_rows($ret) > 0) { ?>
    <?php while ($row = mysqli_fetch_array($ret)) { ?>
        <input type="text" name="name" placeholder="Your name*"  value="<?php echo $row['fname']; ?>" required>
        <input type="text" name="company" placeholder="Your Company name*" value="<?php echo $row['company']; ?>" required>
        <input type="email" name="email" placeholder="Your email address*" value="<?php echo $row['email']; ?>" required>
        <input type="text" name="phone" placeholder="Your phone" value="<?php echo $row['phone']; ?>" >
        <textarea name="msg" placeholder="Your message" class="full-width"><?php echo $row['msg']; ?></textarea>
        
    <?php } ?>
<?php } ?>

   
        <input type="submit" value="Edit" name="btnsub">
       
    </form>
</div>

</body>
</html>