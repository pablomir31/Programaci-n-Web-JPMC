<?php
    require "config/auth.php";
    require "config/conexion.php";

    $idUsuario = $_SESSION["id_usuario"];

    // Consultas de conteo según el rol
    if ($_SESSION["rol"] === "administrador") {
        $admin = true;
        // El administrador ve los totales de todo el sistema
        $conTotal = $conexion->prepare("SELECT COUNT(*) AS total FROM libros");
        $conTotal->execute();
        $totalLibros = $conTotal->fetch(PDO::FETCH_ASSOC)["total"];

        $conPendientes = $conexion->prepare("SELECT COUNT(*) AS total FROM libros WHERE estado = ?");
        $conPendientes->execute(["Pendiente"]);
        $pendientes = $conPendientes->fetch(PDO::FETCH_ASSOC)["total"];

        $conLeyendo = $conexion->prepare("SELECT COUNT(*) AS total FROM libros WHERE estado = ?");
        $conLeyendo->execute(["Leyendo"]);
        $leyendo = $conLeyendo->fetch(PDO::FETCH_ASSOC)["total"];

        $conTerminados = $conexion->prepare("SELECT COUNT(*) AS total FROM libros WHERE estado = ?");
        $conTerminados->execute(["Terminado"]);
        $terminados = $conTerminados->fetch(PDO::FETCH_ASSOC)["total"];
    } else {
        $admin = false;
        // El usuario normal ve los totales de sus propios libros
        $conTotal = $conexion->prepare("SELECT COUNT(*) AS total FROM libros WHERE id_usuario = ?");
        $conTotal->execute([$idUsuario]);
        $totalLibros = $conTotal->fetch(PDO::FETCH_ASSOC)["total"];

        $conPendientes = $conexion->prepare("SELECT COUNT(*) AS total FROM libros WHERE id_usuario = ? AND estado = ?");
        $conPendientes->execute([$idUsuario, "Pendiente"]);
        $pendientes = $conPendientes->fetch(PDO::FETCH_ASSOC)["total"];

        $conLeyendo = $conexion->prepare("SELECT COUNT(*) AS total FROM libros WHERE id_usuario = ? AND estado = ?");
        $conLeyendo->execute([$idUsuario, "Leyendo"]);
        $leyendo = $conLeyendo->fetch(PDO::FETCH_ASSOC)["total"];

        $conTerminados = $conexion->prepare("SELECT COUNT(*) AS total FROM libros WHERE id_usuario = ? AND estado = ?");
        $conTerminados->execute([$idUsuario, "Terminado"]);
        $terminados = $conTerminados->fetch(PDO::FETCH_ASSOC)["total"];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/estilos.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Mi Biblioteca</a>
            
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="libros/index.php">Libros</a>
                </li>
            </ul>
            <span class="navbar-text text-white me-3">
                Hola, <?= htmlspecialchars($_SESSION["nombre"]) ?>
            </span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
            
        </div>
    </nav>

    <div class="container">
        <div class="mb-4">
            <h2>Dashboard</h2>
            <p class="text-muted">
                <?= $admin ? "Estadísticas de todos los usuarios registrados." : "Estadísticas de tu colección de libros." ?>
            </p>
        </div>

        <!-- Tarjetas de estadisticas -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-5">
            <div class="col">
                <div class="card shadow-sm card-stat stat-total">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase">Total de Libros</h6>
                        <p class="display-4 fw-bold mb-0"><?= $totalLibros ?></p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-sm card-stat stat-pendiente">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase">Pendientes</h6>
                        <p class="display-4 fw-bold mb-0"><?= $pendientes ?></p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-sm card-stat stat-leyendo">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase">Leyendo</h6>
                        <p class="display-4 fw-bold mb-0"><?= $leyendo ?></p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-sm card-stat stat-terminado">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase">Terminados</h6>
                        <p class="display-4 fw-bold mb-0"><?= $terminados ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfica de estados -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">Estatus de libros</h5>
                        <canvas id="graficaLibros"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('graficaLibros'), {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'Leyendo', 'Terminados'],
                datasets: [{
                    data: [<?= $pendientes ?>, <?= $leyendo ?>, <?= $terminados ?>],
                    backgroundColor: [
                        '#f59e0b',
                        '#2a8780',
                        '#16a34a'
                    ],
                    borderWidth: 2
                }]
            }
        });
    </script>
</body>
</html>