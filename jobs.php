<?php
include '../db/db.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $jobname = $_POST['jobname'];
    $description = $_POST['description'];
    $experience = $_POST['experience'];
    $time_of_project = $_POST['time_of_project'];
    $salary = $_POST['salary'];

    // Database connection
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL INSERT query
    $sql = "INSERT INTO jobs (jobname, description, experience, time_of_project, salary) 
            VALUES ('$jobname', '$description', '$experience', '$time_of_project', '$salary')";

    if ($conn->query($sql) === TRUE) {
        echo "Job created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job</title>
    <link rel="stylesheet" href="../css/jobs.css">
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
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Flex container for buttons */
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Button styles */
        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #41694E;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button-container a:hover {
            background-color: #2D4733;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Job</h1>

        <!-- Background container for form -->
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="jobname">Job Name:</label><br>
                <input type="text" id="jobname" name="jobname" required><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" required></textarea><br>
                <label for="experience">Expected Experience:</label><br>
                <input type="text" id="experience" name="experience" required><br>
                <label for="time_of_project">Time of Project:</label><br>
                <input type="text" id="time_of_project" name="time_of_project" required><br>
                <label for="salary">Salary:</label><br>
                <input type="text" id="salary" name="salary" required><br><br>
                <input type="submit" value="Create Job">
            </form>
        </div>

        <!-- Button container for links -->
        <div class="button-container">
            <a href="viewapply.php">Validate</a>
            <a href="joblist.php">View the jobs</a>
        </div>
    </div>
</body>
</html>
