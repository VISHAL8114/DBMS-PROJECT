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

// Get user input
$username = isset($_POST['username']) ? $_POST['username'] : '';
$passwordEntered = isset($_POST['password']) ? $_POST['password'] : '';

// Retrieve the hashed password and user ID from the database using the username
$getUserQuery = "SELECT username, password FROM teacherusers WHERE username = $1";
$getUserResult = pg_query_params($conn, $getUserQuery, array($username));
$userData = pg_fetch_assoc($getUserResult);

// Check if the username exists
if (empty($userData)) {
    echo "<script>alert('Error: Incorrect username');</script>";
    exit;
}

$hashedPassword = $userData['password'];
$userId = $userData['username'];

// Verify the entered password against the hashed password
if ($passwordEntered == $hashedPassword) {
    header("Location: teacherindex.html");
    exit;
} else {
    echo "<script>alert('Error: Incorrect password');</script>";
}

pg_close($conn); // Close the database connection
?>
