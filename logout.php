<?php
setcookie("logged_in", "", time() - 3600, "/");
header("Location: login.php");
exit;
?>
