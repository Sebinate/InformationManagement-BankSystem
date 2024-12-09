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
        header('Location:http://localhost/AdminView/error.html');
        exit(); 
    }
    
    $branch_location = $_REQUEST['branch_location'];

    if(trim($branch_location) === '')
    {
        header('Location:http://localhost/AdminView/error.html');
        exit();
    }

    if(isset($_POST['insert']))
    {
        $sqlcheck = "SELECT COUNT(1) AS checker FROM BRANCH WHERE BRANCH_CODE = '$branch_code'";
        $checker = $mysqli -> query($sqlcheck);
        $rowchecker = $checker -> fetch_assoc();

        if($rowchecker['checker'] == 1)
        {
            header('Location:http://localhost/AdminView/error.html');
            exit();
        }
        
        $sql =  "INSERT INTO BRANCH (BRANCH_CODE, BRANCH_LOCATION) VALUES ('$branch_code', '$branch_location')";
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
        $origin = "SELECT * FROM BRANCH WHERE BRANCH_CODE = '$branch_code'";
        $result = $mysqli -> query($origin);
        $row = $result -> fetch_assoc();

        if($branch_location != '' & $branch_location != $row['BRANCH_LOCATION'])
        {
            $branch_location = $branch_location;
        }

        else{
            $branch_location = $row['BRANCH_LOCATION'];
        }

        $sqlr = "UPDATE BRANCH SET BRANCH_LOCATION = '$branch_location' WHERE BRANCH_CODE = '$branch_code'";

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
        $sql = "DELETE FROM BRANCH WHERE BRANCH_CODE = '$branch_code'";
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
