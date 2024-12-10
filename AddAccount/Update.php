<?php
    $user = "root";
    $password = "1234";
    $database = "BANK_SYSTEM";
    $servername = "localhost:3310";

    $mysqli = new mysqli($servername, $user, $password, $database); #TO access mysql database content

    #Connecting to the database
    if($mysqli -> connect_error)
    {
        die('Connect Error('.$mysqli->connect_errno.')'.$mysqli->connect_error);
    }

    session_start();

    $uname = $_SESSION['uname'];
    $psw = $_SESSION['psw'];

    $passchecker = "SELECT * FROM CLIENT WHERE CL_ID = '$uname'";
    $passquery = $mysqli -> query($passchecker);
    $pass_result = $passquery -> fetch_assoc();

    if($pass_result['CL_PIN'] != $psw)
    {
        header('Location:https://localhost/Final/AddAccount/error3.html');
        exit();
    }

    $mysqli -> close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../Sign-up/styles.css">
</head>

<body>
  <div class="container">
    <h1>Client Update Credentials Form</h1>
    <form action="updateaction.php" method="POST">
      <label2> Client Code: <?php echo $uname?> <br>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Create Username" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="number">Contact No. (+63)</label>
      <input type="text" id="number" name="number" placeholder="Enter your contact number" required>

      <label for="number">Address </label>
      <input type="text" id="number" name="address" placeholder="Enter your contact address" required>

      <label for="password">Password (Client pin)</label>
      <input type="password" id="password" name="password" placeholder="Create Password" required>

      <label for="confirm-password">Confirm Password</label>
      <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>

      <div class="options">
        <button type="submit" class="submit-btn" name="signup">Update</button>
        <button class="back-btn" type="button" onclick="window.location.href='../Login.html'">Back to Login</button>
      </div>
    </form>
  </div>
</body>
</html>

