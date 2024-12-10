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

    $query = "SELECT * FROM TRANSACTION WHERE ACC_ID = '$uname'";
    $result = $mysqli->query($query);

    $mysqli -> close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
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

        .button {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #3f413a;
            color: #e2dfd9;
            font-size: 14px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #444942;
        }

        .transaction-history {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 5px 5px 10px gray;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Transaction History</h2>

        <div class="transaction-history">
            <table>

                    <tr>
                        <th>Transaction Number</th>
                        <th>Transaction Type</th>
                        <th>Transaction Amount</th>
                        <th>Employee ID</th>
                    </tr>

                <?php while ($row = $row = $result->fetch_assoc()){ 
                ?>
                        <tr>
                            <td><?php echo $row['TRANSACT_NUM'] ?></td>
                            <td><?php echo $row['TRANSACT_TYPE'] ?></td>
                            <td><?php echo $row['TRANSACT_AMOUNT'] ?></td>
                            <td><?php echo $row['EMP_ID'] ?></td>
                        </tr>
                <?php
                    }
                    ?>
            </table>
        </div>

        <button class="button" onclick="window.history.back()">Back</button>
    </div>
</body>
</html>
