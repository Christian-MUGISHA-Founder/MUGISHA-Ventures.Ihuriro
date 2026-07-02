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

    header('Location: add.php');
    exit;

}

/*
|--------------------------------------------------------------------------
| Ensure User Is Logged In
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_id'])) {

    header('Location: ../auth/login.php');
    exit;

}

/*
|--------------------------------------------------------------------------
| Collect Form Data
|--------------------------------------------------------------------------
*/

$product_name = trim($_POST['product_name'] ?? '');
$unit_price = trim($_POST['unit_price'] ?? '');
$quantity = trim($_POST['quantity'] ?? '');
$unit = trim($_POST['unit'] ?? '');
$discount_info = trim($_POST['discount_info'] ?? '');

$user_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Preserve Old Input
|--------------------------------------------------------------------------
*/

$_SESSION['old'] = $_POST;

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

$errors = [];

if ($product_name === '') {

    $errors[] = "Izina ry'igicuruzwa rirakenewe.";

}

if ($unit_price === '') {

    $errors[] = "Igiciro kirakenewe.";

} elseif (!is_numeric($unit_price) || $unit_price < 0) {

    $errors[] = "Igiciro ntabwo cyemewe.";

}

if ($quantity === '') {

    $errors[] = "Ingano irakenewe.";

} elseif (!is_numeric($quantity) || $quantity < 0) {

    $errors[] = "Ingano ntabwo yemewe.";

}

if ($unit === '') {

    $errors[] = "Hitamo unit.";

}

/*
|--------------------------------------------------------------------------
| Stop If Validation Failed
|--------------------------------------------------------------------------
*/

if (!empty($errors)) {

    $_SESSION['errors'] = $errors;

    header("Location: add.php");

    exit;

}

/*
|--------------------------------------------------------------------------
| Save Product
|--------------------------------------------------------------------------
*/

$sql = "

INSERT INTO products
(
    user_id,
    product_name,
    unit_price,
    quantity,
    unit,
    discount_info
)

VALUES
(
    :user_id,
    :product_name,
    :unit_price,
    :quantity,
    :unit,
    :discount_info
)

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':user_id' => $user_id,

    ':product_name' => $product_name,

    ':unit_price' => $unit_price,

    ':quantity' => $quantity,

    ':unit' => $unit,

    ':discount_info' => $discount_info

]);

/*
|--------------------------------------------------------------------------
| Clear Old Input
|--------------------------------------------------------------------------
*/

unset($_SESSION['old']);
unset($_SESSION['errors']);

/*
|--------------------------------------------------------------------------
| Success Message
|--------------------------------------------------------------------------
*/

$_SESSION['success'] = "Igicuruzwa cyongeweho neza.";

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: list.php");

exit;