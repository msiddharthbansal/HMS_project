<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
     
        
    <title>Dashboard</title>

     
</head>

<body>
    <div class="container"> 
    <form action="login.php" method="post">
        <h2>Login</h2>
        <?php if(isset($_GET['error'])) {?>
            <p class="error"><?php echo $_GET['error'];?></p>
        <?php } ?>

        <label>User Name</label>
        <input type="text" name="uname" required><br><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required><br><br>

        <label for="department">Department:</label>
        <select id="department" name="department" required>
            <option value="">-- Select Department --</option>
            <option value="cardiology">Cardiology</option>
            <option value="neurology">Neurology</option>
            <option value="pediatrics">Pediatrics</option>
        </select><br><br>

        <label for="date">Preferred Date:</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="time">Preferred Time:</label>
        <input type="time" id="time" name="time" required><br><br>

        <label for="message">Additional Information (optional):</label>
        <textarea id="message" name="message" rows="4"></textarea><br><br>

        <button type="submit">Submit Appointment Request</button>
    </form>
    </div>


</body>
</html>
