<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Clinical Reports</title>
</head>
<body>
    <h1>Clinical Reports of your Patients</h1>
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
    ?>
    <?php
    // Include database connection
    $servername = "localhost"; // Change this to your database server
    $username = "root"; // Change this to your database username
    $password = ""; // Change this to your database password
    $dbname = "edoc"; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch reports for the doctor's patients
    $sql = "SELECT DISTINCT c.report_id, c.pid, c.pname, c.report_pdf, c.uploaded_at, c.patient_email 
    FROM clinical_report c
    JOIN users a ON c.pid = a.pid
    JOIN doctor d ON a.department = d.docdept
    WHERE d.docid = $userid AND d.availability = 'y';    
            ";

    $result = $conn->query($sql);

    // Check if there are reports
    if ($result->num_rows > 0) {
        // Output iframe for each report
        while ($row = $result->fetch_assoc()) {
            $report_id = $row['report_id'];
            $patient_id = $row['pid'];
            $pname = $row['pname'];
            $uploaded = $row['uploaded_at'];
            $pemail = $row['patient_email'];

            echo "REPORT_ID: ", $report_id, "<br>";
            echo "PATIENT_ID: ", $patient_id, "<br>";
            echo "PATIENT_NAME: ", $pname, "<br>";
            echo "UPLOADED_AT: ", $uploaded, "<br>";
            echo "PATIENT_EMAIL: ", $pemail, "<br>";

            echo "<object data='data:application/pdf;base64," . base64_encode($row['report_pdf']) . "' type='application/pdf' width='100%' height='500px'><p>Your browser does not support PDFs. Please download the PDF to view it: <a href='data:application/octet-stream;base64," . base64_encode($row['report_pdf']) . "'>Download PDF</a></p></object>";
            echo "<br>";echo "<br>";echo "<br>";
        }
    } else {
        echo "No reports found.";
    }

    // Close database connection
    $conn->close();
    ?>

</body>
</html>
