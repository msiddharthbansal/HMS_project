<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'a') {
    header("location: ../login.php");
    exit(); // Add an exit here to prevent further execution of the script
}

//import database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edoc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the patient details are available in the session
if(isset($_SESSION["pid"]) && isset($_SESSION["pname"])) {
    $pid = $_SESSION["pid"];
    $pname = $_SESSION["pname"];
    
    // Add other patient details if available
    // $pnic = $_SESSION["pnic"];
    // $pemail = $_SESSION["pemail"];

    // Insert the patient details into the prescription table
    // Replace this with the actual prescription ID
    if ($_FILES['report']['error'] !== UPLOAD_ERR_OK) {
        // Handle the case where no file was uploaded
        echo "No file uploaded.";
    } else {
        try {
            // Insert the patient details into the prescription table
            // Replace this with the actual prescription ID
            $report_pdf = file_get_contents($_FILES['report']['tmp_name']);
            $stmt = $conn->prepare("INSERT INTO prescription (pid, pname, prescription_PDF) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $pid, $pname, $report_pdf);
            if ($stmt->execute() == TRUE) {
                echo "Report uploaded successfully.";
                $stmt->close();
            } else {
                echo "Error: " . $stmt->error;
            }
        } catch (Exception $e) {
            // Handle any exceptions that occur during file processing
            echo "Error uploading file: " . $e->getMessage();
        }
    }

// Close connections

$conn->close();
} else {
echo "Error uploading file.";
}
?>
