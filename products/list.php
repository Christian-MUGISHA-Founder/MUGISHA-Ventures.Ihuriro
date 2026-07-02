<?php

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$pageTitle = "Ibicuruzwa Byanjye | Ihuriro";

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

$keyword = trim($_GET['search'] ?? '');

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

$perPage = 10;

$page = max(1, (int)($_GET['page'] ?? 1));

$offset = ($page - 1) * $perPage;

/*
|--------------------------------------------------------------------------
| Count Products
|--------------------------------------------------------------------------
*/

$countSql = "

SELECT COUNT(*)

FROM products

WHERE user_id = :user_id

";

$countParams = [

    ':user_id' => $userId

];

if ($keyword !== '') {

    $countSql .= "

    AND product_name LIKE :keyword

    ";

    $countParams[':keyword'] = "%{$keyword}%";

}

$countStmt = $pdo->prepare($countSql);

$countStmt->execute($countParams);

$totalProducts = (int)$countStmt->fetchColumn();

$totalPages = max(1, (int)ceil($totalProducts / $perPage));

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

$sql = "

SELECT *

FROM products

WHERE user_id = :user_id

";

$params = [

    ':user_id' => $userId

];

if ($keyword !== '') {

    $sql .= "

    AND product_name LIKE :keyword

    ";

    $params[':keyword'] = "%{$keyword}%";

}

$sql .= "

ORDER BY updated_at DESC

LIMIT {$perPage}

OFFSET {$offset}

";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="../assets/css/product.css">

<main class="container">

<section class="card">

<h2>Ibicuruzwa Byanjye</h2>

<form method="GET">

<input

type="text"

name="search"

placeholder="Shakisha igicuruzwa..."

value="<?= htmlspecialchars($keyword) ?>">

</form>

</section>

<?php if(isset($_SESSION['success'])): ?>

<div class="success">

<?= htmlspecialchars($_SESSION['success']) ?>

</div>

<?php unset($_SESSION['success']); endif; ?>

<?php if(empty($products)): ?>

<section class="card empty">

<h3>Nta gicuruzwa kiraboneka.</h3>

<p>Ongeraho igicuruzwa cya mbere.</p>

<a href="add.php" class="btn">

+ Ongeraho Igicuruzwa

</a>

</section>

<?php endif; ?>

<!-- Add Product -->

<section class="card">

    <a
        href="../products/add.php"
        class="btn">

        <i class="fa-solid fa-plus"></i>

        Ongeraho Igicuruzwa

    </a>

</section>

<?php foreach($products as $product): ?>

<section class="card product-card">

<h3>

<?= htmlspecialchars($product['product_name']) ?>

</h3>

<p>

<strong>Ingano:</strong>


<?= number_format((float)$product['quantity'], 2) ?>

</p>

<p>

<strong>Igiciro:</strong>

<?= number_format((float)$product['unit_price'], 0) ?>

Frw /

<?= htmlspecialchars($product['unit']) ?>

</p>

<?php if($product['discount'] > 0): ?>

<p>

<strong>Discount:</strong>

<?= $product['discount'] ?> %

</p>

<?php endif; ?>

<?php if(!empty($product['description'])): ?>

<p>

<strong>Ibisobanuro:</strong>

<?= nl2br(htmlspecialchars($product['description'])) ?>

</p>

<?php endif; ?>

<p>

<strong>Byavuguruwe:</strong>

<?= date('d M Y', strtotime($product['updated_at'])) ?>

</p>

<div class="actions">

<a

href="edit.php?id=<?= $product['id'] ?>"

class="edit-btn">

Hindura

</a>

<a

href="delete.php?id=<?= $product['id'] ?>"

class="delete-btn">

Siba

</a>

</div>

</section>

<?php endforeach; ?>

<?php if($totalPages > 1): ?>

<div class="pagination">

<?php for($i=1;$i<=$totalPages;$i++): ?>

<a

href="?page=<?= $i ?>&search=<?= urlencode($keyword) ?>"

class="<?= $page==$i ? 'active' : '' ?>">

<?= $i ?>

</a>

<?php endfor; ?>

</div>

<?php endif; ?>

</main>

<?php require_once '../includes/footer.php'; ?>