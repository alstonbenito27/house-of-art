<?php
// Start the session
session_start();

// Include database connection
include '../db/db.php'; // Assuming db.php contains database connection settings

// Check if email is set in session
if (!isset($_SESSION['email'])) {
    // Redirect to login page if email is not set in session
    header("Location: /path/to/login.php");
    exit();
}

// Retrieve email from session and sanitize
$email = $_SESSION['email'];
$email = mysqli_real_escape_string($conn, $email);

// Construct SQL query to fetch user details based on email
$sql = "SELECT * FROM regtable WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

// Check if query executed successfully
if (!$result) {
    // SQL query execution failed
    die("Query failed: " . mysqli_error($conn));
}

// Check if user exists
if (mysqli_num_rows($result) == 1) {
    // Fetch user details
    $userDetails = mysqli_fetch_assoc($result);
} else {
    // User not found in the database
    die("User details not found for email: $email");
}

// Close database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details</title>
    <link rel="stylesheet" href="../css/log.css">
    <style>
        /* Reset default margin and padding for body */
        body {
            font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            background-image: url("../pics/cool-background.png");
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center all content horizontally */
            align-items: center; /* Center all content vertically */
            height: 100vh; /* Full viewport height */
        }

        /* Styling for the user details container */
        .user-details {
            text-align: center;
            padding: 40px; /* Increase padding for more spacing */
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            max-width: 800px; /* Limit the maximum width */
            width: 90%; /* Adjust the width */
        }

        .user-details h1 {
            color: #41694E;
            font-size: 30px;
            font-variant: small-caps;
            margin-bottom: 30px; /* Increase bottom margin */
        }

        .user-details p {
            font-size: 18px;
            color: #41694E;
            margin-bottom: 20px; /* Increase bottom margin */
        }

        /* Styling for the buttons */
        .apply-button,
        .logout-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            margin-top: 30px; /* Increase top margin */
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .apply-button:hover,
        .logout-button:hover {
            background-color: #0056b3; /* Darken button color on hover */
        }

        /* Additional styling */
        .logo {
            width: 130px;
            height: auto;
            display: block;
            margin: 20px auto; /* Center the logo horizontally */
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <a href="./front.php"><img class="logo" src="../pics/logo2.png"></a>
    </div>

    <div class="user-details">
        <h1>User Details</h1>
        <?php if (isset($userDetails)): ?>
            <p><strong>Name:</strong> <span style="color: #41694E;"><?php echo $userDetails['fullname']; ?></span></p>
            <p><strong>Email:</strong> <span style="color: #41694E;"><?php echo $userDetails['email']; ?></span></p>
            <p><strong>Date of Birth:</strong> <span style="color: #41694E;"><?php echo $userDetails['dob']; ?></span></p>
            <p><strong>Phone:</strong> <span style="color: #41694E;"><?php echo $userDetails['phone']; ?></span></p>
            <p><strong>Gender:</strong> <span style="color: #41694E;"><?php echo $userDetails['gender']; ?></span></p>
            <!-- Add more user details as needed -->

            <a href="./apply.php" class="apply-button">Apply</a>
        <?php else: ?>
            <p>User details not found.</p>
        <?php endif; ?>

        <!-- Logout link -->
        <a href="./front.php" class="logout-button">Logout</a>
    </div>

</body>
</html>

