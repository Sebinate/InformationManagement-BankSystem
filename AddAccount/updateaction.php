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

    $password = $_REQUEST['password'];
    $confirm = $_REQUEST['confirm-password'];

    $email = $_REQUEST['email'];
    $name = $_REQUEST['username'];
    $number = $_REQUEST['number'];
    $address = $_REQUEST['address'];

    $passchecker = "SELECT * FROM CLIENT WHERE CL_ID = '$uname'";
    $passquery = $mysqli -> query($passchecker);
    $pass_result = $passquery -> fetch_assoc();

    if($pass_result['CL_PIN'] != $password)
    {
        header('Location:https://localhost/Final/AddAccount/error.html');
        exit();
    }

    if($password != $confirm)
    {
        header('Location:https://localhost/Final/AddAccount/error.html');
        exit();
    }

    if(strlen($name) > 50)
    {
        header('Location:http://localhost/Final/AddAccount/error2.html');
        exit(); 
    }

    if(strlen($address) > 50)
    {
        header('Location:http://localhost/Final/AddAccount/error2.html');
        exit(); 
    }

    $regex1 = '/^\+63\d{10}$/';
    if(preg_match($regex1, $number) == 0)
    {
        header('Location:http://localhost/Final/AddAccount/error2.html');
        exit(); 
    }

    $regex2 = '/^[a-zA-Z0-9.*]+@[a-zA-Z]{3,}+\.[a-zA-Z]{3,}$/';
    if(preg_match($regex2, $email) == 0)
    {
        header('Location:http://localhost/Final/AddAccount/error2.html');
        exit(); 
    }

    $sql = "UPDATE CLIENT SET CL_NAME = '$name', CL_ADDRESS = '$address', CL_PHONE = '$number', CL_EMAIL = '$email' WHERE CL_ID = '$uname'";
    if(mysqli_query($mysqli, $sql))
    {
        echo "Data Stored in Database successfully";        
    }
    else
    {
        echo mysqli_error($mysqli);
    }
?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="../Login.html">
            <input type="submit" value="To Login">
        </form>

</html>
