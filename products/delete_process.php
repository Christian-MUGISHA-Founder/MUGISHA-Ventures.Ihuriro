<?php

declare(strict_types=1);

session_start();

require_once '../config/database.php';

/*
|--------------------------------------------------------------------------
| Allow POST Requests Only
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: list.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Ensure User Is Logged In
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_id'])) {

    header("Location: ../auth/login.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Validate Product ID
|--------------------------------------------------------------------------
*/

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {

    $_SESSION['errors'] = [
        "Igicuruzwa nticyabonetse."
    ];

    header("Location: list.php");
    exit;

}

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Verify Ownership
|--------------------------------------------------------------------------
*/

$sql = "

SELECT id

FROM products

WHERE

id = :id

AND user_id = :user_id

LIMIT 1

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':id' => $id,

    ':user_id' => $userId

]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {

    $_SESSION['errors'] = [
        "Ntabwo wemerewe gusiba iki gicuruzwa."
    ];

    header("Location: list.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Delete Product
|--------------------------------------------------------------------------
*/

$sql = "

DELETE FROM products

WHERE id = :id

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':id' => $id

]);

/*
|--------------------------------------------------------------------------
| Success Message
|--------------------------------------------------------------------------
*/

$_SESSION['success'] = "Igicuruzwa cyasibwe neza.";

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: list.php");

exit;