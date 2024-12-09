<?php
    $user = "root";
    $password = "12345";
    $database = "BANK_SYSTEM";
    $servername = "localhost:3310";

    $mysqli = new mysqli($servername, $user, $password, $database); #TO access mysql database content

    #Connecting to the database
    if($mysqli -> connect_error)
    {
        die('Connect Error('.$mysqli->connect_errno.')'.$mysqli->connect_error);
    }
    include 'bridge.php';

    $origin = "SELECT * FROM CREDIT WHERE ACC_ID = '$uname'";
    $originquery = $mysqli -> query($origin);
    $resultquery = $originquery -> fetch_assoc();

    $mysqli -> close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Details</title>
    <link rel="stylesheet" href="creditcss.css">
</head>
<body>
    <div class="container">
        <form>
            <a class="back-btn" onclick="window.history.back()">Back</a>
            <a class="logout-btn" href="Login.html">Logout</a>
            <a class="delete-btn" href="delete account.html">Delete Account</a>
        </form>
        <h1>Credit Account Details</h1>
        <table>
            <thead>
                <tr>
                    <th>Credit Score</th>
                    <th>Credit Limit</th>
                    <th>Credit Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($resultquery = $originquery -> fetch_assoc())
                    {
                ?>
                <tr>
                    <td><?php echo $resultquery['CRD_SCR']?></td>
                    <td><?php echo $resultquery['CRD_LIMIT']?></td>
                    <td><?php echo $resultquery['CRD_BALANCE']?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <div class="payment-form">
            <form action="process.php" method="POST">
                <label for="payment-amount">Enter Amount to Pay:</label>
                <input type="number" id="payment-amount" name="payment_amount" min="0" step="0.01" required>
                <button type="submit">Pay Now</button>
            </form>
    </div>
</body>
</html>
