<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
echo$_SESSION['user_name'];
$_SESSION['user_id']  = "";
$_SESSION['user_name'] = "";
$_SESSION['user_email'] = "";
$_SESSION['user_address'] = "";
$_SESSION['user_type'] = "";
$_SESSION['user_wallet'] = "";
header("Location: /");
exit;
?>