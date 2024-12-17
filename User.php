<?php
class User
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Create a new user
     */
    public function createUser($matric, $name, $password, $role)
    {
        $password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return "Error preparing query: " . $this->conn->error;
        }

        $stmt->bind_param("ssss", $matric, $name, $password, $role);
        $result = $stmt->execute();

        if ($result) {
            $stmt->close();
            return true;
        } else {
            $error = $stmt->error;
            $stmt->close();
            return "Error executing query: " . $error;
        }
    }

    /**
     * Read all users
     */
    public function getUsers()
    {
        $sql = "SELECT matric, name, role FROM users";
        $result = $this->conn->query($sql);

        if (!$result) {
            return "Error executing query: " . $this->conn->error;
        }

        return $result;
    }

    /**
     * Read a single user by matric
     */
    public function getUser($matric)
    {
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return "Error preparing query: " . $this->conn->error;
        }

        $stmt->bind_param("s", $matric);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        if ($user) {
            return $user;
        } else {
            return null; // Return null if the user is not found
        }
    }

    /**
     * Update a user's information
     */
    public function updateUser($matric, $name, $role)
    {
        $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return "Error preparing query: " . $this->conn->error;
        }

        $stmt->bind_param("sss", $name, $role, $matric);
        $result = $stmt->execute();

        if ($result) {
            $stmt->close();
            return true;
        } else {
            $error = $stmt->error;
            $stmt->close();
            return "Error executing query: " . $error;
        }
    }

    /**
     * Delete a user by matric
     */
    public function deleteUser($matric)
    {
        $sql = "DELETE FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return "Error preparing query: " . $this->conn->error;
        }

        $stmt->bind_param("s", $matric);
        $result = $stmt->execute();

        if ($result) {
            $stmt->close();
            return true;
        } else {
            $error = $stmt->error;
            $stmt->close();
            return "Error executing query: " . $error;
        }
    }
}
