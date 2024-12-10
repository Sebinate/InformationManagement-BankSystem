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
    
    $account_status = $_REQUEST['account_status'];
    if (trim($account_status) === '' || strlen($account_status) > 15) {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    $account_type = $_REQUEST['account_type'];
    if($account_type == 'savings' | $account_type == 'credit')
    {
        $acount_type = $account_type;
    }
    
    else
    {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    if(isset($_POST['insert']))
    {
        $sqlcheck = "SELECT COUNT(1) AS checker FROM ACCOUNT WHERE ACC_ID = '$account_id'";
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/Final/AdminView/error.html');
            exit();
        }
        
        $sql =  "INSERT INTO ACCOUNT (ACC_ID, ACC_STATUS, ACC_TYPE) VALUES ('$account_id', '$account_status', '$account_type')";
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
        $origin = "SELECT * FROM ACCOUNT WHERE ACC_ID = '$account_id'";
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if($account_status != '' & $account_status != $row['ACC_STATUS'])
        {
            $account_status = $account_status;
        }

        else{
            $account_status = $row['ACC_STATUS'];
        }

        if($account_type != '' & $account_type != $row['ACC_TYPE'])
        {
            $account_type = $account_type;
        }

        else{
            $account_type = $row['ACC_TYPE'];
        }

        $sqlr = "UPDATE ACCOUNT SET ACC_ID = '$account_id', ACC_STATUS = '$account_status', ACC_TYPE = '$account_type'";

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
        $sql = "DELETE FROM ACCOUNT WHERE ACC_ID = '$account_id'";
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
        <form action="AdminView.php" method="GET">
            <input type="submit" name="back" value = "Back">
        </form>
    </body>

</html>