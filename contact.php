<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/main.css">  
    <link rel="icon" href="img/healthlogo.png" type="image/x-icon">
    <title>Health Sphere Hospital Contact Information</title>
    <style>
        .link-box {
            display: inline-block;
            padding: 10px 20px; /* Adjust padding as needed */
            background-color:var(--primarycolor) ; /* Background color */
            color: #fff; /* Text color */
            text-decoration: none; /* Remove default underline */
            border: 1px solid var(--primarycolor); /* Border */
            transition: background-color 0.3s ease; /* Smooth transition for hover effect */
        }

        .link-box:hover {
            background-color: #ddd; /* Background color on hover */
        }
        body {
            font-family: Arial, sans-serif; /* Set font family */
            background-image: url(img/bg7.jpg)            
        }
        h1 {
            margin-top: 50px; /* Add margin to the top of the heading */
        }
        .container {
            display: flex; /* Use flexbox for layout */
            justify-content: center; /* Center-align items horizontally */
            margin-top:100px; /* Add margin to the top of the container */
           background-color: #FFF;
           width: 800px;
           margin: 0 auto;
           padding: 30px;
           border-radius: 10px;
           border-color: 
        }
        .contact-info {
            text-align: left; /* Left-align text */
            margin-right: 100px; /* Add margin to the right of the contact info */
        }
        .contact-info p {
            margin: 10px 0; /* Add margin to the paragraphs */
        }
        .location {
            text-align: left; /* Left-align text */
        }
        .map {
            margin-top: 20px; /* Add margin to the top of the map */
        }
    </style>
</head>
<body>
<a href="index.html" class="link-box"><-  Back to Home</a>
<div style="text-align: center;"> <br><br>
<h1 style= "background-color: #fff; width: 500px; text-align: center; margin: 0 auto;">Health Sphere Hospital</h1>
<br><br>
<div class="container">
    <div class="contact-info">
        
        <h2>Contact Information:</h2> <br>
        <p><strong>Phone Number:</strong> <span>888-298-0499, 636-468-7330</span><br></p>
        <p><strong>Email:</strong> <a href="mailto:contactus@healthspherehospital.com">info@healthspherehospital.com</a></p>
        <p><strong>Address:</strong> Health Sphere Hospital, Khokhra Circle, Maninagar, Ahmedabad, Gujarat 380008</p>
    </div>

    <div class="location">
        <h2>Location:</h2>
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3672.62239!2d72.550621!3d23.00428!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e8506e0ad3e17%3A0xa91dd3db6c6c6678!2sIITRAM!5e0!3m2!1sen!2sin!4v1642168298321!5m2!1sen!2sin" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>
        </div>
</body>
</html>
