<?php
    session_start();
    require "config/conexion.php";

    $nombre = $_POST["nombre"] ?? "";
    $correo = $_POST["correo"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $password = $_POST["password"] ?? "";
    $conPassword = $_POST["conPassword"] ?? "";

    if($nombre == "" || $correo == "" ||
        $telefono == "" || $password == "" ||
        $conPassword == ""){
        $_SESSION["error_registro"] = "Debes llenar todos los campos.";
        header("Location: registro.php");
        exit;
    }

    if($password != $conPassword){
        $_SESSION["error_registro"] = "Las contraseñas no coinciden.";
        header("Location: registro.php");
        exit;
    }

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$correo]);

    $datos = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($datos) {
        $_SESSION["error_registro"] = "El correo electrónico ya está registrado.";
        header("Location: registro.php");
        exit;
    }

    $passwordEnc = password_hash($password, PASSWORD_DEFAULT);

    $sqlIns = "INSERT INTO usuarios (nombre, correo, telefono, password_hash, rol)
                VALUES (?, ?, ?, ?, 'usuario')";
    $insert = $conexion->prepare($sqlIns);
    $insert->execute([$nombre, $correo, $telefono, $passwordEnc]);

    header("location: index.php");
    exit;
