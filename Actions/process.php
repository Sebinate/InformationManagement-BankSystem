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

    $amount = $_REQUEST['payment_amount'];

    #Selecting Random Employee
    $randemploy = "SELECT EMP_ID FROM EMPLOYEE ORDER BY RAND() LIMIT 1";
    $randemployquery = $mysqli -> query($randemploy);
    $resultrademp = $randemployquery -> fetch_assoc();

    $emp = $resultrademp['EMP_ID'];

    #getting the client id
    $client_statemet = "SELECT CL_ID FROM RECORDS WHERE ACC_ID = '$uname'";
    $client_query = $mysqli -> query($client_statemet);
    $client_result = $client_query -> fetch_assoc();

    $cl_id = $client_result['CL_ID'];

    #Generating transact num
    $transactchecker = "SELECT IFNULL((SELECT TRANSACT_NUM FROM TRANSACTION ORDER BY TRANSACT_NUM DESC LIMIT 1), 'DNE') AS col1";
    $transactquery = $mysqli -> query($transactchecker);
    $transactresult = $transactquery -> fetch_assoc();

    if($transactresult['col1'] == 'DNE')
    {
        $transact_id = '000001';
    }
    
    else
    {
        $transact_id_counter = $transactresult['col1'] + 1;

        if($transact_id_counter < 10)
        {
            $transact_id = "00000$transact_id_counter";
        }
        elseif($transact_id_counter >= 10 & $transact_id_counter < 100)
        {
            $transact_id = "0000$transact_id_counter";
        }
        elseif($transact_id_counter >= 100 & $transact_id_counter < 1000)
        {
            $transact_id = "000$transact_id_counter";
        }
        elseif($transact_id_counter >= 1000 & $transact_id_counter < 10000)
        {
            $transact_id = "00$transact_id_counter";
        }
        elseif($transact_id_counter >= 10000 & $transact_id_counter < 100000)
        {
            $transact_id = "0$transact_id_counter";
        }
        elseif($transact_id_counter >= 100000 & $transact_id_counter < 10000000)
        {
            $transact_id = '$transact_id_counter';
        }
    }

    #Inserting into transaction table
    $transact = "INSERT INTO TRANSACTION(TRANSACT_NUM, TRANSACT_TYPE, TRANSACT_AMOUNT, EMP_ID, CL_ID, ACC_ID) VALUES ('$transact_id', 'credit', $amount, '$emp', '$cl_id', '$uname')";
    if(mysqli_query($mysqli, $transact))
    {
        echo "Data Stored in Database successfully";
    }
    else
    {
        echo mysqli_error($mysqli);
    }

    #Update Credit Table
    $updatecred = "UPDATE CREDIT SET CRD_BALANCE = CRD_BALANCE + '$amount' WHERE ACC_ID = '$uname'";
    if(mysqli_query($mysqli, query: $updatecred))
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