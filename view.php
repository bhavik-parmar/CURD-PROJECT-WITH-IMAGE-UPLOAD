<?php
include('DBconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view Data</title>
</head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color:#0e3663;
  color: rgb(255, 255, 255);
}


button {
    background-color: #4CAF50; /* Green background for the default button */
    border: none; /* Remove borders */
    color: white; /* White text */
    padding: 10px 15px; /* Some padding */
    text-align: center; /* Centered text */
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Make the buttons inline */
    font-size: 16px; /* Increase font size */
    margin: 4px 10px; /* Add some margin for spacing */
    cursor: pointer; /* Pointer/hand icon on hover */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s; /* Smooth transition for background color */
}

button:hover {
    background-color: #45a049; /* Darker green on hover */
}

.red-button:hover {
    background-color: #d32f2f; /* Darker red on hover */
}
.red-button {
  background-color: #f44336; /* Red background */
}
.blue-button {
    background-color: #007BFF; /* Blue background */
    color: white; /* White text */
}

</style>
      <body>
        
        <div align="center">
        <h1>INFORMATION</h1>
        <a href="index.php">
            <button type="button"  class="blue-button" >Go to Index</button>
        </a><br><br>

        <?php
        $query = "SELECT * FROM form_info";

        echo '<table id="customers"> 
              <tr> 
                    <th>ID</th> 
                    <th>image</th>
                    <th>Name</th> 
                    <th>Comapny</th> 
                    <th>Email</th> 
                    <th>Phone</th> 
                    <th>Message</th>
                    <th>Action</th>
              </tr>';

              if ($result = $con->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $name  = $row["fname"];
                    $company = $row["company"];
                    $email = $row["email"];
                    $phone = $row["phone"]; 
                    $msg = $row["msg"];
                    $img = $row["img"];
            
                    echo '<tr> 
                    <td>'.$id.'</td> 
                    <td><img src="images/'.$img.'" style="width: 100px; height: 100px; object-fit: cover;" alt="Image"></td>
                    <td>'.$name.'</td> 
                    <td>'.$company.'</td> 
                    <td>'.$email.'</td> 
                    <td>'.$phone.'</td> 
                    <td>'.$msg.'</td>
                    <td>
                       <a href="edit.php?editid=' . $row['id'] . '">
                       <button type="button">Edit</button>
                      </a>

  
                        </a>
                        <a href="delete.php?id='.$id.'" onclick="return confirm(\'Are you sure you want to delete this record?\')">
                            <button type="button" class="red-button">Delete</button>
                        </a>
                         <a href="editimg.php?editid=' . $row['id'] . '">
                       <button type="button">EditImage</button>
                      </a>
                    </td>
                </tr>';
                }
                $result->free();
                }

                $con->close();
        ?>
    
        </div> 

      </body>
      </html>
