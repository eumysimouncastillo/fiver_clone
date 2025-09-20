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
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <style>
    body { font-family: "Arial"; }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <div class="container-fluid mt-4">
    <h1 class="text-center mb-4">Browse Proposals</h1>

    <?php if ($category_id || $subcategory_id): ?>
      <h5 class="text-center text-muted">
        Filtering by:
        <?php if ($category_id) echo "Category ID: ".htmlspecialchars($category_id)." "; ?>
        <?php if ($subcategory_id) echo "Subcategory ID: ".htmlspecialchars($subcategory_id); ?>
      </h5>
    <?php endif; ?>
    
    <div class="row justify-content-center">
      <div class="col-md-12">
        <?php if (!empty($proposals)): ?>
          <?php foreach ($proposals as $proposal): ?>
            <div class="card shadow mt-4 mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <h4>
                      <a href="other_profile_view.php?user_id=<?php echo $proposal['user_id']; ?>">
                        <?php echo htmlspecialchars($proposal['username']); ?>
                      </a>
                    </h4>
                    <img src="<?php echo '../images/'.$proposal['image']; ?>" class="img-fluid" alt="Proposal Image">
                  </div>
                  <div class="col-md-8">
                    <p><strong>Category:</strong> <?php echo $proposal['category_name'] ?? 'N/A'; ?></p>
                    <p><strong>Subcategory:</strong> <?php echo $proposal['subcategory_name'] ?? 'N/A'; ?></p>

                    <p class="mt-3 mb-3"><?php echo nl2br(htmlspecialchars($proposal['description'])); ?></p>
                    <h4 class="text-success">
                      <?php echo number_format($proposal['min_price'])." - ".number_format($proposal['max_price']); ?> PHP
                    </h4>

                    
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-info text-center">No proposals found for this selection.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
