<?php
require_once 'classloader.php';

$category_id = $_GET['category_id'] ?? null;
$subcategory_id = $_GET['subcategory_id'] ?? null;

if ($subcategory_id) {
    $proposals = $proposalObj->getProposalsBySubcategory($subcategory_id);
} elseif ($category_id) {
    $proposals = $proposalObj->getProposalsByCategory($category_id);
} else {
    $proposals = $proposalObj->getProposals();
}
?>

<h1>Browse Proposals</h1>
<?php foreach ($proposals as $proposal): ?>
  <div>
    <h2><?php echo $proposal['description']; ?></h2>
    <p><?php echo $proposal['min_price']; ?> - <?php echo $proposal['max_price']; ?></p>
  </div>
<?php endforeach; ?>
