<?php
class ManageProduct {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllProducts() {         
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
    
        if ($result) {
            if ($result->num_rows > 0) {
                $products = [];
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return $products;
            } else {
                return [];
            }
        } else {
            echo "Error: " . $this->conn->error;
            return [];
        }
}


    public function addProduct($name, $price, $stock) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $name, $price, $stock);
        return $stmt->execute();
    }

    public function updateProduct($id, $name, $price, $stock) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("sdii", $name, $price, $stock, $id);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
