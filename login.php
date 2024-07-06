<?php
// Include database connection
include '../db/db.php';

$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = isset($_POST['emailreg']) ? $_POST['emailreg'] : '';
    $password = isset($_POST['pwd']) ? $_POST['pwd'] : '';

    // Sanitize input data (consider using prepared statements for better security)
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Construct SQL query to check credentials
    $sql = "SELECT * FROM regtable WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Start session and set session variables
            session_start();
            $_SESSION['email'] = $email;

            // Redirect to user details page
        // Redirect to user_details.php (assuming it's in the same directory)
header("Location: user_details.php");
exit();

        } else {
            // Incorrect email or password
            $error_message = "Incorrect email or password.";
        }
    } else {
        // SQL query execution error
        $error_message = "Database query error: " . mysqli_error($conn);
    }

    // Close result set
    mysqli_free_result($result);
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>House of Art</title>
    <link rel="stylesheet" href="../css/log.css">
    <style>
        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body background="../pics/cool-background.png">
    <div style="text-align: center;">
        <a href="./front.php"><img class="logo" src="../pics/logo2.png"></a>
    </div>
    <div class="login">
        <h1 class="stitle">Login</h1>
        <div class="lforms">
            <?php if (!empty($error_message)) { ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php } ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label class="shead" for="emailreg">Email ID</label><br>
                <input type="text" id="emailid" name="emailreg" placeholder="Email Id" required><br>
                <label class="shead" for="pwd">Password</label><br>
                <input type="password" id="lpwd" name="pwd" required><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
