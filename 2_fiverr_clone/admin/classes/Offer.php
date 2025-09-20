<?php  
/**
 * Class for handling Offer-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Offer extends Database {

    public function createOffer($user_id, $description, $proposal_id) {
        $sql = "INSERT INTO offers (user_id, description, proposal_id) VALUES (?, ?, ?)";
        try {
            return $this->executeNonQuery($sql, [$user_id, $description, $proposal_id]);
        } catch (PDOException $e) {
            // 1062 = duplicate entry error code in MySQL
            if ($e->getCode() == 23000) {
                return "duplicate";
            }
            throw $e; // rethrow if it's another error
        }
    }

    public function getOffersByProposalID($proposal_id) {
        $sql = "SELECT 
                    offers.*, fiverr_clone_users.*, 
                    offers.date_added AS offer_date_added 
                FROM Offers 
                JOIN fiverr_clone_users ON 
                    offers.user_id = fiverr_clone_users.user_id
                WHERE proposal_id = ? 
                ORDER BY Offers.date_added DESC";
        return $this->executeQuery($sql, [$proposal_id]);
    }

    public function updateOffer($description, $offer_id) {
        $sql = "UPDATE Offers SET description = ? WHERE Offer_id = ?";
        return $this->executeNonQuery($sql, [$description, $offer_id]);
    }
    

    /**
     * Deletes an Offer.
     * @param int $id The Offer ID to delete.
     * @return int The number of affected rows.
     */
    public function deleteOffer($id) {
        $sql = "DELETE FROM Offers WHERE Offer_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }


}
?>