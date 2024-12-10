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


    $_SESSION['uname'] = $_REQUEST["name"];
    $_SESSION['password'] = $_REQUEST["pass"];

    $uname = $_SESSION['uname'];
    $password = $_SESSION['password'];

    $existance = "SELECT IFNULL((SELECT ACC_ID FROM ACCOUNT WHERE ACC_ID = '$uname'), 'DNE') AS col1";
    $existancequery = $mysqli -> query($existance);
    $existanceresult = $existancequery -> fetch_assoc();

    if($existanceresult['col1'] == 'DNE')
    {
        echo $existanceresult["col1"];
        // header("Location:https://localhost/Final/Actions/error1.html");
        // exit();
    }

    $typechecker = "SELECT * FROM ACCOUNT WHERE ACC_ID = '$uname'";
    $typequery = $mysqli -> query($typechecker);
    $typeresult = $typequery -> fetch_assoc();

    if($typeresult['ACC_TYPE'] == 'savings')
    {
        $pass = "SELECT SAV_PIN FROM SAVINGS WHERE ACC_ID = '$uname'";
        $passquery = $mysqli -> query($pass);
        $passresult = $passquery -> fetch_assoc();

        if((string)$passresult['SAV_PIN'] == $password)
        {
            header('Location:https://localhost/Final/Actions/savings.php');
            exit();
        }
        else
        {
            header('Location:https://localhost/Final/Actions/error2.html');
            exit();
        }
    }

    elseif($typeresult['ACC_TYPE'] == 'credit')
    {
        $pass = "SELECT * FROM CREDIT WHERE ACC_ID = '$uname'";
        $passquery = $mysqli -> query($pass);
        $passresult = $passquery -> fetch_assoc();

        if($passresult['CRD_PIN'] === $password)
        {
            header('Location:https://localhost/Final/Actions/creditpage.php');
            exit();
        }

        else
        {   
            header('Location:https://localhost/Final/Actions/error3.html');
            exit();
        } 
    }

?>