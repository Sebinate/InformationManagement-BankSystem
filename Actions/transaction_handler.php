<?php
    $user = "root";
    $password = "1234";
    $database = "BANK_SYSTEM";
    $servername = "localhost:3310";
    
    $mysqli = new mysqli($servername, $user, $password, $database); 
    
    
    if($mysqli -> connect_error)
    {
        die('Connect Error('.$mysqli->connect_errno.')'.$mysqli->connect_error);
    }
    session_start();

    $amount = $_REQUEST['amount'];
    $uname = $_SESSION['uname'];
    $action = $_REQUEST['action'];

    $randemploy = "SELECT EMP_ID FROM EMPLOYEE ORDER BY RAND() LIMIT 1";
    $randemployquery = $mysqli -> query($randemploy);
    $resultrademp = $randemployquery -> fetch_assoc();

    $emp = $resultrademp['EMP_ID'];

    $balchecker = "SELECT SAV_BAL FROM SAVINGS WHERE ACC_ID = '$uname'";
    $balquery = $mysqli -> query($balchecker);
    $balresult = $balquery -> fetch_assoc();

    
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
            $transact_id = (string)$transact_id_counter;
        }
    }

    $client_statemet = "SELECT CL_ID FROM RECORDS WHERE ACC_ID = '$uname'";
    $client_query = $mysqli -> query($client_statemet);
    $client_result = $client_query -> fetch_assoc();

    $cl_id = $client_result['CL_ID'];

    if($action == 'withdraw')
    {   
        $amount = -$amount;
        if(($balresult['SAV_BAL'] + $amount) < 0)
        {
            header('Location:https://localhost/Final/Actions/error2.html');
            exit();
        }

        else
        {
            $sqlr = "UPDATE SAVINGS SET SAV_BAL = SAV_BAL + '$amount' WHERE ACC_ID = '$uname'";
            if (mysqli_query($mysqli, $sqlr))
            {
                echo 'Data Updated from Database Successfully!';
            }
            else
            {
                echo mysqli_error($mysqli);
            }

            $insertsql = "INSERT INTO TRANSACTION(TRANSACT_NUM, TRANSACT_TYPE, TRANSACT_AMOUNT, EMP_ID, CL_ID, ACC_ID) VALUES ('$transact_id', '$action', $amount, '$emp', '$cl_id', '$uname')";
            if (mysqli_query($mysqli, $insertsql))
            {
                echo 'Data Inserted from Database Successfully!';
            }
            else
            {
                echo mysqli_error($mysqli);
            }
        }
    }

    else
    {
        if($amount < 0)
        {
            header('Location:https://localhost/Final/Actions/error2.html');
            exit();
        }

        else
        {
            $sqlr = "UPDATE SAVINGS SET SAV_BAL = SAV_BAL + '$amount' WHERE ACC_ID = '$uname'";
            if (mysqli_query($mysqli, $sqlr))
            {
                echo 'Data Updated from Database Successfully!';
            }
            else
            {
                echo mysqli_error($mysqli);
            }

            $insertsql = "INSERT INTO TRANSACTION (TRANSACT_NUM, TRANSACT_TYPE, TRANSACT_AMOUNT, EMP_ID, CL_ID, ACC_ID) VALUES ('$transact_id', '$action', $amount, '$emp', '$cl_id', '$uname')";
            if (mysqli_query($mysqli, $insertsql))
            {
                echo 'Data Inserted from Database Successfully!';
            }
            else
            {
                echo mysqli_error($mysqli);
            }
        }  
    }
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="front_end_trans_nocred.php" method="POST">
            <input type="submit" value="Back to Transaction Tab">
        </form>
    </body>
</html>

