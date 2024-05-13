<?php
// Establishing connection to MySQL database
$servername = "localhost"; // Change this to your database server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "edoc"; // Change this to your database name
session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = $_POST['department'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];
   
    // Retrieving user details from session variables
    $username = $_SESSION["name"];
    $usertel = $_SESSION["tel"];
    $userid = $_SESSION["pid"];
    $useremail = $_SESSION["email"];

    // Prepare SQL statement with placeholders
    $sql = "INSERT INTO users (pname, pid, phone, department, date, time, current, message, pemail)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssss", $username, $userid, $usertel, $department, $date, $time, $message, $useremail);
    
    // Execute SQL statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close(); 
header("refresh:1;url=index.php");
?>
