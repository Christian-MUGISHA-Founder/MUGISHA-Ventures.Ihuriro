<?php

declare(strict_types=1);

require_once '../includes/auth.php';

$displayName = !empty($_SESSION['username'])
    ? $_SESSION['username']
    : $_SESSION['full_name'];
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

        <form action="../products/search.php" method="GET">

            <input
                type="text"
                name="keyword"
                placeholder="Urugero: Isukari">

            <button
                class="btn"
                type="submit">

                Shaka

            </button>

        </form>

        <div class="filters">

            <button class="filter">

                Hafi Yanjye

            </button>

            <button class="filter">

                Igiciro Gito

            </button>

        </div>

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

        <!-- Search own stock -->

        <form action="../products/list.php" method="GET">

            <input
                type="text"
                name="my_product"
                placeholder="Shakisha mu bicuruzwa byawe">

        </form>

        <div class="product">

            <h4>Nta Gicuruzwa Kirashyirwaho</h4>

            <p>

                Ongeraho igicuruzwa cya mbere.

            </p>

        </div>

    </section>

</main>

<!-- ============== FOOTER INFO ============== -->
<!-- ============== BOTTOM NAVIGATION ============== -->

<?php require_once '../includes/footer.php'; ?>


</body>

</html>