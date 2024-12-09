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

    $client_id = $_REQUEST['client_id'];
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

    $client_name = $_REQUEST['client_name'];
    if(strlen($client_name) > 50)
    {
        header('Location:http://localhost/banksystem/AdminView/error.html');
        exit(); 
    }

    $client_address = $_REQUEST['client_address'];
    if(strlen($client_address) > 50)
    {
        header('Location:http://localhost/banksystem/AdminView/error.html');
        exit(); 
    }

    $client_phone = $_REQUEST['client_phone'];
    $regex1 = '/^\+63\d{10}$/';
    if(preg_match($regex1, $client_phone) == 0)
    {
        header('Location:http://localhost/banksystem/AdminView/error.html');
        exit(); 
    }

    $client_email = $_REQUEST['client_email'];
    $regex2 = '/^[a-zA-Z0-9.*]+@[a-zA-Z]{3,}+\.[a-zA-Z]{3,}$/';
    if(preg_match($regex2, $client_email) == 0)
    {
        header('Location:http://localhost/banksystem/AdminView/error.html');
        exit(); 
    }

    $client_pin = $_REQUEST['client_pin'];
    if(strlen($client_pin) != 6){
        header('Location:http://localhost/banksystem/AdminView/error.html');
        exit(); 
    }

    if(isset($_POST['insert']))
    {
        $sqlcheck = "SELECT COUNT(1) AS checker FROM CLIENT WHERE CL_ID = '$client_id'";
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/banksystem/AdminView/error.html');
            exit();
        }

        $sql =  "INSERT INTO CLIENT (CL_ID, CL_NAME, CL_ADDRESS, CL_PHONE, CL_EMAIL, CL_PIN) VALUES ('$client_id', '$client_name', '$client_address', '$client_phone', '$client_email', '$client_pin')";
    
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
        $origin = "SELECT * FROM BRANCH WHERE BRANCH_CODE = '$client_id'";
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if(trim($client_name == '') | $client_name == $row['CL_NAME'])
        {
            $client_name = $row['CL_NAME'];
        }

        if(trim($client_address == '') | $client_address == $row['CL_ADDRESS'])
        {
            $client_address = $row['CL_ADDRESS'];
        }
        
        if(trim($client_phone) == '' | $client_phone == $row['CL_PHONE'])
        {
            $client_phone = $row['CL_PHONE'];
        }

        if(trim($client_email) | $client_email == $row['CL_EMAIL'])
        {
            $client_email = $row['CL_EMAIL'];
        }

        $sqlr = "UPDATE CLIENT SET CL_NAME = '$client_name', CL_ADDRESS = '$client_address', CL_PHONE = '$$client_phone', CL_EMAIL = '$client_email' WHERE CL_ID = '$client_id'";

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
        $sql = "DELETE FROM CLIENT WHERE CL_ID = '$client_id'";
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