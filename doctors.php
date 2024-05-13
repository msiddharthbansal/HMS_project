<?php
// Include the connection.php file
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">  
    <link rel="icon" href="img/healthlogo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team of Physicians</title>
    <style>
        .link-box {
            display: inline-block;
            padding: 10px 20px; /* Adjust padding as needed */
            background-color:var(--primarycolor) ; /* Background color */
            color: #fff; /* Text color */
            text-decoration: none; /* Remove default underline */
            border-radius: 5px; /* Rounded corners */
            border: 1px solid var(--primarycolor); /* Border */
            transition: background-color 0.3s ease; /* Smooth transition for hover effect */
        }

        .link-box:hover {
            background-color: #ddd; /* Background color on hover */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(img/bg8.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .doctor {
            margin-bottom: 30px;
        }
        .doctor h2 {
            color: #333;
        }
        .doctor p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<a href="index.html" class="link-box"><-  Back to Home</a>
<div class="container">
    <h1>Meet Our Dedicated Team of Doctors</h1>

    <p>At Health Sphere, we're proud to have assembled a team of highly skilled and compassionate physicians who are dedicated to providing exceptional care to our patients. Each member of our team brings a wealth of experience, expertise, and a commitment to delivering personalized healthcare solutions tailored to your individual needs.</p>
    
    <?php
    // Fetch doctors from the database
    $query = "SELECT * FROM doctor d, specialties s WHERE d.specialties = s.id";
    $result = $database->query($query);
    $query = "SELECT sname FROM specialities WHERE ";
    // Check if any rows were returned
    if($result->num_rows > 0) {
        // Display doctors
        while($row = $result->fetch_assoc()) {
            if ($row['docimage']) 
            {
                echo '<img src=' . $row['docimage'] . ' alt="Image" width= "' . 150 . '" height="' . 150 . '">'; 
            } else {
                echo "Image Not Found";
            }
            echo "<div class='doctor'>";
            echo "<h2>" . $row['docname'] . "</h2>"; // Change 'doctor_name' to the actual column name in your database
            echo "<p><strong>Specialization:</strong> " . $row['sname'] . "</p>"; // Change 'specialization' to the actual column name in your database
            echo "<p>" . $row['qualification'] . "</p>"; // Change 'description' to the actual column name in your database
            echo "</div>";
        }
    } else {
        // No doctors found
        echo "<p>No doctors found.</p>";
    }

    // Close database connection (optional as $database is already defined in connection.php)
    $database->close();
    ?>

    <p>We invite you to get to know our team of physicians and discover how their expertise can support you on your journey to better health.</p>
</div>

</body>
</html>
