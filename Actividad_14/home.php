<?php
    session_start();

    if(!isset($_SESSION["usuario"])){
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex vh-100 align-items-center justify-content-center">
        <div class="card border border-success border-3 rounded-4 p-4">
            <div class="card-body">
                <h1>Bienvenido <?= htmlspecialchars($_SESSION["usuario"]); ?></h1>
                <p>Has iniciado sesión correctamente.</p>
            </div>
            <div class="card-footer">
                <a href="logout.php" class="theme-primary underline-offset-2 underline-20 hover:underline-100">Cerrar Sesión</a>
            </div>
        </div>
    </div>

    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</body>
</html>