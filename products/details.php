<?php

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$pageTitle = "Ibisobanuro by'Igicuruzwa";
$pageCSS = "../assets/css/product.css";

$id = (int)($_GET['id'] ?? 0);
$from = $_GET['from'] ?? '';

if ($id <= 0) {

    $_SESSION['errors'] = [
        "Igicuruzwa nticyabonetse."
    ];

    header("Location: list.php");
    exit;

}

$sql = "

SELECT
    p.*,
    u.full_name,
    u.username,
    u.phone,
    u.district,
    u.sector,
    u.cell,
    u.address_description

FROM products p

INNER JOIN users u

ON p.user_id = u.id

WHERE p.id = :id

LIMIT 1

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':id' => $id

]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

$canEditProduct = $product && ((int)$product['user_id'] === (int)$_SESSION['user_id']);

if(!$product){

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
 
<main class="container">

<section class="details-card">

<h2>Ibisobanuro by'Igicuruzwa</h2>

<div class="detail-row">

<span class="label">Izina:</span>

<span><?= htmlspecialchars($product['product_name']) ?></span>

</div>

<div class="detail-row">

<span class="label">Igiciro:</span>

<span>

<?= number_format((float)$product['unit_price'],0) ?>

Frw /

<?= htmlspecialchars($product['unit']) ?>

</span>

</div>

<div class="detail-row">

<span class="label">Ingano:</span>

<span>

<?= htmlspecialchars($product['quantity']) ?>

<?= htmlspecialchars($product['unit']) ?>

</span>

</div>

<div class="detail-row">

<span class="label">Discount:</span>

<span><?= htmlspecialchars($product['discount']) ?> %</span>

</div>

<div class="detail-row">

<span class="label">Ibisobanuro:</span>

<span>

<?= nl2br(htmlspecialchars($product['description'])) ?>

</span>

</div>

<hr>

<h3>Amakuru y'Umucuruzi</h3>

<div class="detail-row">

<span class="label">Amazina:</span>

<span><?= htmlspecialchars($product['full_name']) ?></span>

</div>

<div class="detail-row">

<span class="label">Ubucuruzi:</span>

<span><?= htmlspecialchars($product['username']) ?></span>

</div>

<div class="detail-row">

<span class="label">Telefone:</span>

<span>

<a href="tel:<?= htmlspecialchars($product['phone']) ?>">

<?= htmlspecialchars($product['phone']) ?>

</a>

</span>

</div>

<div class="detail-row">

<span class="label">Aho abarizwa:</span>

<span>

<?= htmlspecialchars($product['district']) ?> /

<?= htmlspecialchars($product['sector']) ?> /

<?= htmlspecialchars($product['cell']) ?>

</span>

</div>

<div class="detail-row">

<span class="label">Aderesi:</span>

<span>

<?= htmlspecialchars($product['address_description']) ?>

</span>

</div>

<div class="detail-row">

<span class="label">Byavuguruwe:</span>

<span>

<?= date('d M Y H:i', strtotime($product['updated_at'])) ?>

</span>

</div>

<div class="details-actions">

<?php if ($from === 'search'): ?>

<a href="search.php" class="back-btn">

← Garuka ku isoko

</a>

<?php else: ?>

<a href="list.php" class="back-btn">

← Garuka

</a>

<?php endif; ?>

<?php if ($canEditProduct): ?>

<a

href="edit.php?id=<?= $product['id'] ?>"

class="edit-btn">

Hindura

</a>

<?php endif; ?>

</div>

</section>

</main>

<?php require_once '../includes/footer.php'; ?>