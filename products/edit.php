<?php

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$pageTitle = "Hindura Igicuruzwa";
$pageCSS = "../assets/css/product.css";

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {

    $_SESSION['errors'] = [
        "Igicuruzwa nticyabonetse."
    ];

    header("Location: list.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Fetch Product
|--------------------------------------------------------------------------
*/

$sql = "

SELECT *

FROM products

WHERE id = :id

AND user_id = :user_id

LIMIT 1

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':id' => $id,

    ':user_id' => $_SESSION['user_id']

]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {

    $_SESSION['errors'] = [
        "Ntabwo wemerewe guhindura iki gicuruzwa."
    ];

    header("Location: list.php");
    exit;
}

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>
<link rel="stylesheet" href="../assets/css/product.css">
<main class="container">

    <section class="form-card">

        <h2>Hindura Igicuruzwa</h2>

        <p class="form-description">
            Hindura amakuru y'igicuruzwa hanyuma ukande
            <strong>"Bika Impinduka"</strong>.
        </p>

        <?php if(isset($_SESSION['errors'])): ?>

            <div class="alert error">

                <?php foreach($_SESSION['errors'] as $error): ?>

                    <p><?= htmlspecialchars($error) ?></p>

                <?php endforeach; ?>

            </div>

            <?php unset($_SESSION['errors']); ?>

        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>

            <div class="alert success">

                <?= htmlspecialchars($_SESSION['success']) ?>

            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <form action="update_process.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $product['id'] ?>">

            <label>Izina ry'Igicuruzwa</label>

            <input
                type="text"
                name="product_name"
                required
                value="<?= htmlspecialchars($product['product_name']) ?>">

            <label>Igiciro (Frw)</label>

            <input
                type="number"
                name="unit_price"
                step="0.01"
                min="0"
                required
                value="<?= htmlspecialchars($product['unit_price']) ?>">

            <label>Ingano</label>

            <input
                type="number"
                name="quantity"
                step="0.01"
                min="0"
                required
                value="<?= htmlspecialchars($product['quantity']) ?>">

            <label>Unit</label>

            <select name="unit" required>

                <?php

                $units = [
                    'Kg',
                    'g',
                    'L',
                    'ml',
                    'Piece',
                    'Box',
                    'Packet',
                    'Dozen',
                    'Meter',
                    'Roll',
                    'Bag'
                ];

                foreach($units as $unit):

                ?>

                <option
                    value="<?= $unit ?>"
                    <?= $product['unit'] === $unit ? 'selected' : '' ?>>

                    <?= $unit ?>

                </option>

                <?php endforeach; ?>

            </select>

            <label>Poromosiyo (%)</label>

            <input
                type="number"
                name="discount"
                min="0"
                max="100"
                step="0.01"
                value="<?= htmlspecialchars($product['discount']) ?>">

            <label>Ibisobanuro</label>

            <textarea
                name="description"
                rows="5"><?= htmlspecialchars($product['description']) ?></textarea>

            <button
                type="submit"
                class="btn">

                <i class="fa-solid fa-floppy-disk"></i>

                Bika Impinduka

            </button>

        </form>

    </section>

</main>

<?php require_once '../includes/footer.php'; ?>