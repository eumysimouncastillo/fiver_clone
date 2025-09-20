<?php  
/**
 * Class for handling Category-related operations.
 */
class Category extends Database {

    public function createCategory($category_name) {
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        return $this->executeNonQuery($sql, [$category_name]);
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY date_added DESC";
        return $this->executeQuery($sql);
    }

    public function getAllCategoriesWithSubcategories() {
        // First get all categories
        $sql = "SELECT * FROM categories ORDER BY date_added DESC";
        $categories = $this->executeQuery($sql);

        // Attach subcategories to each category
        foreach ($categories as &$cat) {
            $sub_sql = "SELECT * FROM subcategories WHERE category_id = ? ORDER BY date_added DESC";
            $subcategories = $this->executeQuery($sub_sql, [$cat['category_id']]);
            $cat['subcategories'] = $subcategories;
        }

        return $categories;
    }

}
?>
