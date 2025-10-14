<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/csrf.php';

requireLogin();

$isEdit = isset($_GET['id']) && ctype_digit($_GET['id']);
$categoryId = $isEdit ? (int)$_GET['id'] : null;
$form = ['name'=>'','slug'=>'','description'=>'','status'=>'active','display_order'=>0];
$message='';$error='';

try {
    $pdo = getDBConnection();
    if ($isEdit) {
        $stmt = $pdo->prepare("SELECT * FROM product_categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) { $form = $row; } else { $isEdit=false; }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        requireCSRFValidation();
        $form['name'] = trim($_POST['name'] ?? '');
        $form['slug'] = trim($_POST['slug'] ?? '');
        $form['description'] = trim($_POST['description'] ?? '');
        $form['status'] = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive':'active';
        $form['display_order'] = (int)($_POST['display_order'] ?? 0);

        $errors=[];
        if ($form['name']==='') $errors[]='Name is required';
        if ($form['slug']==='') {
            // auto-generate from name
            $form['slug'] = strtolower(preg_replace('/[^a-z0-9]+/','-', $form['name']));
            $form['slug'] = trim($form['slug'],'-');
        }
        if (!preg_match('/^[a-z0-9-]+$/',$form['slug'])) $errors[]='Slug can contain lowercase letters, numbers and dashes only';

        // slug unique
        $sql = "SELECT id FROM product_categories WHERE slug = ?" . ($isEdit?" AND id != ?":"");
        $stmt = $pdo->prepare($sql);
        $params = [$form['slug']]; if ($isEdit) $params[]=$categoryId;
        $stmt->execute($params);
        if ($stmt->fetch()) $errors[]='Slug already exists';

        if (empty($errors)) {
            if ($isEdit) {
                $stmt = $pdo->prepare("UPDATE product_categories SET name=?, slug=?, description=?, status=?, display_order=?, updated_at=NOW() WHERE id=?");
                $stmt->execute([$form['name'],$form['slug'],$form['description'],$form['status'],$form['display_order'],$categoryId]);
                $message = 'Category updated successfully';
            } else {
                $stmt = $pdo->prepare("INSERT INTO product_categories(name,slug,description,status,display_order,created_at,updated_at) VALUES(?,?,?,?,?,NOW(),NOW())");
                $stmt->execute([$form['name'],$form['slug'],$form['description'],$form['status'],$form['display_order']]);
                $message = 'Category created successfully';
                $categoryId = (int)$pdo->lastInsertId();
                $isEdit = true;
            }
        } else {
            $error = implode('<br>', $errors);
        }
    }
} catch (Exception $e) { $error = 'Error: '.$e->getMessage(); }

$csrf = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $isEdit?'Edit':'Create' ?> Category | Admin</title>
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
            <div><h2 class="h4 fw-semibold text-dark"><?= $isEdit?'Edit':'Add' ?> Category</h2></div>
            <div><a href="categories.php" class="btn btn-outline-primary"><i class="fi fi-rr-arrow-left me-2"></i>Back</a></div>
          </div>
        </div>
        <div class="px-4">
          <?php if ($message): ?><div class="alert alert-success alert-dismissible fade show"><i class="fi fi-rr-checkbox me-2"></i><?= htmlspecialchars($message) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
          <?php if ($error): ?><div class="alert alert-danger alert-dismissible fade show"><i class="fi fi-rr-exclamation me-2"></i><?= $error ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

          <div class="card">
            <div class="card-body">
              <form method="post">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($form['name']) ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Slug <span class="text-muted">(auto if blank)</span></label>
                    <input type="text" class="form-control" name="slug" value="<?= htmlspecialchars($form['slug']) ?>">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($form['description']) ?></textarea>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                      <option value="active" <?= $form['status']==='active'?'selected':'' ?>>Active</option>
                      <option value="inactive" <?= $form['status']==='inactive'?'selected':'' ?>>Inactive</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Display Order</label>
                    <input type="number" class="form-control" name="display_order" value="<?= (int)$form['display_order'] ?>" min="0">
                  </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                  <button class="btn btn-primary" type="submit"><i class="fi fi-rr-checkbox me-2"></i><?= $isEdit?'Update':'Create' ?></button>
                  <a href="categories.php" class="btn btn-outline-primary"><i class="fi fi-rr-cross me-2"></i>Cancel</a>
                </div>
              </form>
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


