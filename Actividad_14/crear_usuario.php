<?php
    require "conexion.php";

    $usuario = $_POST["usuario"] ?? "";
    $password = $_POST["password"] ?? "";

    if($usuario == "" || $password == ""){
        exit("Debes llenar todos los campos.");
    }

    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$usuario]);

    $datos = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($datos) {
        exit("El nombre de usuario ya está registrado.");
    }

    $passwordEnc = password_hash($password, PASSWORD_DEFAULT);

    $sqlIns = "INSERT INTO usuarios (usuario, password)
                VALUES (?, ?)";
    $insert = $conexion->prepare($sqlIns);
    $insert->execute([$usuario, $passwordEnc]);

    // echo "Usuario creado correctamente";
    header("location: index.php");
    exit;
