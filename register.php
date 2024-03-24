<?php
// Change these credentials with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testpage";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the form method is POST and action points to this script
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form, ensure you're validating and sanitizing these inputs in a real application
    $userInputUsername = $_POST['username'];
    $userInputEmail = $_POST['email'];
    $userInputPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // It's good you're hashing the password
    $userInputAddress = $_POST['address'];
    $userInputContact = $_POST['contact'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO register (username, email, password, address, contact) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        // Prepare failed
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssss", $userInputUsername, $userInputEmail, $userInputPassword, $userInputAddress, $userInputContact);

    // Execute
    if ($stmt->execute()) {
        // Close the statement and the database connection
        $stmt->close();
        $conn->close();

        // Redirect to login page after successful registration
        header("Location: login.html"); // Adjust 'login.html' to the path of your actual login page
        exit();
    } else {
        echo "Error: " . $stmt->error;
        // Close the statement and the database connection in case of error as well
        $stmt->close();
        $conn->close();
    }
} else {
    // If the form wasn't submitted correctly, or this script was accessed directly, handle this case appropriately.
    // For example, redirect back to the form or show an error message.
    echo "Invalid request.";
}
?>
