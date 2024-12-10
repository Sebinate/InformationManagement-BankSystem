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
    
    $savings_balance = $_REQUEST['savings_balance'];
    if (!is_float($savings_balance) || $savings_balance <= 0|| $savings_balance >= 100000000) {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    $savings_rate = $_REQUEST['savings_rate'];
    if (!is_float($savings_rate) || $savings_rate < 0.00 || $savings_rate > 9.99 || strlen(substr(strrchr($savings_rate, '.'), 1)) > 2) {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    $savings_pin = $_REQUEST['savings_pin'];
    if (!ctype_digit($savings_pin) || strlen($savings_pin) !== 6) 
    {
    header('Location:http://localhost/Final/AdminView/error.html');
    exit();
    }

    if(isset($_POST['insert']))
    {
        $sqlcheck = "SELECT COUNT(1) AS checker FROM SAVINGS WHERE ACC_ID = '$account_id'"; #same shit action 7 pacheck
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/FinalAdminView/error.html');
            exit();
        }
        
        $sql =  "INSERT INTO SAVINGS (ACC_ID, SAV_BAL, SAV_RATE, SAV_PIN) VALUES ('$account_id', $savings_balance, $savings_rate, '$savings_pin')";
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
        $origin = "SELECT * FROM ACCOUNT WHERE ACC_ID = '$account_id'"; # to rin
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if($avings_balance != '' & $avings_balance != $row['SAV_BAL'])
        {
            $avings_balance = $avings_balance;
        }

        else{
            $avings_balance = $row['SAV_BAL'];
        }

        if($savings_rate != '' & $savings_rate != $row['SAV_RATE'])
        {
            $savings_rate = $savings_rate;
        }

        else{
            $savings_rate = $row['SAV_RATE'];
        }

        if($savings_pin != '' & $savings_pin != $row['SAV_PIN'])
        {
            $savings_pin = $savings_pin;
        }

        else{
            $savings_pin = $row['SAV_PIN'];
        }

        $sqlr = "UPDATE ACCOUNT SET ACC_ID = '$account_id', SAV_BAL = '$savings_balance', SAV_RATE = '$savings_rate', SAV_PIN = '$savings_pin'";

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
        $sql = "DELETE FROM SAVINGS WHERE ACC_ID = '$account_id'";
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