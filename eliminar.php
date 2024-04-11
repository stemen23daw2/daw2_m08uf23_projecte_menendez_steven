<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

session_start();
if (!isset($_COOKIE['logged_in']) || $_COOKIE['logged_in'] !== 'true') {
    header("Location: login.php"); 
    exit;
}

ini_set('display_errors', 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];

    $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';

    $opciones = [
        'host' => 'zend-stmeri.fjeclot.net',
        'username' => 'cn=admin,dc=fjeclot,dc=net',
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];

    $ldap = new Ldap($opciones);
    $ldap->bind();
    try {
        $ldap->delete($dn);
        echo "<b>Entrada eliminada</b><br>";
    } catch (Exception $e) {
        echo "<b>Esta entrada no existe</b><br>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar usuario</title>
</head>
<body>
    <h2>Eliminar usuario</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="uid">UID:</label><br>
        <input type="text" id="uid" name="uid" required><br><br>

        <label for="unorg">Unidad organizativa:</label><br>
        <input type="text" id="unorg" name="unorg" required><br><br>

        <input type="submit" value="Eliminar usuario">
    </form>
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
