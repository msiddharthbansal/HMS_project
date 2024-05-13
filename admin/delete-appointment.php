<?php

session_start();

if(isset($_SESSION["user"]) && $_SESSION['usertype'] === 'a') {
    if(empty($_SESSION["user"])) {
        header("location: ../login.php");
        exit; // Add exit here to prevent further execution
    }
} else {
    header("location: ../login.php");
    exit; // Add exit here to prevent further execution
}

if(isset($_GET['id'])) {
    // Import database
    include("../connection.php");
    $id = $_GET['id'];
    
    // Prepare SQL statement to delete the record from the users table
    $sql = "DELETE FROM users WHERE ID = ?";
    
    // Prepare the statement
    $stmt = $database->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Check for errors
    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
    } else {
        // Redirect to the appointment page after deletion
        header("location: appointment.php");
        exit; // Add exit here to prevent further execution
    }
} else {
    echo "Error: Appointment ID not provided.";
}

?>
