<?php 
include('DBconnection.php');

$id = $_GET['id'];

$query = "DELETE FROM form_info WHERE id = ?";

if ($stmt = $con->prepare($query)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$con->close();

header("Location: view.php"); 
exit();

?>
