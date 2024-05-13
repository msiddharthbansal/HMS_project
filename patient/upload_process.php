<!DOCTYPE html>
<html>
<body>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" href="../img/healthlogo.png" type="image/x-icon">    
    <title>Symptom Matching</title>
</head>
<?php

//learn from w3schools.com

session_start();
if(isset($_GET['id'])) {
    $pid = $_GET['id'];
    $name = $_GET['name'];
    $email = $_GET['email'];
    $nic = $_GET['nic'];
    $dob = $_GET['dob'];
    $tel = $_GET['tel'];
    $address = $_GET['address'];

    // Now you have patient details, you can proceed with adding them to the prescription table
} 
if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}


//import database
include("../connection.php");
$userrow = $database->query("select * from patient where pemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["pid"];
$username=$userfetch["pname"];

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
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-symptom">
                        <a href="symptom.php" class="non-style-link-menu"><div><p class="menu-text">Symptom Match</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-report">
                        <a href="upload_report.html" class="non-style-link-menu"><div><p class="menu-text">Upload Report</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-prescription">
                        <a href="prescription_show.php" class="non-style-link-menu"><div><p class="menu-text">Prescription</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <?php
// Check if the patient is logged in and retrieve their ID from the session
if (!isset($_SESSION['user'])) {
    echo "Error: Patient not logged in.";
    exit;
}

// Check if a file was uploaded
if (isset($_FILES['report']) && $_FILES['report']['error'] === UPLOAD_ERR_OK) {
    // Retrieve patient ID from session
    $report_id = $_SESSION['user'];
    echo "PATIENT EMAIL: ", $report_id, "<br>";

    // Database connection
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
    $stmt = $conn->prepare("SELECT pid FROM patient WHERE pemail = ?");
    $stmt->bind_param("s", $report_id); // Assuming email is a string type
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $p1 = $row['pid'];
    echo "PATIENT ID: ", $p1, "<br>";
    
    $stmt->close();

    // Prepare a new statement to retrieve the patient name based on the pid
    $stmt = $conn->prepare("SELECT pname FROM patient WHERE pid = ?");
    $stmt->bind_param("i", $p1); // Assuming pid is an integer type
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $pname = $row['pname'];

    // Output the patient name
    echo "Patient Name: ", $pname, "<br>";

    $report_pdf = file_get_contents($_FILES['report']['tmp_name']);

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO clinical_report (pid,pname,report_pdf,patient_email) VALUES  (?,?,?,?)");
    $stmt->bind_param("isss", $p1, $pname, $report_pdf, $report_id);
//    echo '<iframe src="data:application/pdf;base64,' . base64_encode($report_pdf) . '" width="80%" height="600px"></iframe>';
    // Execute statement
    if ($stmt->execute() == TRUE) {
        echo "Report uploaded successfully.";
        echo '<iframe src="data:application/pdf;base64,' . base64_encode($report_pdf) . '" width="80%" height="600px"></iframe>';

    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Error uploading file.";
}
?>

</body>
</html>

