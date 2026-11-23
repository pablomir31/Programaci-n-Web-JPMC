<?php
    session_start();
    $error = $_SESSION["error"] ?? "";
    unset($_SESSION["error"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
</head>
<body>

    <div class="container d-flex vh-100 align-items-center justify-content-center">
        <div class="w-50 justify-content-center">
            <div class="card border border-success border-3 rounded-4 p-4">
                <div class="card-body">
                    <h1 class="card-title text-center h3 mb-3">Inicio de sesión</h1>

                    <?php if ($error != ""): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form action="procesar.php" method="post">
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Ingresar</button>
                        </div>
                    </form>
                    <div class="card-footer">
                        <p class="text-center mb-0">¿No tienes cuenta? <a href="registro.php" class="theme-primary underline-offset-2 underline-20 hover:underline-100">Registrate</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>