<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'a') {
    header("location: ../login.php");
    exit(); // Add an exit here to prevent further execution of the script
}

// Get the patient ID, name, and email from the URL parameters
if(isset($_GET['id']) && isset($_GET['name']) && isset($_GET['email'])) {
    $patient_id = $_GET['id'];
    $patient_name = $_GET['name'];
    $patient_email = $_GET['email'];
} else {
    // Handle the case when the parameters are not set
    // Redirect or display an error message
    echo "Error: Patient details not provided.";
    exit(); // Add an exit here to prevent further execution of the script
}

//import database
include("../connection.php");

session_abort();
?>
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
    <title>Upload Clinical Report</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .container {
            display: flex; /* Use flexbox for layout */
            justify-content: space-between; /* Space items evenly */
            align-items: flex-start; /* Align items at the top */
        }
        .form-container {
            width: calc(50% - 10px); /* Adjust width as needed */
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Stack items vertically on smaller screens */
            }
            .form-container {
                width: 100%; /* Take full width on smaller screens */
            }
        }
    </style>
</head>
<body>
<?php

//learn from w3schools.com

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}



//import database
include("../connection.php");


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
                                <p class="profile-title">Administrator</p>
                                <p class="profile-subtitle"><?php echo substr($useremail,0,22)?></p>
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
                    <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                    <a href="doctors.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Doctors</p></a></div>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-schedule">
                    <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Schedule</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment">
                    <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-patient">
                    <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Patients</p></a></div>
                </td>
            </tr>

        </table>
    </div>
    <div class="form-container">
        <h2>Upload Clinical Report</h2><br> 
        <form action="prescription_upload.php" method="post" enctype="multipart/form-data">
            <label for="report" class="file-label"><br><br><br>Select PDF File:</label><br>
            <input type="file" id="report" name="report" accept=".pdf"><br><br>
            <!-- Add hidden input fields to pass patient details to the upload_process.php script -->
            <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
            <input type="hidden" name="patient_name" value="<?php echo $patient_name; ?>">
            <input type="hidden" name="patient_email" value="<?php echo $patient_email; ?>">
            <input type="submit" value="Upload Report">
        </form>
    </div>
</body>
</html>
