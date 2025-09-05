<?php

class Product {
    public function getProducts($category_id = null, $sort = 'cheapest') {
        try {
            $pdo = DB::getInstance()->getConnection();
            $sql = "SELECT p.*, c.name AS category_name FROM products p
                LEFT JOIN categories c ON p.category_id = c.id";
            $params = [];
            if ($category_id) {
                $sql .= " WHERE p.category_id = ?";
                $params[] = $category_id;
            }
            switch ($sort) {
                case 'cheapest':
                    $sql .= " ORDER BY p.price ASC";
                    break;
                case 'alphabetical':
                    $sql .= " ORDER BY p.name ASC";
                    break;
                case 'newest':
                    $sql .= " ORDER BY p.date DESC";
                    break;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            ErrorLogging::logError($e);
        }
        return [];
    }

    public function getById($id) {
        try {
            $pdo = DB::getInstance()->getConnection();
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            ErrorLogging::logError($e);
        }
        return [];
    }
}