<?php
$user = "root";
$password = "1234";
$database = "BANK_SYSTEM";
$servername = "localhost:3310";
$mysqli = new mysqli($servername, $user, $password, $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
session_start();
$accid = $_SESSION['uname'];
$checker = $_REQUEST['confirm'];

if($checker == 'yes')
{
    $sql = "DELETE FROM ACCOUNT WHERE ACC_ID = '$accid'";
    if(mysqli_query($mysqli, $sql))
    {
        echo "Data Deleted in Database successfully";
    }
    else
    {
        echo mysqli_error($mysqli);
    }
}

else
{
    header('Location:https://localhost/Final/Actions/creditpage.php');
    exit();
}

$mysqli -> close();
?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <p \> Account Deleted Successfully
        <form action="../Login.html">
        <input type="submit" value="Back">
    </body>

</html>