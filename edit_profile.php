<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting

$servername = "localhost";
$dbUsername = "root"; // Update with your actual username
$dbPassword = ""; // Update with your actual password
$dbname = "testpage"; // Update with your actual database name

try {
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
    $conn->set_charset("utf8mb4");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Extract and sanitize input values
        $newUsername = $_POST['username'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $oldUsername = $_POST['old_username']; // Assuming username is stored in session

        // Prepare and bind parameters
        $stmt = $conn->prepare("UPDATE register SET username=?, address=?, contact=? WHERE username=?");
        if ($stmt === false) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param("ssss", $newUsername, $address, $contact, $oldUsername);
        if (!$stmt->execute()) {
            throw new Exception("Update query failed: " . $stmt->error);
        }

        echo "Profile updated successfully!";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.container {
    width: 300px;
    margin: 20px auto;
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
</style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>

<h2>Edit Profile</h2>

<form method="post" action="">
    <input type="hidden" id="old_username" name="old_username" value="<?php echo $_SESSION['username']; ?>"><br> <!-- Assuming username is stored in session -->

    <label for="username">New Username:</label><br>
    <input type="text" id="username" name="username" required><br>

    <label for="address">Address:</label><br>
    <input type="text" id="address" name="address" required><br>

    <label for="contact">Contact:</label><br>
    <input type="text" id="contact" name="contact" required><br>

    <input type="submit" value="Update Profile">
</form>

</body>
</html>
