<?php
$user = "root";
$password = "1234";
$database = "BANK_SYSTEM";
$servername = "localhost:3310";

// Establish database connection
$mysqli = new mysqli($servername, $user, $password, $database);
if ($mysqli->connect_error) {
    die('Connect Error(' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
}

// Generate new CL_ID
$cur_code = '0001';
$sql = "SELECT IFNULL((SELECT CL_ID FROM CLIENT ORDER BY CL_ID DESC LIMIT 1), 'Has') AS col1";
$query = $mysqli->query($sql);
$result = $query->fetch_assoc();

if ($result['col1'] != 'Has') {
    $lastquery = $mysqli->query("SELECT CL_ID FROM CLIENT ORDER BY CL_ID DESC LIMIT 1");
    $lastresult = $lastquery->fetch_assoc();
    $cur_code = str_pad($lastresult['CL_ID'] + 1, 4, "0", STR_PAD_LEFT);
}

// Generate new ACC_ID
$acc_code = '000001';
$sql2 = "SELECT IFNULL((SELECT ACC_ID FROM ACCOUNT ORDER BY ACC_ID DESC LIMIT 1), 'Has') AS col1";
$query2 = $mysqli->query($sql2);
$result2 = $query2->fetch_assoc();

if ($result2['col1'] != 'Has') {
    $lastquery1 = $mysqli->query("SELECT ACC_ID FROM ACCOUNT ORDER BY ACC_ID DESC LIMIT 1");
    $lastresult1 = $lastquery1->fetch_assoc();
    $acc_code = str_pad($lastresult1['ACC_ID'] + 1, 6, "0", STR_PAD_LEFT);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $cl_pin = $_POST['cl-pin'];
    $confirm_cl_pin = $_POST['confirm-cl-pin'];
    $contact = $_POST['number'];
    $acc_type = $_POST['accountType'];

    // Error Handling
    if ($cl_pin !== $confirm_cl_pin) {
        header("Location: error_pin_mismatch.html");
        exit();
    }
    if ($password !== $confirm_password) {
        header("Location: error_pass_mismatch.html");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: error_email_format.html");
        exit();
    }
    $domain = substr(strrchr($email, "@"), 1);
    if (!checkdnsrr($domain, "MX")) {
        header("Location: error_email_domain.html");
        exit();
    }
    $regex1 = '/^\+63\d{10}$/';
    if (!preg_match($regex1, $contact)) {
        header("Location: error_phone_num.html");
        exit();
    }

    // SQL Queries
    $client_sql = "INSERT INTO CLIENT (CL_ID, CL_NAME, CL_ADDRESS, CL_PHONE, CL_EMAIL, CL_PIN) 
                   VALUES ('$cur_code', '$username', 'Default Address', '$contact', '$email', '$cl_pin')";

    $account_sql = "INSERT INTO ACCOUNT (ACC_ID, ACC_STATUS, ACC_TYPE) 
                    VALUES ('$acc_code', 'Active', '$acc_type')";

    if ($acc_type == 'savings') {
        $account_details_sql = "INSERT INTO SAVINGS (ACC_ID, SAV_BAL, SAV_RATE, SAV_PIN) 
                                VALUES ('$acc_code', 0.00, 0.05, '$cl_pin')";
    } elseif ($acc_type == 'credit') {
        $account_details_sql = "INSERT INTO CREDIT (ACC_ID, CRD_LIMIT, CRD_SCR, CRD_BALANCE, CRD_PIN) 
                                VALUES ('$acc_code', 10000.00, 700, 0.00, '$cl_pin')";
    }

    $records_sql = "INSERT INTO RECORDS (CL_ID, ACC_ID) 
                    VALUES ('$cur_code', '$acc_code')";

    // Execute SQL Queries
    if ($mysqli->query($client_sql) === TRUE &&
        $mysqli->query($account_sql) === TRUE &&
        $mysqli->query($account_details_sql) === TRUE &&
        $mysqli->query($records_sql) === TRUE) {
        header("Location: success.html");
        exit();
    } else {
        echo "Error: " . $mysqli->error;
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
  <div class="container">
    <h1>Bank Sign-Up Form</h1>
    <form action="signup.php" method="post">

      <label2> Client Code: <?php echo $cur_code?> <br>
      <label2> Account Code: <?php echo $acc_code?> <br>
      <br>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Create Username" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Create Password" required>

      <label for="confirm-password">Confirm Password</label>
      <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>

      <label for="cl-pin">Client PIN (6 digits)</label>
      <input type="password" id="cl-pin" name="cl-pin" placeholder="Enter 6-digit PIN" pattern="\d{6}" required>

      <label for="confirm-cl-pin">Confirm Client PIN</label>
      <input type="password" id="confirm-cl-pin" name="confirm-cl-pin" placeholder="Confirm 6-digit PIN" pattern="\d{6}" required>

      <label for="number">Contact No. (+63)</label>
      <input type="text" id="number" name="number" placeholder="Enter your contact number" required>

      <div class="radio-container">
        <label><input type="radio" name="accountType" value="savings" required> Savings</label>
        <label><input type="radio" name="accountType" value="credit"> Credit</label>
      </div>

      <div class="options">
        <button type="submit" class="submit-btn">Sign Up</button>
        <button class="back-btn" type="button" onclick="window.location.href='../Login.html'">Back to Login</button>
      </div>
    </form>
  </div>
</body>
</html>

