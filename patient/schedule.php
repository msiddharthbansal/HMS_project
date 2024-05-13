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



        



        <div class="dash-body">


        
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                     <td >
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors" value="<?php  echo $insertkey ?>">&nbsp;&nbsp;
                             <?php
                                echo '<datalist id="doctors">';
                                $list11 = $database->query("select DISTINCT * from  doctor;");
                                $list12 = $database->query("select DISTINCT * from  schedule GROUP BY title;");

                                for ($y=0;$y<$list11->num_rows;$y++) {
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["docname"];
                                    echo "<option value='$d'><br/>";
                                }

                                for ($y=0;$y<$list12->num_rows;$y++) {
                                    $row00=$list12->fetch_assoc();
                                    $d=$row00["title"];
                                    if ($d != "Test Session") { 
                                        echo "<option value='$d'><br/>";
                                    }
                                }
                                echo ' </datalist>';
                            ?>

                            
                            <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                echo $today;
                            ?>
                        </p>
                    </td>

                    
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q.$insertkey.$q ; ?> </p>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="4">
                        <center>

                        <div class= "container1"> 
      
    <form action="login.php" method="post">
        <h2>APPOINTMENT FORM</h2>
        <?php if(isset($_GET['error'])) {?>
            <p class="error"><?php echo $_GET['error'];?></p>
        <?php } ?>

    
     <!--   <input type="text" name="uname" required><br><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required><br><br> -->

        <label for="department" style="color: black;">Department:</label>
        <select id="department" name="department" required style="color: black;">
        <option value="">-- Select Department --</option>
        <?php 
            $list11 = $database->query("select sname from  specialties order by sname asc;");
        
                                        for ($y=0;$y<$list11->num_rows;$y++){
                                            $row00=$list11->fetch_assoc();
                                            $sn=$row00["sname"];
                                            echo "<option value=".$sn.">$sn</option><br/>";
                                        };
        ?>
            
            
        </select><br><br>

        <label for="date">Preferred Date:</label>
        <input type="date" id="date" name="date" min= "<?php echo $today; ?>"required><br><br>

        <label for="time">Preferred Time:</label>
        <input type="time" id="time" name="time" required><br><br>

        <label for="message">Additional Information (optional):</label>
        <textarea id="message" name="message" rows="4"></textarea><br>

        <!--<button type="submit">Submit Appointment Request</button>-->
        <input type="submit" value="Submit Appointment Request" class="logout-btn btn-primary-soft btn"><br>
                    <?php
                
                    /* echo $username , "<br>"; echo $usertel,"<br>"; 
                        $_SESSION["name"]=$username;
                        $_SESSION["tel"]=$usertel;
                        $_SESSION["pid"]=$userid;
                        $_SESSION["email"]=$useremail;*/
                        ?>
                    </form> 
                    </div>
                           
                        </center>
                    </td> 
                </tr>
            </table>
        </div>


     


</body>
</html>
