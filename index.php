<?php
session_start();

$categories = ["Electronics", "Clothing", "Books", "Home", "Toys"];

if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        ["id" => 1, "name" => "Phone", "description" => "Android smartphone", "price" => 200.00, "category" => "Electronics"],
        ["id" => 2, "name" => "T-Shirt", "description" => "Cotton shirt", "price" => 20.00, "category" => "Clothing"]
    ];
}
$products = &$_SESSION['products'];

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$submittedData = [
    "name" => "",
    "description" => "",
    "price" => "",
    "category" => ""
];

$successMsg = $_SESSION['success'] ?? "";
unset($_SESSION['success']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === "add") {

        // Name
        $submittedData['name'] = test_input($_POST['name'] ?? "");
        if ($submittedData['name'] === "") {
            $errors['name'] = "Name required";
        } elseif (mb_strlen($submittedData['name']) < 3) {
            $errors['name'] = "Min 3 letters";
        }

        // Description
        $submittedData['description'] = test_input($_POST['description'] ?? "");
        if ($submittedData['description'] === "") {
            $errors['description'] = "Description required";
        } elseif (mb_strlen($submittedData['description']) < 5) {
            $errors['description'] = "Min 5 letters";
        }

        // Price
        $rawPrice = str_replace(',', '.', trim($_POST['price'] ?? ""));
        $rawPrice = preg_replace('/[^\d\.\-]/', '', $rawPrice);
        if ($rawPrice === "") {
            $errors['price'] = "Price required";
        } elseif (!is_numeric($rawPrice) || floatval($rawPrice) <= 0) {
            $errors['price'] = "Positive number only";
        } else {
            $submittedData['price'] = floatval($rawPrice);
        }

        // Category
        $submittedData['category'] = test_input($_POST['category'] ?? "");
        if ($submittedData['category'] === "") {
            $errors['category'] = "Category required";
        } elseif (!in_array($submittedData['category'], $categories, true)) {
            $errors['category'] = "Invalid category";
        }

        // === إذا ما في أخطاء.... أضف المنتج ===
        if (empty($errors)) {
            $maxId = max(array_column($products, 'id'));
            $newId = $maxId + 1;

            $products[] = [
                "id" => $newId,
                "name" => $submittedData['name'],
                "description" => $submittedData['description'],
                "price" => $submittedData['price'],
                "category" => $submittedData['category']
            ];

            $_SESSION['success'] = "Product added!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Delete
    if (isset($_POST['action']) && $_POST['action'] === "delete") {
        $id = intval($_POST['id'] ?? 0);
        foreach ($products as $i => $p) {
            if ($p['id'] === $id) {
                array_splice($products, $i, 1);
                $_SESSION['success'] = "Product deleted!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
        $_SESSION['success'] = "Product not found.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #51575dff; font-family: Arial, sans-serif; }
        h2,h3 { text-align:center; color:#f3ebebff; margin-bottom:18px; }
        .card { border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.08); max-width:800px; margin:auto; }
        .btn-primary { background-color:#142949ff; border-color:#142949ff; border-radius:8px; font-weight:600; }
        .btn-primary:hover { background-color:#36455dff; }
        .btn-danger { background-color:#d54030ff; border-color:#d54030ff; border-radius:6px; }
        .btn-danger:hover { background-color:#9b362aff; }
        .table-container { max-width:800px; margin:auto; }
        .table { background:white; border-radius:12px; overflow:hidden; }
        .table th { background:#142949ff; color:white; }
    </style>
</head>
<body>
<div class="container py-4">
    <h2> Product Management 📦</h2>

    <!-- Success Message -->
    <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success alert-dismissible fade show text-center">
            <?php echo htmlspecialchars($successMsg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger text-center">Please fix the errors below.</div>
    <?php endif; ?>

    <!--=== Add Product Form ===-->
    <form method="POST" class="card p-4 mb-4" novalidate>
        <input type="hidden" name="action" value="add">

        <!--== Name ==-->
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input id="name" type="text" name="name"
                   value="<?php echo htmlspecialchars($submittedData['name']); ?>"
                   class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['name']); ?></div>
            <?php endif; ?>
        </div>

        <!--== Description ==-->
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="description"
                      class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>"
                      rows="3"><?php echo htmlspecialchars($submittedData['description']); ?></textarea>
            <?php if (isset($errors['description'])): ?>
                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['description']); ?></div>
            <?php endif; ?>
        </div>

        <!--== Price ==-->

            <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input id="price" type="text" name="price"
                value="<?php echo isset($submittedData['price']) ? htmlspecialchars($submittedData['price']) : ''; ?>"
                class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : ''; ?>">
            <?php if (isset($errors['price'])): ?>
                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['price']); ?></div>
            <?php endif; ?>
        </div>


        <!--== Category ==-->

        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <select id="category" name="category"
                    class="form-select <?php echo isset($errors['category']) ? 'is-invalid' : ''; ?>">
                <option value="">--Please Choose--</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php if ($submittedData['category'] === $cat) echo "selected"; ?>>
                        <?php echo htmlspecialchars($cat); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['category'])): ?>
                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['category']); ?></div>
            <?php endif; ?>
        </div>

        <input type="submit" value="Add Product" class="btn btn-primary w-100">
    </form>

    <!--=== Product Table ===-->
    <div class="table-container">
        <h3> Product List 📋</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center mb-4">
                <thead>
                <tr>
                    <th>ID</th
                    ><th>Name</th>
                    <th>Description</th>
                    <th>Price ($)</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?php echo intval($p['id']); ?></td>
                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($p['description'])); ?></td>
                        <td><?php echo number_format((float)$p['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($p['category']); ?></td>
                        <td>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Delete this product?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo intval($p['id']); ?>">
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
