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
    #checking existance of client
    session_start();
    $_SESSION['uname'] = $_REQUEST['uname'];
    $_SESSION['psw'] = $_REQUEST['psw'];

    $uname = $_REQUEST['uname'];
    $psw = $_REQUEST['psw'];

    $action = $_POST['addacc'];

    $acc_code = '000001';
    $sql2 = "SELECT IFNULL((SELECT ACC_ID FROM ACCOUNT ORDER BY ACC_ID DESC LIMIT 1), 'Has') AS col1";
    $query2 = $mysqli->query($sql2);
    $result2 = $query2->fetch_assoc();

    if ($result2['col1'] != 'Has') {
        $lastcode1 = "SELECT ACC_ID FROM ACCOUNT ORDER BY ACC_ID DESC LIMIT 1";
        $lastquery1 = $mysqli->query($lastcode1);
        $lastresult1 = $lastquery1->fetch_assoc();

        $acc_code = $lastresult1['ACC_ID'] + 1;

        if ($acc_code < 10) 
          {
              $acc_code = "00000$acc_code";
          } 
          
          elseif ($acc_code >= 10 && $acc_code < 100) 
          {
              $acc_code = "0000$acc_code";
          } 
          
          elseif ($acc_code >= 100 && $acc_code < 1000) 
          {
              $acc_code = "000$acc_code";
          } 
          
          elseif ($acc_code >= 1000 && $acc_code < 10000) 
          {
              $acc_code = "00$acc_code";
          } 
          
          elseif ($acc_code >= 10000 && $acc_code < 100000) 
          {
              $acc_code = "0$acc_code";
          }

          else
          {
              $acc_code = (string)$acc_code;
          }

          $_SESSION['acc_code'] = $acc_code;
        }
    
    else
    {
      header('Location:https://localhost/Final/AddAccount/error.html');
      exit();
    }

    if($action == 'Update Client Details')
    {
      header("Location:https://localhost/Final/AddAccount/Update.php");
      exit();
    }
    
    $existance = "SELECT IFNULL((SELECT CL_ID FROM CLIENT WHERE CL_ID ='$uname'), 'DNE') AS col1";
    $existancequery = $mysqli -> query($existance);
    $resultexistance = $existancequery -> fetch_assoc();

    if($resultexistance['col1'] == 'DNE')
    {
      header('Location:https://localhost/Final/AddAccount/error.html');
      exit();
    }
    
    $passchecker = "SELECT * FROM CLIENT WHERE CL_ID = '$uname'";
    $passquery = $mysqli -> query($passchecker);
    $pass_result = $passquery -> fetch_assoc();

    if($pass_result['CL_PIN'] != $psw)
    {
        header('Location:https://localhost/Final/AddAccount/error.html');
        exit();
    }
    

    $sql = "SELECT COUNT(*) AS COUNTS FROM RECORDS WHERE CL_ID = '$uname'";
    $query = $mysqli -> query($sql);
    $result = $query -> fetch_assoc();

    if($result['COUNTS'] == 0)
    {
        header('Location:https://localhost/Final/AddAccount/error.html');
        exit();
    }

    elseif($result['COUNTS'] == 1)
    {   
        $sql1 = "SELECT ACC_TYPE FROM ACCOUNT WHERE ACC_ID = (SELECT ACC_ID FROM RECORDS WHERE CL_ID = '$uname')";
        $query1 = $mysqli -> query($sql1);
        $result1 = $query1 -> fetch_assoc();

        if($result1['ACC_TYPE'] == 'savings')
        {   
            $curr_acctype = 'credit';
        }

        else
        {
            $curr_acctype = 'savings';
        }

        $_SESSION['acctype'] = $curr_acctype;
    }
    
    else
    {
        header('Location:https://localhost/Final/AddAccount/error.html');
        exit();
    }

    $origin = "SELECT * FROM CLIENT WHERE CL_ID = '$uname'";
    $queryorigin = $mysqli -> query($origin);
    $row = $queryorigin -> fetch_assoc();

    $mysqli -> close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <style type="text/css">
      html {
        display: grid;
        min-height: 100%;
        background-color: #e2dfd9;
      }

      body {
        font-family: "Lato", sans-serif;
        margin: auto;
      }

      .container {
          display: flex;
          flex-direction: column; 
          padding: 30px;
          border-radius: 25px; 
          background-color: white;
          box-shadow: 10px 10px 5px gray;
          width: 400px;
          margin: auto;
      }

      h1 {
        text-align: center;
        font-size: 20pt;
        margin-bottom: 20px;
      }

      label {
        font-size: 16pt;
        padding-bottom: 5px;
      }

      .label2 {
        font-size: 10pt;
        padding-bottom: 5px;
      }

      input {
          font-size: 12pt;
          border-radius: 5px;
          border-style: solid;
          border-color: #ccc;
          padding: 8px;
          margin-bottom: 10px;
          width: 100%;
      }

      .submit-btn, .back-btn {
        font-size: 10pt;
        border-style: none;
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
      }

      .submit-btn {
        background-color: #3f413a;
        color: white;
      }

      .submit-btn:hover {
        background-color: #595c50;
      }

      .back-btn {
        background-color: #3f413a;
        color: white;
      }

      .back-btn:hover {
        background-color: #595c50;
      }

      .options {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
      }

      .radio-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
      }
      .radio-container label {
        display: flex;
        align-items: center;
        gap: 5px;
      }

    </style>
</head>
<body>
  <div class="container">
    <h1>Bank Add Account Form</h1>
    <form action="addacc.php" method="post">
    <div style="padding-bottom:10px;">
      <label2> Client Code: <?php echo $uname?> <br>
      <label2> Account Code: <?php echo $acc_code?> <br>
    </div>

    <div style="padding-bottom:10px;">
      <label for="username">Username: </label>
      <label><?php echo $row['CL_NAME']; ?></label><br>
    </div>
    <div style="padding-bottom:10px;">
      <label for="email">Email Address: </label>
      <label><?php echo $row['CL_EMAIL']?></label><br>
    </div>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Create Password" required>

      <label for="confirm-password">Confirm Password</label>
      <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>

      <label for="number">Contact No. (+63)</label>
      <label><?php echo $row['CL_PHONE']?></label>

      <div class="radio-container">
        <label> You are opening: <?php echo $curr_acctype ?> Account</label>
      </div>

      <div class="options">
        <button type="submit" class="submit-btn">Add Account</button>
        <button class="back-btn" type="button" onclick="window.location.href='addacc.html'">Back to Login</button>
      </div>
    </form>
  </div>
</body>
</html>

