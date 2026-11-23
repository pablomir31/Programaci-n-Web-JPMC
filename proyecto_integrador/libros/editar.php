<?php
    require "../config/auth.php";
    require "../config/conexion.php";

    $id_libro = $_GET["id"] ?? "";
    $error = "";

    if ($id_libro === "") {
        header("Location: index.php");
        exit;
    }

    // Buscamos los datos actuales del libro
    if ($_SESSION["rol"] === "administrador") {
        $sql = "SELECT * FROM libros WHERE id_libro = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id_libro]);
    } else {
        $sql = "SELECT * FROM libros WHERE id_libro = ? AND id_usuario = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id_libro, $_SESSION["id_usuario"]]);
    }

    $libro = $consulta->fetch(PDO::FETCH_ASSOC);

    // Si el libro no existe o no pertenece al usuario, lo regresa
    if (!$libro) {
        header("Location: index.php");
        exit;
    }

    // Actualiza los cambios
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo = trim($_POST["titulo"] ?? "");
        $autor  = trim($_POST["autor"] ?? "");
        $genero = trim($_POST["genero"] ?? "");
        $anio   = trim($_POST["anio"] ?? "");
        $estado = $_POST["estado"] ?? "";

        $estadosPermitidos = ["Pendiente", "Leyendo", "Terminado"];

        if ($titulo === "" || $autor === "" || $genero === "" || $anio === "" || !in_array($estado, $estadosPermitidos)) {
            $error = "Por favor completa todos los campos correctamente.";
        } else {
            $sqlUpd = "UPDATE libros 
                    SET titulo = ?, autor = ?, genero = ?, anio = ?, estado = ? 
                    WHERE id_libro = ?";
            $update = $conexion->prepare($sqlUpd);
            $update->execute([$titulo, $autor, $genero, $anio, $estado, $id_libro]);

            header("Location: index.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
</head>
<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0">Editar libro</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error != ""): ?>
                            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Título del libro</label>
                                <input type="text" name="titulo" class="form-control" 
                                       value="<?= htmlspecialchars($libro["titulo"]) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <input type="text" name="autor" class="form-control" 
                                       value="<?= htmlspecialchars($libro["autor"]) ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Género</label>
                                    <input type="text" name="genero" class="form-control" 
                                           value="<?= htmlspecialchars($libro["genero"]) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Año de publicación</label>
                                    <input type="number" name="anio" class="form-control" 
                                           value="<?= htmlspecialchars($libro["anio"]) ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Estado de lectura</label>
                                <select name="estado" class="form-select" required>
                                    <option value="Pendiente" <?= $libro["estado"] === "Pendiente" ? "selected" : "" ?>>Pendiente</option>
                                    <option value="Leyendo"   <?= $libro["estado"] === "Leyendo"   ? "selected" : "" ?>>Leyendo</option>
                                    <option value="Terminado" <?= $libro["estado"] === "Terminado" ? "selected" : "" ?>>Terminado</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-warning">Actualizar Libro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>