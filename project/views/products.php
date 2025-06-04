<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Storefront</title>
</head>
<body>
    <h1>Product Catalog</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <strong><?php echo htmlspecialchars($product['name'] ?? ''); ?></strong> -
                <?php echo htmlspecialchars($product['price'] ?? ''); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
