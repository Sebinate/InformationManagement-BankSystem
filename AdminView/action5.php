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

    $client_id = $_REQUEST['client_code'];
    if($client_id < 10)
    {
        $client_id = "000$client_id";
    }

    elseif($client_id >= 10 & $client_id < 100)
    {
        $client_id = "00$client_id";
    }

    elseif($cient_id >= 100 & $client_id < 1000)
    {
        $client_id = "0$client_id";
    }

    elseif($client_id >= 1000 & $client_id < 10000)
    {
        $client_id = (string)$client_id;
    }

    else
    {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit(); 
    }
    
    $sql = "SELECT IFNULL((SELECT CL_ID FROM CLIENT WHERE CL_ID = '$client_id'), 'error') AS col1";
    $query = $mysqli -> query($sql);
    $result = $query -> fetch_assoc();

    if($result['col1'] == 'error')
    {
        header('Location:http://localhost/Final/AdminView/error.html');
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
        header('Location:http://localhost/Final/AdminView/error.html');
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
        $sqlcheck = "SELECT COUNT(1) AS checker FROM RECORDS WHERE CL_ID = '$client_id' and ACC_ID = '$account_id'"; #eto seb
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/Final/AdminView/error.html');
            exit();
        }
        
        $sql =  "INSERT INTO RECORDS (CL_ID, ACC_ID) VALUES ('$CL_ID', '$ACC_ID')";
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
        $origin = "SELECT * FROM RECORDS WHERE CL_ID = '$client_id'";
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if($account_id != '' & $account_id != $row['ACC_ID'])
        {
            $account_id = $account_id;
        }

        else{
            $account_id = $row['ACC_ID'];
        }

        $sqlr = "UPDATE RECORDS SET CL_ID = '$cl_id', ACC_ID = '$account_id'";

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
        $sql = "DELETE FROM RECORDS WHERE CL_ID = '$clinet_id'";
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
