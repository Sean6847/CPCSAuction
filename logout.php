<?php
session_start();
ob_start();
session_unset();
session_destroy();

header("Location: login.php");
ob_end_clean();
?>