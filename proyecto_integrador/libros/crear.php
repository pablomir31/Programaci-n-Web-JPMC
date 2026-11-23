<?php
    require "../config/auth.php";
    require "../config/conexion.php";

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo = trim($_POST["titulo"] ?? "");
        $autor  = trim($_POST["autor"] ?? "");
        $genero = trim($_POST["genero"] ?? "");
        $anio   = trim($_POST["anio"] ?? "");
        $estado = $_POST["estado"] ?? "";

        // Valida que solo pueda poner estos estados
        $estadosPermitidos = ["Pendiente", "Leyendo", "Terminado"];

        if ($titulo === "" || $autor === "" || $genero === "" || $anio === "" || !in_array($estado, $estadosPermitidos)) {
            $error = "Por favor completa todos los campos correctamente.";
        } else {
            // Inserta el libro asignandolo al usuario logueado
            $sql = "INSERT INTO libros (titulo, autor, genero, anio, estado, id_usuario) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([
                $titulo,
                $autor,
                $genero,
                $anio,
                $estado,
                $_SESSION["id_usuario"]
            ]);

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
    <title>Registrar libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Registra un nuevo libro</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error != ""): ?>
                            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Título del libro</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <input type="text" name="autor" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Género</label>
                                    <input type="text" name="genero" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Año de publicación</label>
                                    <input type="number" name="anio" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Estado de lectura</label>
                                <select name="estado" class="form-select" required>
                                    <option value="">Selecciona una opción...</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Leyendo">Leyendo</option>
                                    <option value="Terminado">Terminado</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar Libro</button>
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