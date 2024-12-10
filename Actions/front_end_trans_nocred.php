<?php 
    $user = "root";
    $password = "1234";
    $database = "BANK_SYSTEM";
    $servername = "localhost:3310";
    
    $mysqli = new mysqli($servername, $user, $password, $database); 
    
    
    if($mysqli -> connect_error)
    {
        die('Connect Error('.$mysqli->connect_errno.')'.$mysqli->connect_error);
    }
    session_start();


    $uname = $_SESSION['uname'];
    $origin = "SELECT * FROM SAVINGS WHERE ACC_ID = '$uname'";
    $originquery = $mysqli -> query($origin);
    

    $mysqli -> close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transactions</title>
    <style>
        html {
            display: grid;
            min-height: 100%;
            background-color: #e2dfd9;
        }

        body {
            font-family: "Lato", sans-serif;
            margin: auto;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            padding: 30px;
            height: auto;
            border-radius: 25px;
            background-color: white;
            box-shadow: 10px 10px 5px gray;
        }

        .upperdiv {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .textlabel {
            padding-bottom: 5px;
            font-size: 16pt;
        }

        .inputbox {
            font-size: 12pt;
            margin-bottom: 13px;
            border-radius: 5px;
            border-style: solid;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 10px;
        }

        .lowerdiv {
            display: grid;
            gap: 5px;
            padding-top: 12px;
            grid-template-columns: auto auto;
            grid-auto-flow: row;
        }

        .action1 {
            display: grid;
            grid-template-columns: auto auto;
            grid-auto-flow: row;
            gap: 10px;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .button1 {
            background-color: #3f413a;
            color: #e2dfd9;
            font-size: 10pt;
            border-style: none;
            border-radius: 5px;
            padding: 6px;
            width: 100%;
        }

        .button2 {
            background-color: #66695e;
            color: white;
            font-size: 10pt;
            border-style: none;
            padding: 6px;
            border-radius: 5px;
            width: 100%;
        }

        .button1:hover {
            background-color: #444942;
        }

        .button2:hover {
            background-color: #545a51;
        }
        
        .button1, .button2 {
            margin-top: -15px; 
        }

        .logout-btn {
            background-color: #dc3545;
        }

        .logout-btn:hover {
            background-color: #b52a37;
        }
        
        .logout-btn {
            margin-top: 8px; 
        }
        
        .history-btn {
            background-color: #6c757d;
        }

        .history-btn:hover {
            background-color: #545b62;
        }

        .history-btn {
            margin-top: 8px; 
        }

        .transaction-history {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 5px 5px 10px gray;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #3f413a;
            color: #e2dfd9;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="upperdiv">
            <h2>Bank Transactions</h2>

            <form action="transaction_handler.php" method="POST" class="form">
                <div class="textlabel">
                    <label for="amount">Enter Amount:</label>
                </div>
                <input type="number" id="amount" name="amount" placeholder="Enter amount" required class="inputbox">
                <div class="lowerdiv">
                    <button type="submit" name="action" value="deposit" class="button1">Deposit</button>
                    <button type="submit" name="action" value="withdraw" class="button2">Withdraw</button>
                </div>
            </form>
        </div>


        <div class="action1">
            <button class="history-btn" onclick="window.location.href='transaction_history.php'">View Transaction History</button>
            <button class="logout-btn" onclick="window.location.href='../Login.html'">Log Out</button>
        </div>

        
        <div class="transaction-history">
            <h2>Customer Information</h2>
            <table>
                <tr>
                    <th>Savings Rate</th>
                    <th>Balance</th>
                </tr>
                <?php while($originresult = $originquery -> fetch_assoc())
                        {
                ?>
                    <tr>
                        <td><?php echo $originresult['SAV_RATE']?></td>
                        <td><?php echo $originresult['SAV_BAL']?></td>
                    </tr>

                <?php
                        }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
