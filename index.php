<?php
session_start();
if (!isset($_COOKIE['logged_in']) || $_COOKIE['logged_in'] !== 'true') {
    header("Location: login.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h2>Página de inicio</h2>
    <ul>
        <li><a href="visualizar.php">Visualizar datos de usuario</a></li>
        <li><a href="agregar.php">Agregar usuario</a></li>
        <li><a href="eliminar.php">Eliminar usuario</a></li>
        <li><a href="modificar.php">Modificar usuario</a></li>
    </ul>
    <form action="logout.php" method="post">
        <input type="submit" value="Cerrar sesión">
    </form>
</body>
</html>
