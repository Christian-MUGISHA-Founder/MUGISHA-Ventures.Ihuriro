<?php

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$pageTitle = "Hindura Profile | Ihuriro";

$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = :id
    LIMIT 1
");

$stmt->execute([
    ':id' => $_SESSION['user_id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="../assets/css/edit-profile.css">

<main class="container">

<section class="edit-card">

    <h2>Hindura Profile</h2>

    <?php if (isset($_SESSION['success'])): ?>

        <div class="alert success">

            <?= htmlspecialchars($_SESSION['success']) ?>

        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['errors'])): ?>

        <div class="alert error">

            <?php foreach ($_SESSION['errors'] as $error): ?>

                <p><?= htmlspecialchars($error) ?></p>

            <?php endforeach; ?>

        </div>

        <?php unset($_SESSION['errors']); ?>

    <?php endif; ?>

    <form action="update_process.php" method="POST">

        <label>Amazina Yose</label>

        <input
            type="text"
            name="full_name"
            value="<?= htmlspecialchars($_SESSION['old']['full_name'] ?? $user['full_name']) ?>"
            required>

        <label>Izina ry'Ubucuruzi</label>

        <input
            type="text"
            name="username"
            value="<?= htmlspecialchars($_SESSION['old']['username'] ?? $user['username']) ?>">

        <label>Email</label>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($_SESSION['old']['email'] ?? $user['email']) ?>"
            required>

        <label>Telefone</label>

        <input
            type="text"
            name="phone"
            value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? $user['phone']) ?>"
            required>

        <label>Akarere</label>

        <input
            type="text"
            name="district"
            value="<?= htmlspecialchars($_SESSION['old']['district'] ?? $user['district']) ?>"
            required>

        <label>Umurenge</label>

        <input
            type="text"
            name="sector"
            value="<?= htmlspecialchars($_SESSION['old']['sector'] ?? $user['sector']) ?>"
            required>

        <label>Akagari</label>

        <input
            type="text"
            name="cell"
            value="<?= htmlspecialchars($_SESSION['old']['cell'] ?? $user['cell']) ?>"
            required>

        <label>Aho Ubarizwa</label>

        <textarea
            name="address_description"
            rows="4"
            required><?= htmlspecialchars($_SESSION['old']['address_description'] ?? $user['address_description']) ?></textarea>

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