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

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Collect Form Data
|--------------------------------------------------------------------------
*/

$id = (int)($_POST['id'] ?? 0);

$product_name = trim($_POST['product_name'] ?? '');

$unit_price = trim($_POST['unit_price'] ?? '');

$quantity = trim($_POST['quantity'] ?? '');

$unit = trim($_POST['unit'] ?? '');

$discount = trim($_POST['discount'] ?? '0');

$description = trim($_POST['description'] ?? '');

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

$errors = [];

if ($id <= 0) {

    $errors[] = "Igicuruzwa nticyabonetse.";

}

if ($product_name === '') {

    $errors[] = "Andika izina ry'igicuruzwa.";

}

if (!is_numeric($unit_price) || (float)$unit_price <= 0) {

    $errors[] = "Igiciro kigomba kuba kirenze 0.";

}

if (!is_numeric($quantity) || (float)$quantity <= 0) {

    $errors[] = "Ingano igomba kuba irenze 0.";

}

$allowedUnits = [

    'Kg',
    'g',
    'L',
    'ml',
    'Piece',
    'Box',
    'Packet',
    'Dozen',
    'Meter',
    'Roll',
    'Bag'

];

if (!in_array($unit, $allowedUnits, true)) {

    $errors[] = "Hitamo unit yemewe.";

}

if (!is_numeric($discount) || (float)$discount < 0 || (float)$discount > 100) {

    $errors[] = "Discount igomba kuba hagati ya 0 na 100.";

}

if (!empty($errors)) {

    $_SESSION['errors'] = $errors;

    header("Location: edit.php?id=" . $id);

    exit;

}

/*
|--------------------------------------------------------------------------
| Verify Product Ownership
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

        "Ntabwo wemerewe guhindura iki gicuruzwa."

    ];

    header("Location: list.php");

    exit;

}

/*
|--------------------------------------------------------------------------
| Update Product
|--------------------------------------------------------------------------
*/

$sql = "

UPDATE products

SET

product_name = :product_name,

unit_price = :unit_price,

quantity = :quantity,

unit = :unit,

discount = :discount,

description = :description

WHERE

id = :id

AND user_id = :user_id

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':product_name' => $product_name,

    ':unit_price' => (float)$unit_price,

    ':quantity' => (float)$quantity,

    ':unit' => $unit,

    ':discount' => (float)$discount,

    ':description' => $description,

    ':id' => $id,

    ':user_id' => $userId

]);

/*
|--------------------------------------------------------------------------
| Success
|--------------------------------------------------------------------------
*/

$_SESSION['success'] = "Igicuruzwa cyahinduwe neza.";

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: list.php");

exit;