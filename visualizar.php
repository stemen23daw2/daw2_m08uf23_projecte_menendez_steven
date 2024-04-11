<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

session_start();
if (!isset($_COOKIE['logged_in']) || $_COOKIE['logged_in'] !== 'true') {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 0);

$usuario = null;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ou']) && isset($_GET['usr'])) {
    $dominio = 'dc=fjeclot,dc=net';
    $opciones = [
        'host' => 'zend-stmeri.fjeclot.net',
        'username' => "cn=admin,$dominio",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    
    $ldap = new Ldap($opciones);
    $ldap->bind();
    
    $entrada = 'uid=' . $_GET['usr'] . ',ou=' . $_GET['ou'] . ',dc=fjeclot,dc=net';
    $usuario = $ldap->getEntry($entrada);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar datos de usuario</title>
</head>
<body>
    <h2>Visualizar datos de usuario</h2>
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="ou">Unidad organizativa:</label><br>
        <input type="text" id="ou" name="ou" required><br><br>

        <label for="usr">Usuario:</label><br>
        <input type="text" id="usr" name="usr" required><br><br>

        <input type="submit" value="Mostrar datos">
    </form>
    <br>
    
    <?php if ($usuario): ?>
		<b style="text-decoration: underline;"><?php echo $usuario["dn"]; ?></b><br>
        <?php foreach ($usuario as $atributo => $valor): ?>
            <?php if ($atributo != "dn") echo $atributo . ": " . $valor[0] . '<br>'; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <br>
    <form action="index.php">
    <input type="submit" value="Volver al inicio">
</form>
&nbsp;&nbsp;&nbsp;&nbsp;
<form action="logout.php" method="post">
    <input type="submit" value="Cerrar sesión">
</form>
    
</body>
</html>
