<?php

    // Datos de conexión
    $servidor = "localhost";
    // Tenia que usar este puerto en mi computadora
    // $puerto = "3307";
    $basedatos = "biblioteca";
    $usuario = "root";
    $contrasena = "root";

    try{
        $conexion = new PDO(
            // port=$puerto;
            "mysql:host=$servidor;dbname=$basedatos;charset=utf8mb4",
            $usuario,
            $contrasena
        );

        // Confguramos manejo de errores
        $conexion->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

    }catch(PDOException $e){
        die("Error al conectar con la base de datos.");
    }