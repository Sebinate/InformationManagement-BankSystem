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
        header('Location:http://localhost/Final/AdminView/error.html');
        exit(); 
    }
    
    $employee_name = $_REQUEST['employee_name'];

    if(trim($employee_name) === '')
    {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    $employee_phone = $_REQUEST['employee_phone'];
    $regex1 = '/^\+63\d{10}$/';
    if(preg_match($regex1, $employee_phone) == 0)
    {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit(); 
    }

    $employee_pin = $_REQUEST['employee_pin'];
    if (!ctype_digit($employee_pin) || strlen($employee_pin) !== 6) 
    {
    header('Location:http://localhost/Final/AdminView/error.html');
    exit();
    }

    $branch_code_input = $_REQUEST['branch_code'];
    if($branch_code_input < 10)
    {
        $branch_code = "000$branch_code_input";
    }

    elseif($branch_code_input >= 10 & $branch_code_input < 100)
    {
        $branch_code = "00$branch_code_input";
    }

    elseif($branch_code_input >= 100 & $branch_code_input < 1000)
    {
        $branch_code = "0$branch_code_input";
    }

    elseif($branch_code_input >= 1000 & $branch_code_input < 10000)
    {
        $branch_code = $branch_code_input;
    }

    else
    {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit(); 
    }

    $sql = "SELECT IFNULL((SELECT BRANCH_CODE FROM BRANCH WHERE BRANCH_CODE = '$branch_code'), 'error') AS col1";
    $query = $mysqli -> query($sql);
    $result = $query -> fetch_assoc();

    if($result['col1'] == 'error')
    {
        header('Location:http://localhost/Final/AdminView/error.html');
        exit();
    }

    if(isset($_POST['insert']))
    {
        $sqlcheck = "SELECT COUNT(1) AS checker FROM EMPLOYEE WHERE EMP_ID = '$employee_id'";
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/Final/AdminView/error.html');
            exit();
        }
        
        $sql =  "INSERT INTO EMPLOYEE (EMP_ID, EMP_NAME, EMP_PHONE, EMP_PIN, BRANCH_CODE) VALUES ('$employee_id', '$employee_name', '$employee_phone', '$employee_pin', '$branch_code')";
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
        $origin = "SELECT * FROM EMPLOYEE WHERE EMP_ID = '$employee_id'";
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if($employee_name != '' & $employee_name != $row['EMP_NAME'])
        {
            $employee_name = $employee_name;
        }

        else
        {
            $employee_name = $row['EMP_NAME'];
        }

        if($employee_phone != '' & $employee_phone != $row['EMP_PHONE'])
        {
            $employee_phone = $employee_phone;
        }

        else
        {
            $employee_phone = $row['EMP_PHONE'];
        }

        if($employee_pin != '' & $employee_pin != $row['EMP_PIN'])
        {
            $employee_pin = $employee_pin;
        }

        else
        {
            $employee_pin = $row['EMP_PIN'];
        }
    
        if($branch_code != '' & $branch_code != $row['BRANCH_CODE'])
        {
            $sql = "SELECT IFNULL((SELECT BRANCH_CODE FROM BRANCH WHERE BRANCH_CODE = '$branch_code'), 'error') AS col1";
            $query = $mysqli -> query($sql);
            $result = $query -> fetch_assoc();
        
            if($result['col1'] == 'error')
            {
                header('Location:http://localhost/Final/AdminView/error.html');
                exit();
            }
        
            $branch_code = $branch_code;
        }

        else{
            $branch_code = $row['BRANCH_CODE'];
        }

       

        $sqlr = "UPDATE EMPLOYEE SET EMP_ID = '$employee_id', EMP_NAME = '$employee_name', EMP_PHONE = '$employee_phone', EMP_PIN = '$employee_pin', BRANCH_CODE = '$branch_code' WHERE EMP_ID = '$employee_id'";

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
        $sql = "DELETE FROM EMPLOYEE WHERE EMP_ID = '$employee_id'";
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
