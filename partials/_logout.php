<?php
session_start();
// session_unset();
echo "Logging You out. Please wait....";
session_destroy();
header("Location: /forum")
// header("Location: /forum/index.php");
// exit();
?>

