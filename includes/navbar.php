<?php

declare(strict_types=1);

$displayName = !empty($_SESSION['username'])
    ? $_SESSION['username']
    : $_SESSION['full_name'];

?>

<header>

    <div class="header-content">

        <div>

            <h1>IHURIRO</h1>

            <small>

                <?= htmlspecialchars($displayName) ?>

            </small>

        </div>

        <a href="../auth/logout.php">

            <i class="fa-solid fa-right-from-bracket"></i>

            Sohoka

        </a>

    </div>

</header>