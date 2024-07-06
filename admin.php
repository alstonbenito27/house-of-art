<?php
// Include database connection
include '../db/db.php';

$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userid = isset($_POST['userid']) ? $_POST['userid'] : '';
    $password = isset($_POST['pwd']) ? $_POST['pwd'] : '';

    // Sanitize input data (consider using prepared statements for better security)
    $userid = mysqli_real_escape_string($conn, $userid);
    $password = mysqli_real_escape_string($conn, $password);

    // Construct SQL query
    $sql = "SELECT * FROM adminlog WHERE userid = '$userid'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User found, verify password
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {
            // Password correct, redirect to front page
            header("Location: ../php/jobs.php"); // Change front.php to your desired page
            exit();
        } else {
            // Incorrect password
            header("Location: ./admin.php?error=incorrect_password");
            exit();
        }
    } else {
        // Userid not found
        header("Location: ./admin.php?error=userid_not_found");
        exit();
    }
}

// Close database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
  <head>
    <title>House of Art</title>
    <link rel="stylesheet" href="../css/log.css">
  </head>
  <body>
    <div style="text-align: center;">
      <a href="./front.php"><img class="logo" src="../pics/logo2.png"></a>
    </div>
    <div class="login">
      <h1 class="stitle">Admin Login</h1>
      <div class="lforms">
        <?php
          // Display error messages if any
          if(isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'incorrect_password') {
              echo '<div class="error">Incorrect password.</div>';
            } elseif ($error == 'userid_not_found') {
              echo '<div class="error">Userid not found.</div>';
            }
          }
        ?>
        <form action="./admin.php" method="post">
          <label class="shead" for="userid">USER ID</label><br>
          <input type="text" id="emailid" name="userid" placeholder="User Id" required>
          <div class="error" id="emailError"></div>
          <label class="shead" for="pwd">Password</label><br>
          <input type="password" id="lpwd" name="pwd" required>
          <div class="error" id="pwdError"></div>
          <br><br>
          <input type="submit" value="Submit">
        </form>
      </div>
    </div>
  </body>
</html>
