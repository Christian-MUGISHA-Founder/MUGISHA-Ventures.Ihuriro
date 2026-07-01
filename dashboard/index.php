<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['user_id'])) {

    header('Location: ../auth/login.php');
    exit;

}
?>

<!DOCTYPE html>
<html lang="rw">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Ihuriro</title>
</head>
<body>

<h2>Murakaza neza, <?= htmlspecialchars($_SESSION['full_name']) ?></h2>

<p>Winjiye neza muri Ihuriro.</p>

<p><a href="../auth/logout.php">Sohoka</a></p>

</body>
</html>