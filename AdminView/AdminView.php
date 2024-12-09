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

    $query1 = 'SELECT * FROM BRANCH';
    $result1 = $mysqli -> query($query1);

    $query2 = 'SELECT * FROM EMPLOYEE';
    $result2 = $mysqli -> query($query2);

    $query3 = 'SELECT * FROM TRANSACTION';
    $result3 = $mysqli -> query($query3);

    $query4 = 'SELECT * FROM CLIENT';
    $result4 = $mysqli -> query($query4);
    
    $query5 = 'SELECT * FROM RECORDS';
    $result5 = $mysqli -> query($query5);

    $query6 = 'SELECT * FROM ACCOUNT';
    $result6 = $mysqli -> query($query6);
    
    $query7 = 'SELECT * FROM CREDIT';
    $result7 = $mysqli -> query($query7);

    $query8 = 'SELECT * FROM SAVINGS';
    $result8 = $mysqli -> query($query8);

    $mysqli -> close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    
    <style type='text/css'>
        html
        {
            background-color: #e2dfd9;
        }
        table, th, td {
            border: 1px solid;
            margin-left: auto;
            margin-right: auto;
        }

        body {
            font-family: "Lato", sans-serif;
        }

        h2 {
            color: #333;
            text-decoration: underline;
        }

        form {
            margin-top: 15px;
        }

        input[type="submit"] {
            margin: 5px;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[type="text"] {
            margin: 5px;
            padding: 8px;
            width: 200px;
        }

        .container
        {
            display: flex;
            flex-direction: column;
            margin: auto;

        }

        .subcontainer
        {
            text-align: center;
            background-color: white;
            border-radius: 10px;
            margin-top: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            margin-left: 25%;
            margin-right: 25%;
        }

        .formcontainer
        {
            display: grid;
            grid-template-columns: auto auto; 
            gap: 10px 20px; 
            align-items: center; 
            max-width: 400px; 
            margin: 0 auto;
        }

        label
        {
            text-align: right; 
            padding-right: 10px;
        }

        .inputbox {
            width: 100%; 
            padding: 5px;
            box-sizing: border-box; 
        }

    </style>
</head>
<body>
    <h1 style="text-align:center;">Admin View</h1>
    <div class="container">
        <!-- Branch Table -->
        <div class="subcontainer">
            <h2>Branch Table</h2>
            <table>
                <tr>
                    <th>Branch Code</th>
                    <th>Branch Location</th>
                </tr>
                <?php
                    while($row1 = $result1 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row1['BRANCH_CODE'] ?></td>
                        <td><?php echo $row1['BRANCH_LOCATION'] ?></td>
                    </tr>
                    <?php
                        }
                ?>
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action1.php" method="POST" >
                <div class="formcontainer">
                    <label for="branch_code">Branch Code</label>
                    <input type="text" name="branch_code" class="inputbox" required>
                    <label for="branch_location">Branch Location</label>
                    <input type="text" name="branch_location" class="inputbox" required>
                </div>

                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>

        <!-- Employee Table -->
        <div class="subcontainer">
            <h2>Employee Table</h2>
            <table>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Employee Phone</th>
                    <th>Employee Pin</th>
                    <th>Branch Code</th>
                </tr>
                <?php
                        while($row2 = $result2 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row2['EMP_ID'] ?></td>
                        <td><?php echo $row2['EMP_NAME'] ?></td>
                        <td><?php echo $row2['EMP_PHONE'] ?></td>
                        <td><?php echo $row2['EMP_PIN'] ?></td>
                        <td><?php echo $row2['BRANCH_CODE'] ?></td>
                    </tr>
                    <?php
                        }
                ?>
                
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action2.php" method="POST">
                <div class="formcontainer">
                    <label for="employee_id">Employee ID</label>
                    <input type="text" name="employee_id" class="inputbox" required>
                    <label for="employee_name">Employee Name</label>
                    <input type="text" name="employee_name" class="inputbox" required>
                    <label for="employee_phone">Employee Phone</label>
                    <input type="text" name="employee_phone" class="inputbox" required>
                    <label for="employee_pin">Employee Pin</label>
                    <input type="text" name="employee_pin" class="inputbox" required>
                    <label for="branch_code">Branch Code</label>
                    <input type="text" name="branch_code" class="inputbox" required>
                </div>
                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            
            </form>
        </div>

        <!-- Transaction Table -->
        <div class="subcontainer">
            <h2>Transaction Table</h2>
            <table>
                <tr>
                    <th>Transaction Number</th>
                    <th>Transaction Type</th>
                    <th>Transaction Amount</th>
                    <th>Employee ID</th>
                    <th>Client ID</th>
                    <th>Account ID</th>
                </tr>
                <?php
                        while($row3 = $result3 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row3['TRANSACT_NUM'] ?></td>
                        <td><?php echo $row3['TRANSACT_TYPE'] ?></td>
                        <td><?php echo $row3['TRANSACT_AMOUNT'] ?></td>
                        <td><?php echo $row3['EMP_ID'] ?></td>
                        <td><?php echo $row3['CL_ID'] ?></td>
                        <td><?php echo $row3['ACC_ID'] ?></td>
                    </tr>
                    <?php
                        }
                ?>
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action3.php" method="POST">
                <div class="formcontainer">
                    <label for="transaction_number">Transaction Number</label>
                    <input type="text" name="transaction_number" class="inputbox" required> 
                    <label for="transaction_type">Transaction Type</label>
                    <input type="text" name="transaction_type" class="inputbox" required> 
                    <label for="transaction_amount">Transaction Amount</label>
                    <input type="text" name="transaction_amount" class="inputbox" required> 
                    <label for="employee_id">Employee ID</label>
                    <input type="text" name="employee_id" class="inputbox" required> 
                    <label for="client_id">Client ID</label>
                    <input type="text" name="client_id" class="inputbox" required> 
                    <label for="account_id">Account ID</label>
                    <input type="text" name="account_id" class="inputbox" required> 
                </div>
                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>

        <!-- Client Table -->
        <div class="subcontainer">
            <h2>Client Table</h2>
            <table>
                <tr>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Client Address</th>
                    <th>Client Phone</th>
                    <th>Client Email</th>
                    <th>Client Pin</th>
                </tr>
                <?php
                        while($row4 = $result4 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row4['CL_ID'] ?></td>
                        <td><?php echo $row4['CL_NAME'] ?></td>
                        <td><?php echo $row4['CL_ADDRESS'] ?></td>
                        <td><?php echo $row4['CL_PHONE'] ?></td>
                        <td><?php echo $row4['CL_EMAIL'] ?></td>
                        <td><?php echo $row4['CL_PIN'] ?></td>
                    </tr>
                    <?php
                        }
                ?>
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action4.php" method="POST">
                <div class="formcontainer">
                    <label for="client_id">Client ID</label>
                    <input type="text" name="client_id" class="inputbox" required>
                    <label for="client_name">Client Name</label>
                    <input type="text" name="client_name" class="inputbox" required>
                    <label for="client_address">Client Address</label>
                    <input type="text" name="client_address" class="inputbox" required> 
                    <label for="client_phone">Client Phone</label>
                    <input type="text" name="client_phone" class="inputbox" required> 
                    <label for="client_email">Client Email</label>
                    <input type="text" name="client_email" class="inputbox" required> 
                    <label for="client_email">Client Pin</label>
                    <input type="text" name="client_pin" class="inputbox" required> 
                </div>
                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>

        <!-- Records Table -->
        <div class="subcontainer">
            <h2>Records Table</h2>
            <table>
                <tr>
                    <th>Client ID</th>
                    <th>Account ID</th>
                </tr>
                <?php
                        while($row5 = $result5 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row5['CL_ID'] ?></td>
                        <td><?php echo $row5['ACC_ID'] ?></td>
                    </tr>
                    <?php
                        }
                ?>
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action5.php" method="POST">
                <div class="formcontainer">
                    <label for="client_id">Client ID</label>
                    <input type="text" name="client_id" class="inputbox" required> 
                    <label for="account_id">Account ID</label>
                    <input type="text" name="account_id" class="inputbox" required> 
                </div>
                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>

        <!-- Account Table -->
        <div class="subcontainer">
            <h2>Account Table</h2>
            <table>
                <tr>
                    <th>Account ID</th>
                    <th>Account Status</th>
                    <th>Account Type</th>
                </tr>
                <?php
                        while($row6 = $result6 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row6['ACC_ID'] ?></td>
                        <td><?php echo $row6['ACC_STATUS'] ?></td>
                        <td><?php echo $row6['ACC_TYPE'] ?></td>
                    </tr>
                    <?php
                        }
                ?>
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action6.php" method="POST">

                <div class="formcontainer">
                    <label for="account_id">Account ID</label>
                    <input type="text" name="account_id" class="inputbox" required>

                    <label for="account_status">Account Status</label>
                    <input type="text" name="account_status" class="inputbox" required>

                    <label for="account_type">Savings Account</label>
                    <input type="radio" name="account_type" value="savings" class="inputbox" required>

                    <label for="account_type">Credit Account</label>
                    <input type="radio" name="account_type" value="credit" valclass="inputbox" required>
                </div>

                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>

        <!-- Credit Table -->
        <div class="subcontainer">
            <h2>Credit Table</h2>
            <table>
                <tr>
                    <th>Account ID</th>
                    <th>Credit Limit</th>
                    <th>Credit Score</th>
                    <th>Credit Balance</th>
                    <th>Credit Pin</th>
                </tr>
                <?php
                        while($row7 = $result7 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row7['ACC_ID'] ?></td>
                        <td><?php echo $row7['CRD_LIMIT'] ?></td>
                        <td><?php echo $row7['CRD_SCR'] ?></td>
                        <td><?php echo $row7['CRD_BALANCE'] ?></td>
                        <td><?php echo $row7['CRD_PIN'] ?></td>
                    </tr>
                    <?php
                        }
                ?>
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action7.php" method="POST">
                <div class="formcontainer">
                    <label for="account_id">Account ID</label>
                    <input type="text" name="account_id" class="inputbox" required> 
                    <label for="credit_limit">Credit Limit</label>
                    <input type="text" name="credit_limit" class="inputbox" required> 
                    <label for="credit_score">Credit Score</label>
                    <input type="text" name="credit_score" class="inputbox" required> 
                    <label for="credit_balance">Credit Balance</label>
                    <input type="text" name="credit_balance" class="inputbox" required> 
                    <label for="credit_pin">Credit Pin</label>
                    <input type="text" name="credit_pin" class="inputbox" required> 
                </div>
                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>

        <!-- Savings Table -->
        <div class="subcontainer">
            <h2>Savings Table</h2>
            <table>
                <tr>
                    <th>Account ID</th>
                    <th>Savings Balance</th>
                    <th>Savings Rate</th>
                    <th>Savings Pin</th>
                </tr>
                <?php
                        while($row8 = $result8 -> fetch_assoc())
                        {
                    ?>
                    <tr>
                        <td><?php echo $row8['ACC_ID'] ?></td>
                        <td><?php echo $row8['SAV_BAL'] ?></td>
                    <?php
                        }
                ?>
                <!-- Data rows dynamically inserted here -->
            </table>
            <form action="action8.php" method="POST">
                <div class="formcontainer">
                    <label for="account_id">Account ID</label>
                    <input type="text" name="account_id" class="inputbox" required>
                    <label for="savings_balance">Savings Balance</label>
                    <input type="text" name="savings_balance" class="inputbox" required>
                    <label for="savings_rate">Savings Rate</label>
                    <input type="text" name="savings_rate" class="inputbox" required>
                    <label for="savings_pin">Savings Pin</label>
                    <input type="text" name="savings_pin" class="inputbox" required>
                </div>
                <input type="submit" name="insert" value="Insert">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>
    </div>
    <form action="../Login.html" method="POST" style="text-align: center;">
        <input type="submit" value="Back to Login">
    </form>
</body>
</html>