<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/csrf.php';

requireLogin();

$message = '';
$error = '';

try {
    $pdo = getDBConnection();

    // Handle POST actions (toggle status, delete)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        requireCSRFValidation();
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            if ($action === 'toggle') {
                $stmt = $pdo->prepare("UPDATE product_categories SET status = IF(status='active','inactive','active'), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$id]);
                $message = 'Category status updated.';
            } elseif ($action === 'delete') {
                // Safe delete only if no products linked
                $check = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
                $check->execute([$id]);
                if ($check->fetchColumn() > 0) {
                    $error = 'Cannot delete: There are products linked to this category.';
                } else {
                    $stmt = $pdo->prepare("DELETE FROM product_categories WHERE id = ?");
                    $stmt->execute([$id]);
                    $message = 'Category deleted.';
                }
            }
        }
    }

    // Fetch categories
    $stmt = $pdo->query("SELECT * FROM product_categories ORDER BY display_order ASC, name ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error: ' . $e->getMessage();
}

$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Categories | Admin</title>
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  <link rel="stylesheet" type="text/css" href="../css/dashboard-custom.css">
</head>
<body>
  <div class="main-wrapper">
    <?php include 'includes/sidebar-global.php'; ?>
    <main id="edash-main">
      <?php include 'includes/header-global.php'; ?>

      <div class="edash-page-container" id="edash-page-container">
        <div class="edash-content-breadcumb row mb-4 mb-md-6 pt-md-2 px-4">
          <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
              <h2 class="h4 fw-semibold text-dark">Product Categories</h2>
            </div>
            <div>
              <a href="category-create.php" class="btn btn-primary"><i class="fi fi-rr-plus me-2"></i>Add Category</a>
            </div>
          </div>
        </div>

        <div class="px-4">
          <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <?= htmlspecialchars($message) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <?= $error ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped align-middle">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th>Status</th>
                      <th>Order</th>
                      <th class="text-end">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($categories)): $i=1; foreach ($categories as $c): ?>
                      <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><code><?= htmlspecialchars($c['slug']) ?></code></td>
                        <td><span class="badge bg-<?= $c['status']==='active'?'success':'secondary' ?>"><?= htmlspecialchars(ucfirst($c['status'])) ?></span></td>
                        <td><?= (int)$c['display_order'] ?></td>
                        <td class="text-end">
                          <a href="category-create.php?id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fi fi-rr-edit me-1"></i>Edit</a>
                          <form method="post" action="" class="d-inline">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                            <input type="hidden" name="action" value="toggle">
                            <button type="submit" class="btn btn-sm btn-outline-warning"><i class="fi fi-rr-refresh me-1"></i><?= $c['status']==='active'?'Deactivate':'Activate' ?></button>
                          </form>
                          <form method="post" action="" class="d-inline" onsubmit="return confirm('Delete this category?');">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fi fi-rr-trash me-1"></i>Delete</button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr><td colspan="6" class="text-center text-muted">No categories found.</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>

  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
</body>
</html>


