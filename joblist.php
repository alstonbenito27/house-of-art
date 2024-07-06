<?php
// Include database connection
include '../db/db.php';

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
    <title>Jobs List</title>
    <link rel="stylesheet" href="../css/joblist.css">
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

        /* Styling for logout button */
        .logout-button {
            display: block;
            width: 120px;
            padding: 10px;
            margin: 20px auto;
            text-align: center;
            background-color: #41694E;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #2D4733;
        }
    </style>
</head>
<body>
    <h1>Jobs List</h1>

    <!-- Link to create job page -->
    <a href="jobs.php">Create New Job</a>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table class="form-container">
            <tr>
                <th>Job Name</th>
                <th>Description</th>
                <th>Expected Experience</th>
                <th>Time of Project</th>
                <th>Salary</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['jobname']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['experience']; ?></td>
                    <td><?php echo $row['time_of_project']; ?></td>
                    <td><?php echo $row['salary']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No jobs found.</p>
    <?php } ?>

    <!-- Logout button -->
    <a href="./front.php" class="logout-button">Logout</a>
</body>
</html>
