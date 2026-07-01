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

    header('Location: edit.php');
    exit;

}

/*
|--------------------------------------------------------------------------
| Collect & Clean Input
|--------------------------------------------------------------------------
*/

$full_name = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$district = trim($_POST['district'] ?? '');
$sector = trim($_POST['sector'] ?? '');
$cell = trim($_POST['cell'] ?? '');
$address_description = trim($_POST['address_description'] ?? '');

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Save Old Input
|--------------------------------------------------------------------------
*/

$_SESSION['old'] = $_POST;

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

$errors = [];

if ($full_name === '') {
    $errors[] = "Amazina yose arakenewe.";
}

if ($email === '') {
    $errors[] = "Email irakenewe.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email ntabwo ari yo.";
}

if ($phone === '') {
    $errors[] = "Telefone irakenewe.";
}

if ($district === '') {
    $errors[] = "Akarere karakenewe.";
}

if ($sector === '') {
    $errors[] = "Umurenge urakenewe.";
}

if ($cell === '') {
    $errors[] = "Akagari karakenewe.";
}

if ($address_description === '') {
    $errors[] = "Aho ubarizwa harakenewe.";
}

if (!empty($errors)) {

    $_SESSION['errors'] = $errors;

    header("Location: edit.php");

    exit;

}

/*
|--------------------------------------------------------------------------
| Check Duplicate Email or Phone
|--------------------------------------------------------------------------
*/

$sql = "

SELECT id

FROM users

WHERE

(email = :email OR phone = :phone)

AND id <> :id

LIMIT 1

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':email' => $email,

    ':phone' => $phone,

    ':id' => $userId

]);

if ($stmt->fetch()) {

    $_SESSION['errors'] = [

        "Email cyangwa telefone bisanzwe bifitwe n'undi mucuruzi."

    ];

    header("Location: edit.php");

    exit;

}

/*
|--------------------------------------------------------------------------
| Update User
|--------------------------------------------------------------------------
*/

$sql = "

UPDATE users

SET

full_name = :full_name,

username = :username,

email = :email,

phone = :phone,

district = :district,

sector = :sector,

cell = :cell,

address_description = :address_description

WHERE id = :id

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':full_name' => $full_name,

    ':username' => $username,

    ':email' => $email,

    ':phone' => $phone,

    ':district' => $district,

    ':sector' => $sector,

    ':cell' => $cell,

    ':address_description' => $address_description,

    ':id' => $userId

]);

/*
|--------------------------------------------------------------------------
| Refresh Session
|--------------------------------------------------------------------------
*/

$_SESSION['full_name'] = $full_name;
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
$_SESSION['district'] = $district;
$_SESSION['sector'] = $sector;
$_SESSION['cell'] = $cell;
$_SESSION['address_description'] = $address_description;

/*
|--------------------------------------------------------------------------
| Success Message
|--------------------------------------------------------------------------
*/

unset($_SESSION['old']);

$_SESSION['success'] = "Profile yawe yahinduwe neza.";

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: profile.php");

exit;