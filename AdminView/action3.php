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

    $transaction_number_input = $_REQUEST['transaction_number'];
    if($transaction_number_input < 10)
    { 
        $transaction_number = "00000$transaction_number_input";
    }

    elseif($transaction_number_input >= 10 & $transaction_number_input < 100)
    {
        $transaction_number = "0000$transaction_number_input";
    }

    elseif($transaction_number_input >= 100 & $transaction_number_input < 1000)
    {
        $transaction_number = "000$transaction_number_input";
    }

    elseif($transaction_number_input >= 1000 & $transaction_number_input < 10000)
    {
        $transaction_number = "00$transaction_number_input";
    }

    elseif($transaction_number_input >= 10000 & $transaction_number_input < 100000)
    {
        $transaction_number = "0$transaction_number_input";
    }

    elseif($transaction_number_input >= 100000 & $transaction_number_input < 1000000)
    {
        $transaction_number = "$transaction_number_input";
    }

    else
    {
        header('Location:http://localhost/AdminView/error.html');
        exit(); 
    }
    
    $transaction_type = $_REQUEST['transaction_type'];
    if (trim($transaction_type) === '' || strlen($transaction_type) > 12) {
        header('Location:http://localhost/AdminView/error.html');
        exit();
    }

    $transaction_amount = $_REQUEST['transaction_amount'];
    if (!is_float($transaction_amount) || $transaction_amount <= 0) {
        header('Location:http://localhost/AdminView/error.html');
        exit();
    }

    $employee_id_input = $_REQUEST['employee_id'];
    if($employee_id_input < 10)
    { 
        $employee_id = "000$employee_id_input";
    }

    elseif($employee_id_input >= 10 & $employee_id_input < 100)
    {
        $employee_id = "00$employee_id_input";
    }

    elseif($employee_id_input >= 100 & $employee_id_input < 1000)
    {
        $employee_id = "0$employee_id_input";
    }

    elseif($employee_id_input >= 1000 & $employee_id_input < 10000)
    {
        $employee_id = "$employee_id_input";
    }

    else
    {
        header('Location:http://localhost/AdminView/error.html');
        exit(); 
    }

    $sql = "SELECT IFNULL((SELECT EMP_ID FROM EMPLOYEE WHERE EMP_ID = '$employee_id'), 'error') AS col1";
    $query = $mysqli -> query($sql);
    $result = $query -> fetch_assoc();

    if($result['col1'] == 'error')
    {
        header('error.html');
        exit();
    }

    $client_id_input = $_REQUEST['client_id'];
    $client_id = $_REQUEST['client_code'];
    if($client_id < 10)
    {
        $client_id = "000$client_id";
    }

    elseif($client_id >= 10 & $client_id < 100)
    {
        $client_id = "00$client_id";
    }

    elseif($client_id >= 100 & $client_id < 1000)
    {
        $client_id = "0$client_id";
    }

    elseif($client_id >= 1000 & $client_id < 10000)
    {
        $client_id = (string)$client_id;
    }

    else
    {
        header('Location:http://localhost/banksystem/AdminView/error.html');
        exit(); 
    }

    $sql = "SELECT IFNULL((SELECT CL_ID FROM CLIENT WHERE CL_ID = '$employee_id'), 'error') AS col1";
    $query = $mysqli -> query($sql);
    $result = $query -> fetch_assoc();

    if($result['col1'] == 'error')
    {
        header('error.html');
        exit();
    }

    $account_id_input = $_REQUEST['account_id'];
    if($account_id_input < 10)
    { 
        $account_id = "00000$account_id_input";
    }

    elseif($account_id_input >= 10 & $account_id_input < 100)
    {
        $account_id = "0000$account_id_input";
    }

    elseif($account_id_input >= 100 & $account_id_input < 1000)
    {
        $account_id = "000$account_id_input";
    }

    elseif($account_id_input >= 1000 & $account_id_input < 10000)
    {
        $account_id = "00$account_id_input";
    }

    elseif($account_id_input >= 10000 & $account_id_input < 100000)
    {
        $account_id = "0$account_id_input";
    }

    elseif($account_id_input >= 100000 & $account_id_input < 1000000)
    {
        $account_id = "$account_id_input";
    }

    else
    {
        header('Location:http://localhost/AdminView/error.html');
        exit(); 
    }

    $sql = "SELECT IFNULL((SELECT ACC_ID FROM ACCOUNT WHERE ACC_ID = '$account_id'), 'error') AS col1";
    $query = $mysqli -> query($sql);
    $result = $query -> fetch_assoc();

    if($result['col1'] == 'error')
    {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    if(isset($_POST['insert']))
    {
        $sqlcheck = "SELECT COUNT(1) AS checker FROM TRANSACTION WHERE TRANSACT_NUM = '$transaction_number'";
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/Final/AdminView/error.html');
            exit();
        }
        
        $sql =  "INSERT INTO TRANSACTION (TRANSACT_NUM, TRANSACT_TYPE, TRANSACT_AMOUNT, EMP_ID, CL_ID, ACC_ID) VALUES ('$transaction_number', '$transaction_type', '$transaction_amount', '$employee_id', '$client_id', '$account_id')";
        if(mysqli_query($mysqli, $sql))
        {
            echo "Data Stored in Database successfully";
        }
        else
        {
            echo mysqli_error($mysqli);
        }
        
    }

    elseif(isset($_POST['update']))
    {
        $origin = "SELECT * FROM TRANSACTION WHERE TRANSACT_NUM = '$transaction_number";
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if($transaction_type != '' & $transaction_type != $row['TRANSACT_TYPE'])
        {
            $transaction_type = $transaction_type;
        }

        else
        {
            $transaction_type = $row['TRANSACT_TYPE'];
        }

        if($transaction_amount != '' & $transaction_amount != $row['TRANSACT_AMOUNT'])
        {
            $transaction_amount = $transaction_amount;
        }

        else
        {
            $transaction_amount = $row['TRANSACT_AMOUNT'];
        }

        if($employee_id != '' & $employee_id != $row['EMP_ID'])
        {
            $sql = "SELECT IFNULL((SELECT EMP_ID FROM EMPLOYEE WHERE EMP_ID = '$employee_id'), 'error') AS col1";
            $query = $mysqli -> query($sql);
            $result = $query -> fetch_assoc();
        
            if($result['col1'] == 'error')
            {
                header('Location:http://localhost/Final/AdminView/error.html');
                exit();
            }

            $employee_id = $employee_id;
        }

        else
        {
            $employee_id = $row['EMP_ID'];
        }
    
        if($client_id != '' & $client_id != $row['CL_ID'])
        {
            $sql = "SELECT IFNULL((SELECT CL_ID FROM CLIENT WHERE CL_ID = '$client_id'), 'error') AS col1";
            $query = $mysqli -> query($sql);
            $result = $query -> fetch_assoc();
        
            if($result['col1'] == 'error')
            {
                header('Location:http://localhost/Final/AdminView/error.html');
                exit();
            }

            $client_id = $client_id;
        }

        else
        {
            $client_id = $row['CL_ID'];
        }

        if($account_id != '' & $account_id != $row['ACC_ID'])
        {
            $sql = "SELECT IFNULL((SELECT ACC_ID FROM CLIENT WHERE ACC_ID = '$account_id'), 'error') AS col1";
            $query = $mysqli -> query($sql);
            $result = $query -> fetch_assoc();
        
            if($result['col1'] == 'error')
            {
                header('Location:http://localhost/Final/AdminView/error.html');
                exit();
            }
            
            $account_id = $account_id;
        }

        else
        {
            $account_id = $row['ACC_ID'];
        }
       

        $sqlr = "UPDATE TRANSACTION SET TRANSACT_NUM = '$transaction_number', TRANSACT_TYPE = '$transaction_type', TRANSACT_AMOUNT = '$transaction_amount', EMP_ID = '$employee_id', CL_ID = '$client_id' WHERE ACC_ID = '$account_id'";

        if (mysqli_query($mysqli, $sqlr))
        
        {
            echo 'Data Updated from Database Successfully!';
        }
        else
        {
            echo mysqli_error($mysqli);
        }
    }

    elseif(isset($_POST['delete']))
    {
        $sql = "DELETE FROM EMPLOYEE WHERE TRANSACT_NUM = '$transaction_number'";
        if (mysqli_query($mysqli, $sql))
        {
            echo "Successfully Deleted record from Database!";
        }
        else
        {
            echo mysqli_error($mysqli);
        }
    }
           
    $mysqli -> close();
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="AdminView.php" method="POST">
            <input type="submit" value = "Back">
        </form>
    </body>

</html>
