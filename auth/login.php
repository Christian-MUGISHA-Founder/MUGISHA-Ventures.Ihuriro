<?php

declare(strict_types=1);

session_start();

/*
|--------------------------------------------------------------------------
| Redirect If Already Logged In
|--------------------------------------------------------------------------
*/

if (isset($_SESSION['user_id'])) {

    header("Location: ../dashboard/index.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="rw">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Injira | Ihuriro</title>

    <link rel="stylesheet"
          href="../assets/css/auth.css">

</head>

<body>

<div class="container">

    <div class="logo">

        <h1>IHURIRO</h1>

    </div>

    <div class="card">

        <h2>Injira</h2>

        <!-- Success Messages -->

        <?php if (isset($_SESSION['success'])): ?>

            <div class="alert success">

                <?= htmlspecialchars($_SESSION['success']) ?>

            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>


        <!-- Error Messages -->

        <?php if (isset($_SESSION['errors'])): ?>

            <div class="alert error">

                <?php foreach ($_SESSION['errors'] as $error): ?>

                    <p><?= htmlspecialchars($error) ?></p>

                <?php endforeach; ?>

            </div>

            <?php unset($_SESSION['errors']); ?>

        <?php endif; ?>


        <form
            action="login_process.php"
            method="POST">

            <div class="form-group">

                <label>Email cyangwa Telefone</label>

                <input
                    type="text"
                    name="login"
                    placeholder="Andika email cyangwa telefone"
                    value="<?= htmlspecialchars($_SESSION['old']['login'] ?? '') ?>"
                    required>

            </div>


            <div class="form-group">

                <label>Ijambobanga</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Andika ijambobanga"
                    required>

            </div>


            <button
                type="submit"
                class="btn">

                Injira

            </button>

        </form>

        <div class="footer">

            <p>

                Nta Konti mfite?

                <a href="register.php">

                    Iyandikishe

                </a>

            </p>

        </div>

    </div>

</div>

</body>

</html>

<?php

unset($_SESSION['old']);

?>