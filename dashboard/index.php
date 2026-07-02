<?php

declare(strict_types=1);

require_once '../includes/auth.php';
require_once '../config/database.php';

$displayName = !empty($_SESSION['username'])
    ? $_SESSION['username']
    : $_SESSION['full_name'];

$userId = (int)$_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id, product_name, unit_price, quantity, unit, discount, updated_at FROM products WHERE user_id = :user_id ORDER BY updated_at DESC LIMIT 5");
$stmt->execute([':user_id' => $userId]);
$userProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="rw">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Ihuriro</title>

    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<!-- ================= HEADER ================= -->

<?php
require_once '../includes/auth.php';

$pageTitle = "...";

require_once '../includes/header.php';

require_once '../includes/navbar.php';
?>



<!-- ================= MAIN ================= -->

<main class="container">

    <!-- Welcome -->

    <section class="card">

        <h2>Murakaza neza 👋</h2>

        <h3><?= htmlspecialchars($displayName) ?></h3>

        <p>

            <?= htmlspecialchars($_SESSION['district']) ?>,

            <?= htmlspecialchars($_SESSION['sector']) ?>

        </p>

    </section>

    <!-- Market Search -->

    <section class="card">

        <h3>Shakisha Ku Isoko</h3>

        <form action="../products/search.php" method="GET" class="search-form">

            <input
                type="text"
                name="keyword"
                placeholder="Urugero: Isukari"
                autocomplete="off">

            <div class="filters">

                <button class="filter" type="submit" name="near" value="district">

                    Hafi Yanjye

                </button>

                <button class="filter" type="submit" name="sort" value="cheap">

                    Igiciro Gito

                </button>

            </div>

            <button
                class="btn search-btn"
                type="submit">

                <i class="fa-solid fa-magnifying-glass"></i>
                Shaka

            </button>

        </form>

    </section>

    <!-- Add Product -->

    <section class="card">

        <a
            href="../products/add.php"
            class="btn">

            <i class="fa-solid fa-plus"></i>

            Ongeraho Igicuruzwa

        </a>

    </section>

    <!-- My Products -->

    <section class="card">

        <h3>Ibicuruzwa Byanjye</h3>

        <form action="../products/list.php" method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Shakisha mu bicuruzwa byawe"
                autocomplete="off">

            <button class="btn search-btn" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
                Shaka
            </button>

        </form>

        <?php if (empty($userProducts)): ?>

            <div class="product">

                <h4>Nta Gicuruzwa Kirashyirwaho</h4>

                <p>

                    Ongeraho igicuruzwa cya mbere.

                </p>

            </div>

        <?php else: ?>

            <?php foreach ($userProducts as $product): ?>

                <div class="product">

                    <h4><?= htmlspecialchars($product['product_name']) ?></h4>

                    <p>
                        <strong>Igiciro:</strong>
                        <?= number_format((float)$product['unit_price'], 0) ?> Frw / <?= htmlspecialchars($product['unit']) ?>
                    </p>

                    <p>
                        <strong>Ingano:</strong>
                        <?= number_format((float)$product['quantity'], 2) ?> <?= htmlspecialchars($product['unit']) ?>
                    </p>

                    <p>
                        <a href="../products/details.php?id=<?= (int)$product['id'] ?>" class="link-btn">Reba byinshi</a>
                    </p>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </section>

</main>

<!-- ============== FOOTER INFO ============== -->
<!-- ============== BOTTOM NAVIGATION ============== -->

<?php require_once '../includes/footer.php'; ?>


</body>

</html>