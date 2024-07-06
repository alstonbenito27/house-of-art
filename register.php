<?php
// Include database connection
include '../db/db.php';

$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $password = isset($_POST['pwd']) ? $_POST['pwd'] : '';

    // Sanitize input data (consider using prepared statements for better security)
    $fname = mysqli_real_escape_string($conn, $fname);
    $email = mysqli_real_escape_string($conn, $email);
    $dob = mysqli_real_escape_string($conn, $dob);
    $phone = mysqli_real_escape_string($conn, $phone);
    $gender = mysqli_real_escape_string($conn, $gender);
    $password = mysqli_real_escape_string($conn, $password);

    // Check if email already exists
    $email_check_query = "SELECT * FROM regtable WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $email_check_query);
    $email_exists = mysqli_fetch_assoc($result);

    if ($email_exists) {
        $error_message = "Error: Email already exists.";
    } else {
        // Construct SQL query
        $sql = "INSERT INTO regtable (fullname, email, dob, phone, gender, password) 
                VALUES ('$fname', '$email', '$dob', '$phone', '$gender', '$password')";

        // Execute SQL query
        if (mysqli_query($conn, $sql)) {
            header("Location: ./login.php"); // Redirect after successful registration
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
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
    <div class="signup">  
        <h1 class="stitle">
            SignUp
        </h1>
        <div class="sforms">
            <?php if(!empty($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form name="register" action="./register.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label class="shead" for="fname">Full Name</label><br>
                <input type="text" id="newname" name="fname" placeholder="Your name" value="<?php echo isset($fname) ? $fname : ''; ?>"><br>
                <label class="shead" for="email">Email ID</label><br>
                <input type="text" id ="regemailid" name="email" placeholder="Email Id" value="<?php echo isset($email) ? $email : ''; ?>"><br>
                <label class="shead" for="dob">Date of Birth</label><br>
                <input type="date" id="dateofbirth" name="dob" value="<?php echo isset($dob) ? $dob : ''; ?>"><br>
                <label class="shead" for="phone">Phone</label><br>
                <input type="text" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>"><br>
                <div class="mb-3">
                    <label for="gender" class="shead">Gender</label>
                    <input type="radio" name="gender" id="male" value="Male" <?php if(isset($gender) && $gender == 'Male') echo 'checked'; ?>>Male
                    <input type="radio" name="gender" id="female" value="Female" <?php if(isset($gender) && $gender == 'Female') echo 'checked'; ?>>Female
                </div><br>
                <label class="shead" for="pwd">New Password</label><br>
                <input type="password" id="pwd" name="pwd"><br>
                <input style ="border-radius:30px" type="submit" value="Submit">
            </form>
        </div>
    </div>
    <script src="/js/reg.js"></script>
</body>
</html>
