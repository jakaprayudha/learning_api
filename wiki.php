<?php
require 'api-wiki.php';

// Ambil parameter pencarian dari query string
$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : "earth";
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 1;

// Buat instance dari WikiController
$wikiController = new WikiController();
$data = $wikiController->fetchWikiData($searchTerm, $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wikipedia Search</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
      .placeholder {
         background-color: #f8f9fa;
         display: flex;
         justify-content: center;
         align-items: center;
         width: 100px;
         height: 100px;
         font-size: 12px;
         color: #6c757d;
         border: 1px solid #ddd;
      }
   </style>
</head>

<body>
   <div class="container mt-4">
      <h1>Wikipedia Search</h1>
      <!-- Search Form -->
      <form action="" method="GET" class="mb-4">
         <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search Wikipedia..." value="<?= $searchTerm ?>" required>
            <input type="number" name="limit" class="form-control" placeholder="Results limit" value="<?= $limit ?>" min="1">
            <button type="submit" class="btn btn-primary">Search</button>
         </div>
      </form>

      <!-- Results -->
      <ul class="list-group">
         <?php if (isset($data['error'])) : ?>
            <li class="list-group-item text-danger"><?= $data['error'] ?></li>
         <?php elseif (empty($data['pages'])) : ?>
            <li class="list-group-item text-warning">No results found for "<strong><?= $searchTerm ?></strong>".</li>
         <?php else : ?>
            <?php foreach ($data['pages'] as $page) : ?>
               <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                     <div class="fw-bold"><?= htmlspecialchars($page['title']) ?></div>
                     <?= htmlspecialchars($page['description'] ?? 'No description available.') ?>
                  </div>
                  <span>
                     <?php if (isset($page['thumbnail']['url'])) : ?>
                        <img src="<?= htmlspecialchars($page['thumbnail']['url']) ?>" width="100px" alt="<?= htmlspecialchars($page['title']) ?>">
                     <?php else : ?>
                        <div class="placeholder">No Image</div>
                     <?php endif; ?>
                  </span>
               </li>
            <?php endforeach; ?>
         <?php endif; ?>
      </ul>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>