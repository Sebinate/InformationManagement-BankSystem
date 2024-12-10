<?php
    $user = "root";
    $password = "1234";
    $database = "BANK_SYSTEM";
    $servername = "localhost:3310";

    $mysqli = new mysqli($servername, $user, $password, $database); #TO access mysql database content

    #Connecting to the database
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
        header('Location:http://localhost/Final/AdminView/error.html');
        exit(); 
    }

    $sql = "SELECT IFNULL((SELECT ACC_ID FROM ACCOUNT WHERE ACC_ID = '$account_id'), 'error') AS col1"; 
    $query = $mysqli->query($sql);
    $result = $query->fetch_assoc();

    if ($result['col1'] == 'error') 
    {
    header('Location:http://localhost/Final/AdminView/error.html');
    exit();
    }

    $credit_limit = $_REQUEST['credit_limit'];
    if (!is_float($credit_limit) || $credit_limit <= 0|| $credit_limit >= 100000000) {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    $credit_score = $_REQUEST['credit_score'];

    $credit_balance = $_REQUEST['credit_balance'];
    if (!is_float($credit_balance) || $credit_balance <= 0|| $credit_balance >= 100000000) {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    $credit_pin = $_REQUEST['credit_pin'];
    if (!ctype_digit($credit_pin) || strlen($credit_pin) !== 6) 
    {
    header('Location:http://localhost/Final/AdminView/error.html');
    exit();
    }

    if(isset($_POST['insert']))
    {
        $sqlcheck = "SELECT COUNT(1) AS checker FROM CREDIT WHERE ACC_ID = '$account_id'"; #pacheck if need ng checker since fk siya tas pano if ever dahil siya pk
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/Final/AdminView/error.html');
            exit();
        }
        
        $sql =  "INSERT INTO CREDIT (ACC_ID, CRD_LIMIT, CRD_SCR, CRD_BALANCE, CRD_PIN) VALUES ('$account_id', '$credit_limit', '$credit_score', '$credit_balance', '$credit_pin')";
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
        $origin = "SELECT * FROM CREDIT WHERE ACC_ID = '$account_id'"; #to rin
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if($credit_limit != '' & $credit_limit != $row['CRD_LIMIT'])
        {
            $credit_limit = $credit_limit;
        }

        else{
            $credit_limit = $row['CRD_LIMIT'];
        }

        if($credit_score != '' & $credit_score != $row['CRD_SCR'])
        {
            $credit_score = $credit_score;
        }

        else{
            $credit_score = $row['CRD_SCR'];
        }

        if($credit_balance != '' & $credit_balance != $row['CRD_BALANCE'])
        {
            $credit_balance = $credit_balance;
        }

        else{
            $credit_balance = $row['CRD_BALANCE'];
        }

        if($credit_pin != '' & $credit_pin != $row['CRD_PIN'])
        {
            $credit_pin = $credit_pin;
        }

        else{
            $credit_pin = $row['CRD_PIN'];
        }

        $sqlr = "UPDATE CREDIT SET ACC_ID = '$account_id', CRD_LIMIT = '$credit_limit', CRD_SCR = '$credit_score', CRD_BALANCE = '$credit_balance', CRD_PIN = '$credit_pin'";

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
        $sql = "DELETE FROM CREDIT WHERE ACC_ID = '$account_id'";
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