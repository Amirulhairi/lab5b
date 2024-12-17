<?php
include 'Database.php';
include 'User.php';

// Create an instance of the Database class and get the connection
$database = new Database();
$db = $database->getConnection();

// Create an instance of the User class
$user = new User($db);
$result = $user->getUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Users</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>User List</h1>
    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Fetch each row from the result set
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["matric"]); ?></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["role"]); ?></td>
                    <td><a href="update_form.php?matric=<?php echo urlencode($row["matric"]); ?>">Update</a></td>
                    <td><a href="delete.php?matric=<?php echo urlencode($row["matric"]); ?>">Delete</a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5">No users found</td>
            </tr>
            <?php
        }
        // Close connection
        $db->close();
        ?>
    </table>
</body>

</html>
