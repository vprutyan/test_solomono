<?php

class Category {
    public function getAllWithCounts()
    {
        try {
            $pdo = DB::getInstance()->getConnection();
            $stmt = $pdo->query("
            SELECT c.id, c.name, COUNT(p.id) as product_count
            FROM categories c
            LEFT JOIN products p ON p.category_id = c.id
            GROUP BY c.id
            ORDER BY c.name ASC
        ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            ErrorLogging::logError($e);
        }
        return [];
    }
}