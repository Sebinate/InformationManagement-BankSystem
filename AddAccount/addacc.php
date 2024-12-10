<?php 
    $user = "root";
    $password = "1234";
    $database = "BANK_SYSTEM";
    $servername = "localhost:3310";

    $mysqli = new mysqli($servername, $user, $password, $database);

    if ($mysqli->connect_error) {
        die('Connect Error(' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }
    session_start();
    $uname = $_SESSION['uname'];
    $acc_code = $_SESSION['acc_code'];
    $password = $_REQUEST['password'];
    $confirm = $_REQUEST['confirm-password'];
    $pickedtype = $_SESSION['acctype'];

    if($password != $confirm)
    {
        header('Location:https://localhost/Final/AddAccount/error.html');
        exit();
    }

    echo $pickedtype;
    $insertsql = "INSERT INTO ACCOUNT (ACC_ID, ACC_STATUS, ACC_TYPE) VALUES ('$acc_code', 'Active', '$pickedtype')";
    if(mysqli_query($mysqli, $insertsql))
        {
            echo "Data Stored in Database successfully";
        }
        else
        {
            echo mysqli_error($mysqli);
        }

    if($pickedtype == 'savings')
    {
        $insertacctype = "INSERT INTO SAVINGS (ACC_ID, SAV_BAL, SAV_RATE, SAV_PIN) VALUES ('$acc_code', 0.00, 0.05, $password)";
        if(mysqli_query($mysqli, $insertacctype))
        {
            echo "Data Stored in Database successfully";
        }
        else
        {
            echo mysqli_error($mysqli);
        }
    }

    elseif($pickedtype == 'credit')
    {
        $insertacctype = "INSERT INTO CREDIT (ACC_ID, CRD_LIMIT, CRD_SCR, CRD_BALANCE, CRD_PIN) VALUES ('$acc_code', 10000.00, 700, 0.00, $password)";
        if(mysqli_query($mysqli, $insertacctype))
        {
            echo "Data Stored in Database successfully";
        }
        else
        {
            echo mysqli_error($mysqli);
        }
    }

    $records = "INSERT INTO RECORDS(CL_ID, ACC_ID) VALUES ('$uname', '$acc_code')";
    if(mysqli_query($mysqli, $records))
    {
        echo "Data Stored in Database successfully";
    }
    else
    {
        echo mysqli_error($mysqli);
    }

    $mysqli -> close();

?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <form action="../Login.html" action="POST">
            <input type="submit" value="Back to Login">
        </form>
    </body>
</html>