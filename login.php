<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];

    if ($password === "fjeclot") {
        setcookie("logged_in", "true", time() + (86400 * 30), "/"); // Cookie válida por 30 días
        header("Location: index.php"); 
        exit;
    } else {
        $error = "Contraseña incorrecta";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Contraseña admin</h2>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
