<?php
declare(strict_types=1);
session_start();
?>

<!DOCTYPE html>
<html lang="rw">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Funguza Konti | Ihuriro</title>

    <link rel="stylesheet"
          href="../assets/css/auth.css">

</head>

<body>

<div class="container">

    <div class="logo">
        <h1>IHURIRO</h1>
    </div>

    <div class="card">

        <h2>Funguza Konti</h2>

        <?php if (isset($_SESSION['success'])): ?>

            <div class="alert success">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <?php if (isset($_SESSION['errors'])): ?>

            <div class="alert error">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>

            <?php unset($_SESSION['errors']); ?>

        <?php endif; ?>

        <form action="register_process.php"
              method="POST">

            <div class="form-group">

                <label>Amazina Yose</label>

                <input
                    type="text"
                    name="full_name"
                    placeholder="Andika amazina yose"
                    value="<?= htmlspecialchars($_SESSION['old']['full_name'] ?? '') ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Izina ry'Ubucuruzi</label>

                <input
                    type="text"
                    name="username"
                    placeholder="Urugero: Mugisha Store"
                    value="<?= htmlspecialchars($_SESSION['old']['username'] ?? '') ?>">

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="example@email.com"
                    value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Telefone</label>

                <input
                    type="tel"
                    name="phone"
                    placeholder="078XXXXXXX"
                    value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Akarere</label>

                <input
                    type="text"
                    name="district"
                    value="<?= htmlspecialchars($_SESSION['old']['district'] ?? '') ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Umurenge</label>

                <input
                    type="text"
                    name="sector"
                    value="<?= htmlspecialchars($_SESSION['old']['sector'] ?? '') ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Akagali</label>

                <input
                    type="text"
                    name="cell"
                    value="<?= htmlspecialchars($_SESSION['old']['cell'] ?? '') ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Aho Ubarizwa (Byisumbuyeho)</label>

                <input
                    type="text"
                    name="address_description"
                    placeholder="Urugero: Hafi ya Gare ya Huye"
                    value="<?= htmlspecialchars($_SESSION['old']['address_description'] ?? '') ?>">

            </div>

            <div class="form-group">

                <label>Ijambobanga</label>

                <input
                    type="password"
                    name="password"
                    required>

            </div>

            <div class="form-group">

                <label>Emeza Ijambobanga</label>

                <input
                    type="password"
                    name="confirm_password"
                    required>

            </div>

            <button
                type="submit"
                class="btn">

                Iyandikishe

            </button>

        </form>

        <div class="footer">

            <p>

                Nsanzwe mfite Konti?

                <a href="login.php">

                    Injira

                </a>

            </p>

        </div>

    </div>

</div>

</body>

</html>