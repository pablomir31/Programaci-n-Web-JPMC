<?php
    session_start();
    require "config/conexion.php";

    $correo = $_POST["correo"] ?? "";
    $password = $_POST["password"] ?? "";

    if($correo == "" || $password == ""){
        $_SESSION["error"] = "Debes llenar todos los campos.";
        header("Location: index.php");
        exit;
    }
    
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$correo]);

    $datos = $consulta->fetch(PDO::FETCH_ASSOC);

    if($datos && password_verify($password, $datos["password_hash"])){
        $_SESSION["id_usuario"] = $datos["id_usuario"];
        $_SESSION["nombre"] = $datos["nombre"];
        $_SESSION["rol"] = $datos["rol"];
        header("Location: dashboard.php");
        exit;
    }else{
        $_SESSION["error"] = "Correo o contraseña incorrectos.";
        header("Location: index.php");
        exit;
    }