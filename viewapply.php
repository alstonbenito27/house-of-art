<?php
// Include database connection
include '../db/db.php';

// Initialize variables
$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Reopen database connection
    $conn = mysqli_connect("localhost", "root", "", "registration");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Iterate through each form field
    foreach ($_POST as $key => $value) {
        // Check if the form field represents a selected or rejected application
        if (strpos($key, 'select_') === 0 || strpos($key, 'reject_') === 0) {
            // Extract the job ID from the form field name
            $jobId_email = substr($key, strpos($key, '_') + 1);

            // Extract job ID and email from the combined string
            list($jobId, $email) = explode('_', $jobId_email);

            // Determine the result based on the form field name
            $result = (strpos($key, 'select_') === 0) ? 'select' : 'reject';

            // Insert into validation table
            $sqlInsert = "INSERT INTO validation (id, emailid, result) VALUES ('$jobId', '$email', '$result')";
            if (!mysqli_query($conn, $sqlInsert)) {
                $error_message .= "Error inserting record for job ID '$jobId' and email '$email' into validation table.<br>";
            }
        }
    }

    // Close database connection
    mysqli_close($conn);

    // Redirect to the same page to prevent form resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Fetch applications from the database
$conn = mysqli_connect("localhost", "root", "", "registration");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id, Name, email, cover FROM application";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Applications</title>
    <link rel = "stylesheet" href = "../css/viewapply.css">
    <style>
        /* Custom styling for container */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 100px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Admin View Applications</h1>

    <!-- Link to redirect to jobs.php -->
    <a href="jobs.php">Back to Jobs</a>

    <form class = "form-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Cover Letter</th>
                    <th>Action</th>
                </tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['Name'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['cover'] . '</td>';
                echo '<td>
                        <input type="radio" name="select_' . $row['id'] . '_' . $row['email'] . '" value="select"> Select
                        <input type="radio" name="reject_' . $row['id'] . '_' . $row['email'] . '" value="reject"> Reject
                    </td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<input type="submit" value="Update Result">';
        } else {
            echo '<p>No applications found.</p>';
        }
        ?>
    </form>

    <?php echo $error_message; ?>
</body>
</html>
