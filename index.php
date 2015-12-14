<?php 

// Set default session into 1day
ini_set('session.gc_maxlifetime', 86400);
ini_set('display_error', 0);
error_reporting(0);

session_start();

header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

if ( !file_exists( 'includes/config.in.php' ) || filesize( 'includes/config.in.php' ) < 9.00 ) {
	header( 'Location: install/index.php' );
	exit();
}

/*Installation sub folder check, removed for work with CVS*/
if (file_exists( 'install/index.php' )) {
	include ('offline.php');
	exit();
}

require_once("mainfile.php");
$_SERVER['PHP_SELF'] = "index.php";
$name = empty($_GET['name']) ? "index" : $_GET['name'] ;
$file = empty($_GET['file']) ? "index" : $_GET['file'] ;

GETMODULE($name, $file);

// Make sure you're using correct paths here
$admin_user = empty($_SESSION['admin_user']) ? "" : $_SESSION['admin_user'];
$admin_pwd = empty($_SESSION['admin_pwd']) ? "" : $_SESSION['admin_pwd'];
$login_true = empty($_SESSION['login_true']) ? "" : $_SESSION['login_true'];
$pwd_login = empty($_SESSION['pwd_login']) ? "" : $_SESSION['pwd_login'];
$op = empty($_GET['op']) ? "" : $_GET['op'];
$action = empty($_GET['action']) ? "" : $_GET['action'];
$page = empty($_GET['page']) ? "" : $_GET['page'];
$category = empty($_GET['category']) ? "" : $_GET['category'];
$loop = empty($_POST['loop']) ? "" : $_POST['loop'];

require_once( 'templates/'.WEB_TEMPLATES.'/index.php' );