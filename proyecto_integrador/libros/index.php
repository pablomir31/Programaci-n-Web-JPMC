<?php
    require "../config/auth.php";
    require "../config/conexion.php";

    $busqueda = $_GET["buscar"] ?? "";

    if($_SESSION["rol"] === "administrador") {
        // El administrador ve TODOS los libros
        $admin = true;
        $sql = "SELECT * FROM libros WHERE titulo LIKE ? ORDER BY id_libro DESC";
        $consulta = $conexion->prepare($sql);
        $consulta->execute(["%" . $busqueda . "%"]);
    } else {
        // El usuario ve SOLO sus propios libros
        $admin = false;
        $sql = "SELECT * FROM libros WHERE id_usuario = ? AND titulo LIKE ? ORDER BY id_libro DESC";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$_SESSION["id_usuario"], "%" . $busqueda . "%"]);
    }

    $libros = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="../dashboard.php">Mi Biblioteca</a>
            
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Libros</a>
                </li>
            </ul>
            <span class="navbar-text text-white me-3">
                Hola, <?= htmlspecialchars($_SESSION["nombre"]) ?>
            </span>
            <a href="../logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container">
        <!-- Encabezado y botón de agregar -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><?= $admin ? "Panel de libros" : "Mis libros" ?></h2>
            <a href="crear.php" class="btn btn-success">Registrar libro</a>
        </div>

        <!-- Barra de busqueda -->
        <form method="GET" class="d-flex mb-4">
            <input type="text" name="buscar" class="form-control me-2" 
                   placeholder="Buscar..." 
                   value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <?php if ($busqueda !== ""): ?>
                <a href="index.php" class="btn btn-secondary ms-2">Limpiar</a>
            <?php endif; ?>
        </form>

        <!-- Mensaje si no hay resultados -->
        <?php if (empty($libros)): ?>
            <div class="alert alert-info">No se encontraron libros registrados.</div>
        <?php endif; ?>

        <!-- Tabla para el administrador -->
        <?php if ($admin && !empty($libros)): ?>
            <div class="table-responsive bg-white p-3 rounded shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Género</th>
                            <th>Año</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($libros as $libro): ?>
                            <tr>
                                <td><?= htmlspecialchars($libro["titulo"]) ?></td>
                                <td><?= htmlspecialchars($libro["autor"]) ?></td>
                                <td><?= htmlspecialchars($libro["genero"]) ?></td>
                                <td><?= htmlspecialchars($libro["anio"]) ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($libro["estado"]) ?></span>
                                </td>
                                <td>
                                    <!-- Botón para editar -->
                                    <a href="editar.php?id=<?= $libro["id_libro"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    
                                    <!-- Botón para eliminar -->
                                    <form action="eliminar.php" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este libro?');">
                                        <input type="hidden" name="id_libro" value="<?= $libro["id_libro"] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <!-- Se ven como tarjetas si es un usuario -->
        <?php elseif (!$admin && !empty($libros)): ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($libros as $libro): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body card-libro">
                                <span class="badge bg-primary mb-2"><?= htmlspecialchars($libro["estado"]) ?></span>
                                <h5 class="card-title"><?= htmlspecialchars($libro["titulo"]) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($libro["autor"]) ?></p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                                <!-- Botón que abre el modal de detalles -->
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalLibro<?= $libro["id_libro"] ?>">
                                    Ver detalles
                                </button>
                                <a href="editar.php?id=<?= $libro["id_libro"] ?>" class="btn btn-warning btn-sm">Editar</a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal individual para ver información extra del libro -->
                    <div class="modal fade" id="modalLibro<?= $libro["id_libro"] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= htmlspecialchars($libro["titulo"]) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Autor:</strong> <?= htmlspecialchars($libro["autor"]) ?></p>
                                    <p><strong>Género:</strong> <?= htmlspecialchars($libro["genero"]) ?></p>
                                    <p><strong>Año de publicación:</strong> <?= htmlspecialchars($libro["anio"]) ?></p>
                                    <p><strong>Estado:</strong> <?= htmlspecialchars($libro["estado"]) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>