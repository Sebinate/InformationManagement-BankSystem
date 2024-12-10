<?php 
    $user = "root";
    $password = "1234";
    $database = "BANK_SYSTEM";
    $servername = "localhost:3310";

    $mysqli = new mysqli($servername, $user, $password, $database);

    if ($mysqli->connect_error) {
        die('Connect Error(' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }

    include 'addaccfields.php';

    $password = $_REQUEST['password'];
    $confirm = $_REQUEST['confirm-password'];
    $pickedtype = $_REQUEST['accountType'];

    if($password != $confirm)
    {
        header('Location:error.html');
        exit();
    }

    $insertsql = "INSERT INTO ACCOUNT (ACC_ID, ACC_STATUS, ACC_TYPE) VALUES ('$acc_code', 'Active', '$pickedtype')";

    if($pickedtype == 'savings')
    {
        $insertacctype = "INSERT INTO SAVINGS (ACC_ID, SAV_BAL, SAV_RATE, SAV_PIN) VALUES ('$acc_code', 0.00, 0.05, $password)";
    }

    elseif($pickedtype == 'credit')
    {
        $insertacctype = "INSERT INTO CREDIT (ACC_ID, CRD_LIMIT, CRD_SCR, CRD_BALANCE, CRD_PIN) VALUES ('$acc_code', 10000.00, 700, 0.00, $password)";
    }

    if(mysqli_query($mysqli, query: $sql))
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
    <head>
    </head>
    <body>
        <form action="../Login.html" action="POST">
            <input type="submit" value="Back to Login">
        </form>
    </body>
</html>