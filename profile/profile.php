<?php

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$pageTitle = "Profile | Ihuriro";

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

$stmt->execute([
    ':id' => $_SESSION['user_id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="../assets/css/profile.css">

<main class="container">

    <section class="card">

        <h2>👤 Profile</h2>

        <div class="profile-item">
            <span class="label">Amazina Yose</span>
            <span class="value"><?= htmlspecialchars($user['full_name']) ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Izina ry'Ubucuruzi</span>
            <span class="value"><?= htmlspecialchars($user['username']) ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Email</span>
            <span class="value"><?= htmlspecialchars($user['email']) ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Telefone</span>
            <span class="value"><?= htmlspecialchars($user['phone']) ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Akarere</span>
            <span class="value"><?= htmlspecialchars($user['district']) ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Umurenge</span>
            <span class="value"><?= htmlspecialchars($user['sector']) ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Akagari</span>
            <span class="value"><?= htmlspecialchars($user['cell']) ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Aho Ubarizwa</span>
            <span class="value">
                <?= htmlspecialchars($user['address_description']) ?>
            </span>
        </div>

        <a href="edit.php" class="btn">

            <i class="fa-solid fa-pen-to-square"></i>

            Hindura Profile

        </a>

    </section>

</main>

<?php require_once '../includes/footer.php'; ?>