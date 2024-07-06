<?php
// Include database connection
include '../db/db.php';

// Start the session
session_start();

// Initialize variables
$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $jobId = isset($_POST['job_id']) ? $_POST['job_id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $coverLetter = isset($_POST['cover_letter']) ? $_POST['cover_letter'] : '';

    // Sanitize input data (consider using prepared statements for better security)
    $jobId = mysqli_real_escape_string($conn, $jobId);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $coverLetter = mysqli_real_escape_string($conn, $coverLetter);

    // Construct SQL query to insert into applications table
    $sql = "INSERT INTO application (id, Name, email, cover, status) 
            VALUES ('$jobId', '$name', '$email', '$coverLetter', 'pending')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Store email in session
        $_SESSION['email'] = $email;
        
        // Application successfully stored, you can redirect or show a success message
        header("Location: ./user_details.php");
        exit();
    } else {    
        $error_message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch jobs from the database
$sql = "SELECT * FROM jobs";
$result = mysqli_query($conn, $sql);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    
    <link rel="stylesheet" href="../css/apply.css">
    <style>
        /* Custom styling for container */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class = "stitle">Apply for Job</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <label class = "shead" for="name">Your Name:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label class = "shead" for="email">Your Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label class = "shead" for="cover_letter">Cover Letter:</label><br>
            <textarea id="cover_letter" name="cover_letter" rows="4" required></textarea><br><br>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <input type="radio" name="job_id" value="<?php echo $row['id']; ?>">
                    <label><?php echo $row['jobname']; ?> - <?php echo $row['description']; ?> (Experience: <?php echo $row['experience']; ?>, Time: <?php echo $row['time_of_project']; ?>, Salary: <?php echo $row['salary']; ?>)</label><br>
                <?php } ?>
            <?php } else { ?>
                <p>No jobs found.</p>
            <?php } ?>
            <input type="submit" value="Apply">
        </form>

        <!-- Back page link -->
        <div class="link-container">
            <a href="./user_details.php">Back</a>
            <a href="./front.php" class="logout-button">Logout</a>
            <a href="./finaldetail.php">View</a>
        </div>
    </div>
</body>
</html>
