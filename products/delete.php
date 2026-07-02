<?php

## CSS Is Included Here Instead of product.css ##
## CSS Is Included Here Instead of product.css ##
## CSS Is Included Here Instead of product.css ##

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$pageTitle = "Siba Igicuruzwa | Ihuriro";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: list.php");
    exit;
}

$sql = "SELECT *
        FROM products
        WHERE id = :id
        AND user_id = :user_id
        LIMIT 1";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id,
    ':user_id' => $_SESSION['user_id']
]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {

    $_SESSION['errors'] = [
        "Igicuruzwa nticyabonetse."
    ];

    header("Location: list.php");
    exit;
}

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="../assets/css/product.css">

<style>
 
</style>

<main class="container">

    <section class="form-card delete-card">

        <h2>Siba Igicuruzwa</h2>

        <div class="warning">

            Uremeza ko ushaka gusiba iki gicuruzwa?

        </div>

        <div class="product-summary">

            <h3><?= htmlspecialchars($product['product_name']) ?></h3>

            <p>

                <strong>Igiciro:</strong>

                <?= number_format((float)$product['unit_price'], 0) ?>

                Frw /

                <?= htmlspecialchars($product['unit']) ?>

            </p>

            <p>

                <strong>Ingano:</strong>

                <?= htmlspecialchars($product['quantity']) ?>

                <?= htmlspecialchars($product['unit']) ?>

            </p>

            <?php if ($product['discount'] > 0): ?>

                <p>

                    <strong>Discount:</strong>

                    <?= htmlspecialchars($product['discount']) ?>%

                </p>

            <?php endif; ?>

            <?php if (!empty($product['description'])): ?>

                <p>

                    <strong>Ibisobanuro:</strong><br>

                    <?= nl2br(htmlspecialchars($product['description'])) ?>

                </p>

            <?php endif; ?>

        </div>

        <form action="delete_process.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $product['id'] ?>">

            <div class="actions">
                <!-- Consistent to list.php delete button -->
                    <a

                    href="delete.php?id=<?= $product['id'] ?>"

                    class="delete-btn">

                    Siba

                    </a>
                </div>
            

            <a
                href="list.php"
                class="cancel-btn">

                Garuka

            </a>

        </form>

    </section>

</main>

<?php require_once '../includes/footer.php'; ?>