<?php

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$pageTitle = "Isoko | Ihuriro";
$pageCSS = "../assets/css/product.css";

$keyword = trim($_GET['keyword'] ?? '');
$sort = $_GET['sort'] ?? '';
$near = $_GET['near'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 8;
$offset = ($page - 1) * $perPage;

$params = [];
$where = " WHERE 1=1 ";

if ($keyword !== '') {
    $where .= "
        AND (
            p.product_name LIKE :k1
            OR u.username LIKE :k2
            OR u.district LIKE :k3
            OR u.sector LIKE :k4
            OR u.cell LIKE :k5
            OR p.description LIKE :k6
        )
    ";

    $searchValue = "%{$keyword}%";
    $params[':k1'] = $searchValue;
    $params[':k2'] = $searchValue;
    $params[':k3'] = $searchValue;
    $params[':k4'] = $searchValue;
    $params[':k5'] = $searchValue;
    $params[':k6'] = $searchValue;
}

$where .= " AND p.user_id != :current_user ";
$params[':current_user'] = $_SESSION['user_id'];

if ($near !== '') {
    $me = $pdo->prepare("SELECT district, sector, cell FROM users WHERE id = :id");
    $me->execute([':id' => $_SESSION['user_id']]);
    $myLocation = $me->fetch(PDO::FETCH_ASSOC);

    if ($myLocation) {
        if ($near === 'district') {
            $where .= " AND u.district = :district ";
            $params[':district'] = $myLocation['district'];
        } elseif ($near === 'sector') {
            $where .= " AND u.sector = :sector ";
            $params[':sector'] = $myLocation['sector'];
        } elseif ($near === 'cell') {
            $where .= " AND u.cell = :cell ";
            $params[':cell'] = $myLocation['cell'];
        }
    }
}

$orderBy = " ORDER BY p.updated_at DESC ";

switch ($sort) {
    case 'cheap':
        $orderBy = " ORDER BY p.unit_price ASC ";
        break;

    case 'expensive':
        $orderBy = " ORDER BY p.unit_price DESC ";
        break;

    case 'latest':
        $orderBy = " ORDER BY p.updated_at DESC ";
        break;

    case 'name':
        $orderBy = " ORDER BY p.product_name ASC ";
        break;
}

$countSql = "
    SELECT COUNT(*) AS total
    FROM products p
    JOIN users u ON p.user_id = u.id
    {$where}
";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$total = (int)$countStmt->fetch()['total'];
$totalPages = max(1, (int)ceil($total / $perPage));

$sql = "
    SELECT
        p.*,
        u.full_name,
        u.username,
        u.phone,
        u.district,
        u.sector,
        u.cell
    FROM products p
    JOIN users u ON p.user_id = u.id
    {$where}
    {$orderBy}
    LIMIT {$perPage}
    OFFSET {$offset}
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$hasActiveSearch = $keyword !== '' || $sort !== '' || $near !== '';
$showFullPagination = $hasActiveSearch || $totalPages <= 5;

$visiblePages = [];

if ($showFullPagination) {
    for ($i = 1; $i <= $totalPages; $i++) {
        $visiblePages[] = $i;
    }
} else {
    $startPage = max(1, $page - 2);
    $endPage = min($totalPages, $startPage + 4);

    if ($endPage - $startPage + 1 < 5) {
        $startPage = max(1, $endPage - 4);
    }

    for ($i = $startPage; $i <= $endPage; $i++) {
        $visiblePages[] = $i;
    }
}

$sortLabel = '';

switch ($sort) {
    case 'cheap':
        $sortLabel = 'Igiciro gito mbere';
        break;

    case 'expensive':
        $sortLabel = 'Igiciro kinini mbere';
        break;

    case 'latest':
        $sortLabel = 'Byavuguruwe vuba';
        break;

    case 'name':
        $sortLabel = 'A → Z';
        break;
}

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="../assets/css/product.css">

<main class="container">
    <section class="search-card">
        <h2>🔎 Shakisha ku Isoko</h2>

        <p class="search-description">
            Shakisha ibicuruzwa biri ku isoko ry'abandi bacuruzi.
        </p>

        <form action="search.php" method="GET">
            <input
                type="text"
                name="keyword"
                placeholder="Andika izina ry'igicuruzwa, umucuruzi cyangwa ahantu..."
                value="<?= htmlspecialchars($keyword) ?>">

            <div class="filter-row">
                <div class="filter-group">
                    <label for="sort">Shungura</label>
                    <select name="sort" id="sort">
                        <option value="">-- Hitamo --</option>
                        <option value="cheap" <?= $sort === 'cheap' ? 'selected' : '' ?>>Igiciro gito mbere</option>
                        <option value="expensive" <?= $sort === 'expensive' ? 'selected' : '' ?>>Igiciro kinini mbere</option>
                        <option value="latest" <?= $sort === 'latest' ? 'selected' : '' ?>>Byavuguruwe vuba</option>
                        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>A → Z</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="near">Aho ushakira</label>
                    <select name="near" id="near">
                        <option value="" <?= $near === '' ? 'selected' : '' ?>>Hose</option>
                        <option value="district" <?= $near === 'district' ? 'selected' : '' ?>>Mu Karere kanjye</option>
                        <option value="sector" <?= $near === 'sector' ? 'selected' : '' ?>>Mu Murenge wanjye</option>
                        <option value="cell" <?= $near === 'cell' ? 'selected' : '' ?>>Mu Kagari kanjye</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn">🔍 Shakisha</button>
        </form>
    </section>

    <?php if ($keyword !== '' || $sort !== '' || $near !== ''): ?>
        <section class="search-summary">
            <p>
                <?php
                $summaryParts = [];

                if ($keyword !== '') {
                    $summaryParts[] = 'Ishakisha: ' . htmlspecialchars($keyword);
                }

                if ($sortLabel !== '') {
                    $summaryParts[] = $sortLabel;
                }

                if ($near === 'district') {
                    $summaryParts[] = 'Aho: Umurenge wo mu Karere kanjye';
                } elseif ($near === 'sector') {
                    $summaryParts[] = 'Aho: Umurenge wanjye';
                } elseif ($near === 'cell') {
                    $summaryParts[] = 'Aho: Akagari kanjye';
                }
                ?>

                <?= implode(' • ', $summaryParts) ?>
            </p>
        </section>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <section class="search-results">
            <div class="empty">
                <h3>Nta bisubizo biragaragara.</h3>
                <p>
                    Andika icyo ushaka hejuru hanyuma ukande
                    <strong>"Shakisha"</strong>.
                </p>
            </div>
        </section>
    <?php else: ?>
        <section class="search-results">
            <?php foreach ($products as $product): ?>
                <article class="card product-card search-product-card">
                    <div class="search-product-header">
                        <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                        <span class="price-badge">
                            <?= number_format((float)$product['unit_price'], 0) ?> Frw / <?= htmlspecialchars($product['unit']) ?>
                        </span>
                    </div>

                    <p>
                        <strong>Ingano:</strong>
                        <?= number_format((float)$product['quantity'], 2) ?> <?= htmlspecialchars($product['unit']) ?>
                    </p>

                    <?php if ((float)$product['discount'] > 0): ?>
                        <p>
                            <strong>Discount:</strong>
                            <?= (float)$product['discount'] ?> %
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($product['description'])): ?>
                        <p>
                            <strong>Ibisobanuro:</strong>
                            <?= nl2br(htmlspecialchars($product['description'])) ?>
                        </p>
                    <?php endif; ?>

                    <p class="seller-meta">
                        <strong>Umucuruzi:</strong>
                        <?= htmlspecialchars($product['username']) ?>
                        ·
                        <strong>Aho:</strong>
                        <?= htmlspecialchars($product['district']) ?> /
                        <?= htmlspecialchars($product['sector']) ?> /
                        <?= htmlspecialchars($product['cell']) ?>
                    </p>

                    <div class="actions">
                        <a href="details.php?id=<?= (int)$product['id'] ?>&from=search" class="edit-btn">Reba byinshi</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?keyword=<?= urlencode($keyword) ?>&sort=<?= urlencode($sort) ?>&near=<?= urlencode($near) ?>&page=<?= $page - 1 ?>">‹</a>
            <?php endif; ?>

            <?php foreach ($visiblePages as $pageNumber): ?>
                <a href="?keyword=<?= urlencode($keyword) ?>&sort=<?= urlencode($sort) ?>&near=<?= urlencode($near) ?>&page=<?= $pageNumber ?>" class="<?= $pageNumber === $page ? 'active' : '' ?>">
                    <?= $pageNumber ?>
                </a>
            <?php endforeach; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?keyword=<?= urlencode($keyword) ?>&sort=<?= urlencode($sort) ?>&near=<?= urlencode($near) ?>&page=<?= $page + 1 ?>">›</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once '../includes/footer.php'; ?>