<?php
// Include database connection
include '../db/db.php';

// Initialize variables
$error_message = "";
$email = "";
$result_set = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email entered by the user
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Sanitize input data
    $email = mysqli_real_escape_string($conn, $email);

    // Fetch job status based on email ID
    $sql = "SELECT DISTINCT application.id, application.Name, application.email, validation.result 
            FROM application 
            INNER JOIN validation ON application.id = validation.id 
            WHERE application.email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $error_message = "Error fetching job status: " . mysqli_error($conn);
        // Output error message for debugging
        echo $error_message;
    } else {
        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch results if query was successful
            while ($row = mysqli_fetch_assoc($result)) {
                $result_set[] = $row;
            }
        } else {
            $error_message = "No job status found for the provided email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Status</title>
    <link rel = "stylesheet" href = "../css/finaldetail.css">
</head>
<body>
    <h1>Job Status</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Enter Email ID:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>
        <input type="submit" value="Check Status">
    </form>

    <?php if ($error_message): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (!empty($result_set)): ?>
        <h2>Job Status for <?php echo $email; ?>:</h2>
        <table class = "form_container" border="1">
            <tr>
                <th>Job ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Result</th>
            </tr>
            <?php foreach ($result_set as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['result']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <!-- Back link to showdetails.php -->
    <p><a href="user_details.php">Back to Show Details</a></p>
</body>
</html>
