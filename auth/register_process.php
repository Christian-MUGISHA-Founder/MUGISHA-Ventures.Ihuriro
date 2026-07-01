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
    header('Location: register.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Collect Form Data
|--------------------------------------------------------------------------
*/

$fullName = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$district = trim($_POST['district'] ?? '');
$sector = trim($_POST['sector'] ?? '');
$cell = trim($_POST['cell'] ?? '');

$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$addressDescription = trim($_POST['address_description'] ?? '');

/*
|--------------------------------------------------------------------------
| Save Old Inputs
|--------------------------------------------------------------------------
*/

$_SESSION['old'] = [

    'full_name' => $fullName,
    'username' => $username,
    'email' => $email,
    'phone' => $phone,
    'district' => $district,
    'sector' => $sector,
    'cell' => $cell
    'address_description' => $addressDescription

];

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

$errors = [];

/*
|--------------------------------------------------------------------------
| Required Fields
|--------------------------------------------------------------------------
*/

if ($fullName === '') {
    $errors[] = "Amazina yose arakenewe.";
}

if ($email === '') {
    $errors[] = "Email irakenewe.";
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
    $errors[] = "Akagali karakenewe.";
}

if ($password === '') {
    $errors[] = "Ijambobanga rirakenewe.";
}

if ($confirmPassword === '') {
    $errors[] = "Emeza ijambobanga.";
}

/*
|--------------------------------------------------------------------------
| Email Validation
|--------------------------------------------------------------------------
*/

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email ntabwo ari yo.";
}

/*
|--------------------------------------------------------------------------
| Password Validation
|--------------------------------------------------------------------------
*/

if ($password !== '' && strlen($password) < 8) {
    $errors[] = "Ijambobanga rigomba kuba nibura inyuguti 8.";
}

if ($password !== $confirmPassword) {
    $errors[] = "Amagambo banga ntabwo ahura.";
}

/*
|--------------------------------------------------------------------------
| Duplicate Email / Phone
|--------------------------------------------------------------------------
*/

if (empty($errors)) {

    $sql = "SELECT id
            FROM users
            WHERE email = :email
               OR phone = :phone
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([

        ':email' => $email,
        ':phone' => $phone

    ]);

    if ($stmt->fetch()) {
        $errors[] = "Email cyangwa telefone isanzwe ikoreshwa.";
    }
}

/*
|--------------------------------------------------------------------------
| Return Back If Errors Exist
|--------------------------------------------------------------------------
*/

if (!empty($errors)) {

    $_SESSION['errors'] = $errors;

    header('Location: register.php');

    exit;
}

/*
|--------------------------------------------------------------------------
| Hash Password
|--------------------------------------------------------------------------
*/

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

/*
|--------------------------------------------------------------------------
| Insert User
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO users (

            full_name,
            username,
            email,
            phone,
            district,
            sector,
            cell,
            address_description,
            password

        )

        VALUES (

            :full_name,
            :username,
            :email,
            :phone,
            :district,
            :sector,
            :cell,
            :address_description,
            :password

        )";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':full_name' => $fullName,
    ':username' => $username,
    ':email' => $email,
    ':phone' => $phone,
    ':district' => $district,
    ':sector' => $sector,
    ':cell' => $cell,
    ':address_description' => $addressDescription,,
    ':password' => $passwordHash

]);

/*
|--------------------------------------------------------------------------
| Registration Successful
|--------------------------------------------------------------------------
*/

unset($_SESSION['old']);

$_SESSION['success'] = "Konti yawe yafunguwe neza. Injira.";

header('Location: login.php');

exit;