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
    include 'bridge.php';

    $amount = $_REQUEST['payment_amount'];

    #Selecting Random Employee
    $randemploy = "SELECT EMP_ID FROM EMPLOYEE ORDER BY RAND() LIMIT 1";
    $randemployquery = $mysqli -> query($randemploy);
    $resultrademp = $randemployquery -> fetch_assoc();

    $emp = $resultrademp['EMP_ID'];

    #getting the client id
    $client_statemet = "SELECT CL_ID FROM RECORDS WHERE ACC_ID = '$uname'";
    $client_query = $mysqli -> query($client_id);
    $client_result = $client_query -> fetch_assoc();

    $cl_id = $client_result['CL_ID'];

    #Inserting into transaction table

    $transact = "INSERT INTO TRANSACTION (TRANSACT_NUM, TRANSACT_TYPE, TRANSACT_AMMOUNT, EMP_ID, CL_ID, ACC_ID) VALUES ('$uname', 'credit', '$amount', '$emp', '$cl_id', '$uname')";
    if(mysqli_query($mysqli, query: $sql))
    {
        echo "Data Stored in Database successfully";
    }
    else
    {
        echo mysqli_error($mysqli);
    }

    #Update Credit Table
    $updatecred = "UPDATE CREDIT SET CRD_BALANCE = CRD_BALANCE + '$amount' WHERE ACC_ID = '$uname'";
    if(mysqli_query($mysqli, query: $sql))
    {
        echo "Data Updated in Database successfully";
    }
    else
    {
        echo mysqli_error($mysqli);
    }

?>
<html>
    <head>
    </head>
    <body>
        <form action="creditpage.php" action="POST">
            <input type="submit" value="Back to Credit Page">
        </form>
    </body>
</html>