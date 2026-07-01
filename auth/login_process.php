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
    header('Location: login.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Collect & Clean Form Data
|--------------------------------------------------------------------------
*/

$login = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

/*
|--------------------------------------------------------------------------
| Save Old Input
|--------------------------------------------------------------------------
*/

$_SESSION['old'] = [
    'login' => $login
];

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

$errors = [];

if ($login === '') {
    $errors[] = "Email cyangwa telefone birakenewe.";
}

if ($password === '') {
    $errors[] = "Ijambobanga rirakenewe.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: login.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Find User By Email OR Phone
|--------------------------------------------------------------------------
*/

$sql = "SELECT *
        FROM users
        WHERE email = :email
           OR phone = :phone
        LIMIT 1";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':email' => $login,
    ':phone' => $login
]);

$user = $stmt->fetch();

/*
|--------------------------------------------------------------------------
| User Not Found
|--------------------------------------------------------------------------
*/

if (!$user) {

    $_SESSION['errors'] = [
        "Email cyangwa telefone ntabwo ibonetse."
    ];

    header('Location: login.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Verify Password
|--------------------------------------------------------------------------
*/

if (!password_verify($password, $user['password'])) {

    $_SESSION['errors'] = [
        "Ijambobanga si ryo."
    ];

    header('Location: login.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Login Successful
|--------------------------------------------------------------------------
*/

session_regenerate_id(true);

/*
|--------------------------------------------------------------------------
| Store Logged-in User
|--------------------------------------------------------------------------
*/

$_SESSION['user_id'] = $user['id'];

$_SESSION['full_name'] = $user['full_name'];

$_SESSION['username'] = $user['username'];

$_SESSION['email'] = $user['email'];

$_SESSION['phone'] = $user['phone'];

$_SESSION['district'] = $user['district'];

$_SESSION['sector'] = $user['sector'];

$_SESSION['cell'] = $user['cell'];

$_SESSION['address_description'] = $user['address_description'];

/*
|--------------------------------------------------------------------------
| Clear Old Input
|--------------------------------------------------------------------------
*/

unset($_SESSION['old']);

/*
|--------------------------------------------------------------------------
| Redirect to Dashboard
|--------------------------------------------------------------------------
*/

header('Location: ../dashboard/index.php');
exit;