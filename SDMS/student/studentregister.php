<?php
$host = "localhost";
$port = "5433";
$dbname = "studentdb";
$user = "postgres";
$password = "vishal888";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Error: Unable to connect to the database.";
    exit;
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email)) {
    echo "Error: Email address is required.";
    exit;
}

$checkEmailQuery = "SELECT COUNT(*) FROM users WHERE email = $1";
$checkEmailStmt = pg_prepare($conn, "check_email", $checkEmailQuery);
$checkEmailResult = pg_execute($conn, "check_email", array($email));

if ($checkEmailResult && pg_fetch_result($checkEmailResult, 0, 0) > 0) {
    echo "Error: Email address already exists.";
    exit;
}

// Insert data into the database
$insertQuery = "INSERT INTO studentusers (username, email, password) VALUES ($1, $2, $3)";
$insertStmt = pg_prepare($conn, "insert_user", $insertQuery);
$insertResult = pg_execute($conn, "insert_user", array($username, $email, $password));

if ($insertResult) {
    header("Location: studentlogin.html");
    exit;
} else {
    echo "Error: Unable to register user.";
}

pg_close($conn); // Close the database connection
?>

