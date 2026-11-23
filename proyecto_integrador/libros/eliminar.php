<?php
    require "../config/auth.php";
    require "../config/conexion.php";

    // Revisa que el usuario sea administardor
    if ($_SESSION["rol"] !== "administrador") {
        header("Location: index.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id_libro = $_POST["id_libro"] ?? "";

        if ($id_libro !== "") {
            $sql = "DELETE FROM libros WHERE id_libro = ?";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([$id_libro]);
        }
    }

    header("Location: index.php");
    exit;