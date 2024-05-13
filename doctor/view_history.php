<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" href="../img/healthlogo.png" type="image/x-icon">
    
    <title>Patients</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
<?php

//learn from w3schools.com

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}


//import database
include("../connection.php");
$userrow = $database->query("select * from doctor where docemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["docid"];
$username=$userfetch["docname"];


//echo $userid;
//echo $username;
?>
<div class="container">
    <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
    <td class="menu-btn menu-icon-report">
        <a href="clinical_reports.php" class="non-style-link-menu">
            <div><p class="menu-text">Clinical Reports</p></div>
        </a>
    </td>
</tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
     
<?php


// Check if the user is logged in as a doctor
if(isset($_SESSION["user"]) && $_SESSION['usertype'] == 'd') {
    $useremail = $_SESSION["user"];
} else {
    // Redirect to login page if not logged in or not a doctor
    header("location: ../login.php");
    exit(); // Stop further execution
}

// Include your database connection file
include("../connection.php");

// Check if the patient ID is provided in the URL
if(isset($_GET['id'])) {
    // Sanitize and validate the input
    $patient_id = $_SESSION["PID"]; // Convert to integer for security

    // SQL query to fetch the medical history based on the patient ID
    $sql = "SELECT * FROM PatientHistory WHERE pid = $patient_id";

    // Execute the query
    $result = $database->query($sql);

    // Check if any rows are returned
    if($result && $result->num_rows > 0) {
        // Fetch the medical history data
        $row = $result->fetch_assoc();

// Print the medical history details
echo "<div style='text-align:left; padding-top: 20px; padding-left: 15px;'>";

echo "<p style='font-size: 30px;'><b>Medical History for Patient ID: $patient_id</b></p>";

echo "<p><b>Chronic Conditions:</b> " . $row['ChronicConditions'] . "</p><br>";
echo "<p><b>Allergies:</b> " . $row['Allergies'] . "</p><br>";
echo "<p><b>Surgeries:</b> " . $row['Surgeries'] . "</p><br>";
echo "<p><b>Medications:</b> " . $row['Medications'] . "</p>";

echo "</div><br>";

        
        
        // Print other medical history details similarly

    } else {
        echo "No medical history found for Patient ID: $patient_id";
    }

} else {
    echo "Patient ID not provided.";
}
?>
</body>
</html>