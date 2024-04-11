<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unitat = $_POST['unitat'];
    $uidNumber = $_POST['uidNumber'];
    $gidNumber = $_POST['gidNumber'];
    $homeDirectory = $_POST['homeDirectory'];
    $loginShell = $_POST['loginShell'];
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $givenName = $_POST['givenName'];
    $postalAddress = $_POST['postalAddress'];
    $mobile = $_POST['mobile'];
    $telephoneNumber = $_POST['telephoneNumber'];
    $title = $_POST['title'];
    $description = $_POST['description'];


    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-stmeri.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];  
    $ldap = new Ldap($opcions);
    $ldap->bind();

    $nova_entrada = [];
    Attribute::setAttribute($nova_entrada, 'objectClass', ['inetOrgPerson', 'posixAccount', 'shadowAccount', 'top']);
    Attribute::setAttribute($nova_entrada, 'uid', $uid);
    Attribute::setAttribute($nova_entrada, 'uidNumber', $uidNumber);
    Attribute::setAttribute($nova_entrada, 'gidNumber', $gidNumber);
    Attribute::setAttribute($nova_entrada, 'homeDirectory', $homeDirectory);
    Attribute::setAttribute($nova_entrada, 'loginShell', $loginShell);
    Attribute::setAttribute($nova_entrada, 'cn', $cn);
    Attribute::setAttribute($nova_entrada, 'sn', $sn);
    Attribute::setAttribute($nova_entrada, 'givenName', $givenName);
    Attribute::setAttribute($nova_entrada, 'postalAddress', $postalAddress);
    Attribute::setAttribute($nova_entrada, 'mobile', $mobile);
    Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telephoneNumber);
    Attribute::setAttribute($nova_entrada, 'title', $title);
    Attribute::setAttribute($nova_entrada, 'description', $description);

    $dn = "uid=$uid,ou=$unitat,$domini";

    if($ldap->add($dn, $nova_entrada)) {
        setcookie("logged_in", "true", time() + (86400 * 30), "/"); 
        echo "Usuario creado";
    } else {
        echo "Error al crear el usuario";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar usuario</title>
</head>
<body>
    <h2>Agregar usuario</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="uid">UID:</label><br>
    <input type="text" id="uid" name="uid" required><br><br>

    <label for="unitat">Unidad organizativa:</label><br>
    <input type="text" id="unitat" name="unitat" required><br><br>

    <label for="uidNumber">UID Number:</label><br>
    <input type="text" id="uidNumber" name="uidNumber" required><br><br>

    <label for="gidNumber">GID Number:</label><br>
    <input type="text" id="gidNumber" name="gidNumber" required><br><br>

    <label for="homeDirectory">Directorio personal:</label><br>
    <input type="text" id="homeDirectory" name="homeDirectory" required><br><br>

    <label for="loginShell">Shell:</label><br>
    <input type="text" id="loginShell" name="loginShell" required><br><br>

    <label for="cn">CN:</label><br>
    <input type="text" id="cn" name="cn" required><br><br>

    <label for="sn">SN:</label><br>
    <input type="text" id="sn" name="sn" required><br><br>

    <label for="givenName">Given Name:</label><br>
    <input type="text" id="givenName" name="givenName" required><br><br>

    <label for="postalAddress">Postal Address:</label><br>
    <input type="text" id="postalAddress" name="postalAddress" required><br><br>

    <label for="mobile">Mobile:</label><br>
    <input type="text" id="mobile" name="mobile" required><br><br>

    <label for="telephoneNumber">Telephone Number:</label><br>
    <input type="text" id="telephoneNumber" name="telephoneNumber" required><br><br>

    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description:</label><br>
    <input type="text" id="description" name="description" required><br><br>

    <input type="submit" value="Agregar usuario">
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
