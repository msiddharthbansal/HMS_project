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
        
    <title>Sessions</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>


<title>Dashboard</title>
    <style>
    

.container1{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 2px solid #ccc; /* Border color */
    border-radius: 10px; /* Rounded corners */
    padding: 20px; /* Padding inside the container */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Box shadow for depth effect */
    background-color: #fff;
}



       h2{
        text-align: center;
            margin-bottom: 50px;
       }
        input[type="text"],
        input[type="password"],
        input[type="tel"],
        select,
        

    
    

button {
    
    background-color: white;
    color:  aqua;
  
    cursor: pointer;
   
}
        button:hover {
            background-color: whitesmoke;
        }

       

     
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container {
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table, .anime {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>


</head>
<body>
    <?php
    // Learn from w3schools.com
    session_start();

    if (!isset($_SESSION["user"]) || empty($_SESSION["user"]) || $_SESSION['usertype'] !== 'p') {
        header("location: ../login.php");
        exit;
    } else {
        $useremail = $_SESSION["user"];
    }

    // Import database
    include("../connection.php");

    $sql = "SELECT * FROM patient WHERE pemail=?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();
   
    if ($result->num_rows > 0) {
        $userfetch = $result->fetch_assoc();
        $userid = $userfetch["pid"];
        $username = $userfetch["pname"];
        $usertel = $userfetch["ptel"]; 
        $_SESSION["name"]=$username;
        $_SESSION["tel"]=$usertel;
        $_SESSION["pid"]=$userid;
        $_SESSION["email"]=$useremail;
        
    } else {
        header("location: ../login.php");
        exit;
    }

    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d');
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
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Schedule Appointment</p></div></a>
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
                        <a href="upload_report.php" class="non-style-link-menu"><div><p class="menu-text">Upload Report</p></a></div>
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
            
         

        
        $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today'  order by schedule.scheduledate asc";
        $sqlpt1="";
        $insertkey="";
        $q='';
        $searchtype="All";
        if ($_POST) {
            if (!empty($_POST["search"])) {
                $keyword=$_POST["search"];
                $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' and (doctor.docname='$keyword' or doctor.docname like '$keyword%' or doctor.docname like '%$keyword' or doctor.docname like '%$keyword%' or schedule.title='$keyword' or schedule.title like '$keyword%' or schedule.title like '%$keyword' or schedule.title like '%$keyword%' or schedule.scheduledate like '$keyword%' or schedule.scheduledate like '%$keyword' or schedule.scheduledate like '%$keyword%' or schedule.scheduledate='$keyword' )  order by schedule.scheduledate asc";
                $insertkey=$keyword;
                $searchtype="Search Result : ";
                $q='"';

            }
        }

        $result= $database->query($sqlmain);
        ?>


        
        <?php

          $con=mysqli_connect("localhost" , "root" ,"" ,"edoc") or die("couldn't connect");
          
        ?>   



        

<a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>

                <tr>
                    <td colspan="4">
                        <center>

                        <div class= "container1"> 
                        <form action="submit_history.php" method="post">
    <h2>MEDICAL HISTORY FORM</h2>
    <?php if(isset($_GET['error'])) {?>
        <p class="error"><?php echo $_GET['error'];?></p>
    <?php } ?>

    <label for="chronic_conditions">Chronic Conditions:</label>
    <textarea id="chronic_conditions" name="chronic_conditions" cols="30" rows="2"></textarea><br>

    <label for="allergies">Allergies:</label>
    <textarea id="allergies" name="allergies" cols="30" rows="2"></textarea><br>

    <label for="surgeries">Surgeries:</label>
    <textarea id="surgeries" name="surgeries" cols="30" rows="2"></textarea><br>

    <label for="medications">Medications:</label>
    <textarea id="medications" name="medications" cols="30" rows="2"></textarea><br>

    <label for="family_illness_history">Family Illness History:</label>
    <textarea id="family_illness_history" name="family_illness_history" cols="30" rows="2"></textarea><br>

    <label for="smoking_status">Smoking Status:</label>
    <select id="smoking_status" name="smoking_status"required style="color: black;>
        <option value="Never Smoked">Never Smoked</option>
        <option value="Former Smoker">Former Smoker</option>
        <option value="Current Smoker">Current Smoker</option>
    </select><br>

    <label for="alcohol_consumption">Alcohol Consumption:</label>
    <select id="alcohol_consumption" name="alcohol_consumption"required style="color: black;>
        <option value="Never">Never</option>
        <option value="Occasional">Occasional</option>
        <option value="Regular">Regular</option>
    </select><br>

    <label for="present_complaints">Present Complaints:</label>
    <textarea id="present_complaints" name="present_complaints" cols="30" rows="2"></textarea><br>

    <label for="severity">Severity:</label>
    <select id="severity" name="severity"required style="color: black;>
        <option value="Mild">Mild</option>
        <option value="Moderate">Moderate</option>
        <option value="Severe">Severe</option>
    </select><br>

    <label for="blood_type">Blood Type:</label>
    <select id="blood_type" name="blood_type"required style="color: black;>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select><br>

    <label for="height">Height (cm):</label>
    <input type="number" id="height" name="height" min="0"><br>

    <label for="weight">Weight (kg):</label>
    <input type="number" id="weight" name="weight" min="0"><br>

    <label for="blood_pressure">Blood Pressure:</label>
    <input type="text" id="blood_pressure" name="blood_pressure"><br>

    <label for="heart_rate">Heart Rate (bpm):</label>
    <input type="number" id="heart_rate" name="heart_rate" min="0"><br>

    <label for="respiratory_rate">Respiratory Rate (bpm):</label>
    <input type="number" id="respiratory_rate" name="respiratory_rate" min="0"><br>

    <label for="last_checkup_date">Date of Last Checkup:</label>
    <input type="date" id="last_checkup_date" name="last_checkup_date"><br>

    <input type="submit" value="Submit Medical History">
</form>

 
                    </div>
                           
                        </center>
                    </td> 
                </tr>
            </table>
        </div>


     


</body>
</html>
