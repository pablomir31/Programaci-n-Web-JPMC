<?php

    // Datos de conexión
    $servidor = "localhost";
    // Tenia que usar este puerto en mi computadora
    // $puerto = "3307";
    $basedatos = "dummy";
    $usuario = "root";
    $contrasena = "";

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

        // echo "Conexión creada con exito!";

    }catch(PDOException $e){
        die("Error al conectar con la base de datos.");
    }