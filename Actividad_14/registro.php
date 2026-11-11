<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
</head>
<body>
    
    <div class="container d-flex vh-100 align-items-center justify-content-center">
        <div class="w-50 justify-content-center">
            <div class="card border border-success border-3 rounded-4 p-4">
                <div class="card-body">
                    <h1 class="card-title text-center h3 mb-3">Registrate</h1>

                    <form action="crear_usuario.php" method="post">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Registrarse</button>
                        </div>
                    </form>
                    <div class="card-footer">
                        <p class="text-center mb-0">¿Ya tienes cuenta? <a href="index.php" class="theme-primary underline-offset-2 underline-20 hover:underline-100">Inicia sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>









    <!--<h1>Registrate</h1>
    <form action="crear_usuario.php" method="post">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" required>
        
        <br><br>
        
        <label>Contraseña</label>
        <input type="password" name="password" required>
        
        <br><br>

        <button type="submit">Registrarse</button>
    </form>-->

    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</body>
</html>