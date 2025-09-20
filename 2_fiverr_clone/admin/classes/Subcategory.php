<?php  
/**
 * Class for handling Subcategory-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Subcategory extends Database {

    public function createSubcategory($category_id, $subcategory_name) {
        $sql = "INSERT INTO subcategories (category_id, subcategory_name) VALUES (?, ?)";
        try {
            return $this->executeNonQuery($sql, [$category_id, $subcategory_name]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // duplicate entry
                return "duplicate";
            }
            throw $e;
        }
    }

    public function getSubcategoriesByCategory($category_id) {
        $sql = "SELECT * FROM subcategories WHERE category_id = ? ORDER BY date_added DESC";
        return $this->executeQuery($sql, [$category_id]);
    }

    public function updateSubcategory($subcategory_id, $subcategory_name) {
        $sql = "UPDATE subcategories SET subcategory_name = ? WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$subcategory_id, $subcategory_name]);
    }

    public function deleteSubcategory($subcategory_id) {
        $sql = "DELETE FROM subcategories WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$subcategory_id]);
    }
}
?>
