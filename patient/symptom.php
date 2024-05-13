<!DOCTYPE html>
<html>
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
<body>
    <?php

    //learn from w3schools.com

    session_start();

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
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Schedule Appointment</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-symptom menu-active menu-icon-symptom-active">
                        <a href="symptom.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Symptom Match</p></a></div>
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
        
        <div class="dash-body" style="text-align: center;">
        
    
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="text-align:center;padding-left:50px;padding-top:120px;">
            <label for="symptoms"><b>What symptoms are you facing? Share with us:</b></label><br><br><br>
            <textarea id="symptoms" name="symptoms" rows="10" cols="50"></textarea><br>
            <input type="submit" value="Submit"> <br> <br>
        </form>

        <?php
            // PHP code for processing form input and symptom matching goes here
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Define symptoms and corresponding doctors/specialists
                $symptom_doctor_map = array(
                    "headache" => "Neurologist",
                    "fever" => "Infectious Diseases", // Changed from "General Practitioner" due to possible infection-related issues
                    "cough" => "Pulmonologist",
                    "stomach pain" => "Gastroenterologist",
                    "fatigue" => "Internal Medicine Specialist", // Changed from "General Hematology"
                    "rash" => "Dermatologist",
                    "trauma" => "Accident and Emergency Medicine",
                    "acute medical conditions" => "Accident and Emergency Medicine",
                    "poisoning" => "Accident and Emergency Medicine",
                    "allergic reactions" => "Allergology",
                    "asthma" => "Allergology",
                    "anaphylaxis" => "Allergology",
                    "pain management" => "Anaesthetics",
                    "anemia" => "Biological Hematology",
                    "bruising" => "Biological Hematology",
                    "chest pain" => "Cardiology",
                    "heart palpitations" => "Cardiology",
                    "shortness of breath" => "Cardiology",
                    "behavioral issues in children" => "Child Psychiatry",
                    "mood swings" => "Child Psychiatry",
                    "biological sample analysis" => "Clinical Biology",
                    "blood chemistry abnormalities" => "Clinical Chemistry",
                    "seizures" => "Clinical Neurophysiology",
                    "tremors" => "Clinical Neurophysiology",
                    "imaging for diagnosis" => "Clinical Radiology",
                    "dental pain" => "Dental, Oral and Maxillo-Facial Surgery",
                    "oral infections" => "Dental, Oral and Maxillo-Facial Surgery",
                    "sexually transmitted infections" => "Dermato-Venerology",
                    "hormone imbalances" => "Endocrinology",
                    "diabetes" => "Endocrinology",
                    "digestive disorders requiring surgery" => "Gastro-Enterologic Surgery",
                    "digestive system issues" => "Gastroenterology",
                    "bleeding disorders" => "General Hematology",
                    "common illnesses" => "General Practice",
                    "preventive care" => "General Practice",
                    "surgical conditions" => "General Surgery",
                    "pain requiring surgery" => "General Surgery",
                    "aging-related symptoms" => "Geriatrics",
                    "chronic conditions in the elderly" => "Geriatrics",
                    "immune system disorders" => "Immunology",
                    "frequent infections" => "Immunology",
                    "infections" => "Infectious Diseases",
                    "respiratory issues" => "Internal Medicine Specialist", // Already listed as internal medicine in fatigue case
                    "cardiovascular issues" => "Cardiology",
                    "gastrointestinal issues" => "Gastroenterology",
                    "lab tests and analysis" => "Laboratory Medicine",
                    "facial surgery" => "Maxillo-Facial Surgery",
                    "jaw issues" => "Maxillo-Facial Surgery"
                );
                

                // Get user input
                if(isset($_POST['symptoms'])) {
                    $user_symptoms = strtolower($_POST['symptoms']);
                    
                    // Process user input
                    $user_symptoms_array = explode(",", $user_symptoms); // Assuming symptoms are comma-separated
                    
                    // Check if the user entered more than 2 symptoms
                    if(count($user_symptoms_array) > 2) {
                        echo "<br><strong>Consult a physician for proper evaluation and diagnosis.</strong>";
                        exit; // Stop further processing
                    }
                    
                    // Spell check and auto-correction
                    $corrected_symptoms = array();
                    foreach($user_symptoms_array as $symptom) {
                        $closest_match = null;
                        $min_distance = PHP_INT_MAX;
                        foreach($symptom_doctor_map as $valid_symptom => $doctor) {
                            $distance = levenshtein($symptom, $valid_symptom);
                            if($distance < $min_distance) {
                                $closest_match = $valid_symptom;
                                $min_distance = $distance;
                            }
                        }
                        if($min_distance <= 2) { // If the distance is small, consider it a match
                            $corrected_symptoms[] = $closest_match;
                        } else {
                            $corrected_symptoms[] = $symptom; // Keep the original if no close match found
                        }
                    }
                    
                    // Match symptoms to doctors/specialists
                    $matched_doctors = array();
                    foreach($corrected_symptoms as $symptom) {
                        $symptom = trim($symptom); // Remove leading/trailing whitespace
                        if(isset($symptom_doctor_map[$symptom])) {
                            $matched_doctors[] = $symptom_doctor_map[$symptom];
                        }
                    }
                    
                    // Display matched doctors/specialists
                    if(!empty($matched_doctors)) {
                        echo "<br><strong style='padding-left:50px;'> Based on your symptoms, you may need to consult the following doctor/specialist(s):</strong><br><br>";
                        foreach($matched_doctors as $doctor) {
                            echo "- " . $doctor . "<br>";
                        }
                    } else {
                        echo "<br><strong>No matching doctor/specialist found for the entered symptoms.</strong>";
                    }

                    
                }
            }
            ?>
            <p style="padding-left: 50px;">You can look for the doctors <b>@All Doctors</b>.</p>
        </div>
    </body>
</html>
