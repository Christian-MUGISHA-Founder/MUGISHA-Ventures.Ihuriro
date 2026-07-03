<?php

$currentFile = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$currentDir = basename(dirname($_SERVER['PHP_SELF'] ?? 'dashboard/index.php'));

$activePage = 'dashboard';

if ($currentDir === 'products') {
    $activePage = ($currentFile === 'add.php' || $currentFile === 'add_process.php') ? 'add' : 'search';
} elseif ($currentDir === 'profile') {
    $activePage = 'profile';
}

?>

<footer>

    <a href="../dashboard/index.php" class="footer-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">

        <i class="fa-solid fa-house"></i>

        <span>Ahabanza</span>

    </a>

    <a href="../products/search.php" class="footer-link <?= $activePage === 'search' ? 'active' : '' ?>">

        <i class="fa-solid fa-magnifying-glass"></i>

        <span>Isoko</span>

    </a>

    <a href="../products/add.php" class="footer-link <?= $activePage === 'add' ? 'active' : '' ?>">

        <i class="fa-solid fa-circle-plus"></i>

        <span>Ongeraho</span>

    </a>

    <a href="../profile/profile.php" class="footer-link <?= $activePage === 'profile' ? 'active' : '' ?>">

        <i class="fa-solid fa-user"></i>

        <span>Profile</span>

    </a>

</footer>

<div class="footer-info">

    MUGISHA Ventures |
    <strong>IHURIRO</strong> |
    2026

</div>

</body>

</html>