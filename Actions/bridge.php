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

    $uname = $_REQUEST['uname'];
    $pass = $_REQUEST['psw'];

    $existance = "SELECT IFNULL((SELECT ACC_ID FROM ACCOUNT WHERE ACC_ID = '$uname'), 'DNE') AS col1";
    $existancequery = $mysqli -> query($existance);
    $existanceresult = $existancequery -> fetch_assoc();

    if($existanceresult['col1'] == 'DNE')
    {
        header("Location:error.html");
        exit();
    }

    $passchecker = "SELECT * FROM ACCOUNT WHERE ACC_ID = '$uname'";
    $passquery = $mysqli -> query($passchecker);
    $passresult = $passquery -> fetch_assoc();

    if($passresult['ACC_PIN'] != $pass)
    {
        header('Location:error.html');
        exit();
    }

    if($passresult['ACC_TYPE'] == 'savings')
    {
        header('Location:https://localhost/banksystem/Actions/savings.php');
        exit();
    }

    else
    {
        header("Location:https://localhost/banksystem/Actions/creditpage.php");
        exit(); 
    }

?>