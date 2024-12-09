<?php
$user = "root";
$password = "1234";
$database = "BANK_SYSTEM";
$servername = "localhost:3306";
$mysqli = new mysqli($servername, $user, $password, $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
include 'bridge.php';
$origin = "SELECT * FROM CREDIT WHERE ACC_ID = '$uname'";
$originquery = $mysqli->query($origin);
$resultquery = $originquery->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    // Assuming the user ID is stored in the session
    $userId = $origin;

    // SQL query to delete the account
    $sql = "DELETE FROM CREDIT WHERE ACC_ID = '$uname'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Account successfully deleted
        echo "<script>
            alert('Account deleted successfully.');
            window.location.href = 'transaction.php'; // Redirect to a goodbye page
        </script>";
    } else {
        // Error deleting the account
        echo "<script>
            alert('Error deleting account. Please try again later.');
            window.history.back();
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Account deletion canceled.');
        window.history.back();
    </script>";
}

$conn->close();

?>