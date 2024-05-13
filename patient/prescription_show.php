<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/healthlogo.png" type="image/x-icon">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">    

    <title>View My Prescription</title>
</head>
<body>
    <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    
    <h1>Prescription of </h1>

    <h3><?php
    session_start();
    // Include database connection
    $servername = "localhost"; // Change this to your database server
    $username = "root"; // Change this to your database username
    $password = ""; // Change this to your database password
    $dbname = "edoc"; // Change this to your database name
    $pid=$_SESSION["pid"];   
    // Create connection
    $p2=$_SESSION["pname"];
    echo $p2 ,"<br>","<br>";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Query to fetch all reports
    $sql = "SELECT prescription_id,pid,pname,prescription_PDF FROM prescription WHERE pid='$pid'" ;
    $result = $conn->query($sql);

    // Check if there are reports
    if ($result->num_rows > 0) {
        // Output iframe for each report
        while ($row = $result->fetch_assoc()) {
            $prescription_id = $row['prescription_id'];
            $patient_id=$row['pid'];
            $pname=$row['pname'];
           
          $report_pdf = $row['prescription_PDF'];
            echo "PRESCRIPTION_ID: ",$prescription_id,"<br>";
            echo "PATIENT_ID: ",$patient_id,"<br>";
            

            echo "<object data='data:application/pdf;base64,".base64_encode($report_pdf)."' type='application/pdf' width='100%' height='600px'><p>Your browser does not support PDFs. Please download the PDF to view it: <a href='data:application/octet-stream;base64,".base64_encode($report_pdf)."'>Download PDF</a></p></object>";
            echo "<br>";echo "<br>";echo "<br>";
        }
    } else {
        echo "No reports found.";
    }

    // Close database connection
    $conn->close();
    ?> <h3>

</body>
</html>
