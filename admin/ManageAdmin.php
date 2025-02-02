<?php
require_once '../config/constant.php';

class ManageAdmin {
    private $conn;
    private $table = "admins";

    public function __construct() {
        $db = new Database(); 
        $this->conn = $db->getConnection(); 
    }

    // Fetch all admins
    public function getAllAdmins() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get admin by ID
    public function getAdminById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Add a new admin
    public function addAdmin($username, $password, $role = 'admin') {
        $query = "INSERT INTO {$this->table} (username,password, role) VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $role);

        return $stmt->execute();
    }

    // Update admin
    public function updateAdmin($id, $username, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE {$this->table} SET username = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssi", $username, $hashedPassword, $id);
        } else {
            $query = "UPDATE {$this->table} SET username = ?, WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $username, $id);
        }

        return $stmt->execute();
    }

    // Delete admin
    public function deleteAdmin($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Count total admins
    public function countAdmins() {
        $query = "SELECT COUNT(*) as total_admins FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total_admins'];
    }
}
