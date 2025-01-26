<?php

class Admin {
    private $conn;
    private $table = "admins";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all admins
    public function getAllAdmins() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new admin
    public function addAdmin($username, $password, $role = 'admin') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO {$this->table} (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Update admin
    public function updateAdmin($id, $username, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE {$this->table} SET username = :username, password = :password WHERE id = :id";
        } else {
            $query = "UPDATE {$this->table} SET username = :username WHERE id = :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        if ($password) {
            $stmt->bindParam(':password', $hashedPassword);
        }
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Delete admin
    public function deleteAdmin($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
