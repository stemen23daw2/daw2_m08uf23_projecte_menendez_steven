<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
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
    $atribut = $_POST['atribut'];
    $nou_contingut = $_POST['nou_contingut'];
    
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
    $entrada = $ldap->getEntry($dn);
    if ($entrada) {
        Attribute::setAttribute($entrada, $atribut, $nou_contingut);
        $ldap->update($dn, $entrada);
        echo "Atributo modificado";
    } else {
        echo "<b>Esta entrada no existe</b><br><br>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar atributo de usuario</title>
</head>
<body>
    <h2>Modificar atributo de usuario</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="uid">UID:</label><br>
    <input type="text" id="uid" name="uid" required><br><br>

    <label for="unorg">Unidad organizativa:</label><br>
    <input type="text" id="unorg" name="unorg" required><br><br>

    <label>Atributo a modificar:</label><br>
    <input type="radio" id="uidNumber" name="atribut" value="uidNumber" required>
    <label for="uidNumber">uidNumber</label><br>
    <input type="radio" id="gidNumber" name="atribut" value="gidNumber">
    <label for="gidNumber">gidNumber</label><br>
    <input type="radio" id="homeDirectory" name="atribut" value="homeDirectory">
    <label for="homeDirectory">Directorio personal</label><br>
    <input type="radio" id="loginShell" name="atribut" value="loginShell">
    <label for="loginShell">Shell</label><br>
    <input type="radio" id="cn" name="atribut" value="cn">
    <label for="cn">cn</label><br>
    <input type="radio" id="sn" name="atribut" value="sn">
    <label for="sn">sn</label><br>
    <input type="radio" id="givenName" name="atribut" value="givenName">
    <label for="givenName">givenName</label><br>
    <input type="radio" id="postalAddress" name="atribut" value="postalAddress">
    <label for="postalAddress">PostalAddress</label><br>
    <input type="radio" id="mobile" name="atribut" value="mobile">
    <label for="mobile">mobile</label><br>
    <input type="radio" id="telephoneNumber" name="atribut" value="telephoneNumber">
    <label for="telephoneNumber">telephoneNumber</label><br>
    <input type="radio" id="title" name="atribut" value="title">
    <label for="title">title</label><br>
    <input type="radio" id="description" name="atribut" value="description">
    <label for="description">description</label><br><br>

    <label for="nou_contingut">Nuevo contenido:</label><br>
    <input type="text" id="nou_contingut" name="nou_contingut" required><br><br>

    <input type="submit" value="Modificar atributo">
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
