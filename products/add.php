<?php

declare(strict_types=1);

require_once '../includes/auth.php';

$pageTitle = "Ongeraho Igicuruzwa | Ihuriro";

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

<link rel="stylesheet" href="../assets/css/product.css">

<main class="container">

    <section class="form-card">

        <h2>Ongeraho Igicuruzwa</h2>

        <?php if (isset($_SESSION['errors'])): ?>

            <div class="alert error">

                <?php foreach ($_SESSION['errors'] as $error): ?>

                    <p><?= htmlspecialchars($error) ?></p>

                <?php endforeach; ?>

            </div>

            <?php unset($_SESSION['errors']); ?>

        <?php endif; ?>

        <form
            action="add_process.php"
            method="POST">

            <label>Izina ry'Igicuruzwa</label>

            <input
                type="text"
                name="product_name"
                value="<?= htmlspecialchars($_SESSION['old']['product_name'] ?? '') ?>"
                placeholder="Urugero: Isukari"
                required>

            <label>Igiciro kuri Unit (Frw)</label>

            <input
                type="number"
                name="unit_price"
                min="0"
                step="0.01"
                value="<?= htmlspecialchars($_SESSION['old']['unit_price'] ?? '') ?>"
                placeholder="Urugero: 1200"
                required>

            <label>Ingano Ihari</label>

            <input
                type="number"
                name="quantity"
                min="0"
                step="0.01"
                value="<?= htmlspecialchars($_SESSION['old']['quantity'] ?? '') ?>"
                placeholder="Urugero: 100"
                required>

            <label>Unit</label>

            <select name="unit" required>

                <option value="">Hitamo Unit</option>

                <option>Kg</option>

                <option>Carton</option>

                <option>Sack</option>

                <option>Piece</option>

                <option>Box</option>

                <option>Litre</option>

                <option>Packet</option>

                <option>Dozen</option>

            </select>

            <label>Discount (%)</label>

            <input
                type="number"
                name="discount"
                min="0"
                max="100"
                step="0.01"
                value="<?= htmlspecialchars($_SESSION['old']['discount'] ?? '0') ?>">

            <label>Ibisobanuro (Si ngombwa)</label>

            <textarea
                name="description"
                rows="4"
                placeholder="Andika ibisobanuro by'igicuruzwa..."><?= htmlspecialchars($_SESSION['old']['description'] ?? '') ?></textarea>

            <label>Amakuru ya Discount (Si ngombwa)</label>

            <textarea
                name="discount_info"
                rows="4"
                placeholder="Urugero: Kugura 10Kg ugahabwa 1Kg ubuntu"><?= htmlspecialchars($_SESSION['old']['discount_info'] ?? '') ?></textarea>

            <button
                class="btn"
                type="submit">

                <i class="fa-solid fa-plus"></i>

                Bika Igicuruzwa

            </button>

        </form>

    </section>

</main>

<?php

unset($_SESSION['old']);

require_once '../includes/footer.php';

?>