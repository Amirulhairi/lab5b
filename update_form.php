<?php
include 'Database.php';
include 'User.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matric'])) {
    // Retrieve the matric value from the GET request
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Fetch the user details using the matric value
    $user = new User($db);
    $userDetails = $user->getUser($matric);

    // Check if the user details were fetched successfully
    if (!$userDetails) {
        echo "User not found.";
        exit;
    }

    // Display the update form with the fetched user data
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update User</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <h1>Update User</h1>
        <form action="update.php" method="post">
            <input type="hidden" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required><br>
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="">Please select</option>
                <option value="lecturer" <?php echo $userDetails['role'] == 'lecturer' ? 'selected' : ''; ?>>Lecturer</option>
                <option value="student" <?php echo $userDetails['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
            </select><br>
            <input type="submit" value="Update">
        </form>
    </body>

    </html>
    <?php
} else {
    echo "Invalid request.";
}
?>
