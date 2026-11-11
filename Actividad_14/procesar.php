<?php
    session_start(); // SIEMPRE
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

    if($datos && password_verify($password, $datos["password"])){
        $_SESSION["usuario"] = $datos["usuario"];
        header("Location: home.php");
        exit;
    }else{
        echo "Usuario o contraseña incorrectos.";
    }