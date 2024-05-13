<?php
session_start();
// Check if the form is submitted
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file

    // Get the form data
    
    $patientID = $_SESSION['pid']; // Assuming you have a field for patientID in the form
    
    $chronicConditions = $_POST['chronic_conditions'];
    $allergies = $_POST['allergies'];
    $surgeries = $_POST['surgeries'];
    $medications = $_POST['medications'];
    $familyIllnessHistory = $_POST['family_illness_history'];
    $smokingStatus = $_POST['smoking_status'];
    $alcoholConsumption = $_POST['alcohol_consumption'];
    $presentComplaints = $_POST['present_complaints'];
    $severity = $_POST['severity'];
    $bloodType = $_POST['blood_type'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bloodPressure = $_POST['blood_pressure'];
    $heartRate = $_POST['heart_rate'];
    $respiratoryRate = $_POST['respiratory_rate'];
    $dateOfLastCheckup = $_POST['last_checkup_date'];

    // SQL query to insert data into PatientHistory table
    $sql = "INSERT INTO PatientHistory (pid, ChronicConditions, Allergies, Surgeries, Medications, FamilyIllnessHistory, SmokingStatus, AlcoholConsumption, PresentComplaints, Severity, BloodType, Height, Weight, BloodPressure, HeartRate, RespiratoryRate, DateOfLastCheckup) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("isssssssssddssddd", $patientID, $chronicConditions, $allergies, $surgeries, $medications, $familyIllnessHistory, $smokingStatus, $alcoholConsumption, $presentComplaints, $severity, $bloodType, $height, $weight, $bloodPressure, $heartRate, $respiratoryRate, $dateOfLastCheckup);

    // Execute the statement
    if ($stmt->execute()) {
        echo "SUCCESSFULY ADDED MEDICAL HISTORY";
        // Redirect to a success page or display a success message
        $_SESSION['success_message'] = "Successfully added.";

        // Redirect to success page after 2 seconds
        header("Refresh: 2; URL=index.php");
        exit();
    } else {
        // Redirect to an error page or display an error message
        header("Location: error.php");
        exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
