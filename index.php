<?php
include('DBconnection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Form</title>
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
    <h2>Let's get in touch</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
       
        <input type="text" name="name" placeholder="Your name*" required>
        <input type="text" name="company" placeholder="Your Company name*" required>
        <input type="email" name="email" placeholder="Your email address*" required>
        <input type="text" name="phone" placeholder="Your phone" pattern="^\+?[0-9]{10}$" title="Please enter a valid phone number (10 to 15 digits, optional '+' at the start)">
        <textarea name="message" placeholder="Your message" class="full-width"></textarea>
        <div class="file-upload" style="display: flex; align-items: center;">
        <div class="file-preview" id="filePreview" style="margin-right: 10px; display: none;">
        <img id="previewImg" src="" alt="Image Preview" style="display: none;">
        </div>
        <input class="form-control" type="file" name="uploadfile" id="uploadfile" accept="image/*" onchange="previewFile()"/>
</div>

<script>
    function previewFile() {
        const fileInput = document.getElementById('uploadfile');
        const previewImg = document.getElementById('previewImg');
        const filePreview = document.getElementById('filePreview');

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            previewImg.src = reader.result;
            previewImg.style.display = 'block'; // Show the image
            filePreview.style.display = 'flex'; // Ensure the preview container is displayed
        }

        if (file) {
            reader.readAsDataURL(file); // Convert the file to a data URL
        } else {
            previewImg.src = "";
            previewImg.style.display = 'none'; // Hide the image if no file is selected
        }
    }
</script>
        <input type="submit" value="Submit" name="btnsub">
        
    </form>
</div>

</body>
</html>

<?php


if(isset($_POST['btnsub'])){
    $name = $_POST['name'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    error_reporting(0);

    $msg = "";

    if (isset($_POST['btnsub'])) {

        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "images/" . $filename;

        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>&nbsp; Image uploaded successfully!</h3>";
        } else {
            echo "<h3>&nbsp; Failed to upload image!</h3>";
        }

    
    $stmt = $con->prepare("INSERT INTO form_info (fname, img, company, email, phone, msg ) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: " . $con->error);
            }

            $stmt->bind_param("ssssss", $name,$filename, $company, $email, $phone, $message);

            if ($stmt->execute()) {
                echo "<script>alert('You have successfully inserted the data');</script>";
                echo "<script type='text/javascript'> document.location ='view.php'; </script>";
            } else {
                echo "<script>alert('Execute failed: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
}
    ?>


