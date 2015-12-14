<?php 

// ob_start();
// if (session_id() =='') { session_start(); }

// $globals_test = @ini_get('register_globals');
// if ( isset($globals_test) && empty($globals_test) ) {
// 	$types_to_register = array('GET', 'POST', 'COOKIE', 'SESSION', 'SERVER');
// 	foreach ($types_to_register as $type) {
// 		$arr = @${'_' . $type};
// 		if (@count($arr) > 0)
// 			extract($arr, EXTR_SKIP);
// 	}
// }

// if (preg_match("/mainfile.php/i",$_SERVER['PHP_SELF'])) {
//     Header("Location: index.php");
//     die();
// }

$PHP_SELF = "index.php";
require_once("setconf.php");
require_once("includes/config.in.php");
require_once("includes/function.in.php");
require_once("includes/class.mysql.php");
require_once("includes/array.in.php");
require_once("includes/class.ban.php");
require_once("includes/class.calendar.php");

header( 'Content-Type:text/html; charset='.ISO.'');

$db = New DB();
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);

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

$IPADDRESS = get_real_ip();

function GETMODULE($name, $file){
	
	global $MODPATH, $MODPATHFILE ;
	$targetPath = WEB_PATH;
	// if(empty($name)){ $name= "index"; }
	// if(empty($file)){ $file = "index"; }
	$files = str_replace('../', '', $file);
	$names = str_replace('../', '', $name);
	$modpathfile = WEB_PATH."/modules/".$names."/".$files.".php";
	
	if (file_exists($modpathfile)) {
		$MODPATHFILE = $modpathfile;
		$MODPATH = WEB_PATH."/modules/".$names."/";
		// var_dump($MODPATH);
	}else{
		header( 'Content-Type:text/html; charset='.ISO);
		die (""._NO_MOD."");
	}
}

//ผู้ดูแลระบบไม่ผ่านสิทธิการใช้งาน
$PermissionFalse = "<BR><BR>";
$PermissionFalse .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\"></A><BR><BR>";
$PermissionFalse .= "<FONT COLOR=\"#336600\"><B>"._PERMISSION_ADMIN."</B></FONT><BR><BR>";
$PermissionFalse .= "<A HREF=\"?name=admin&file=main\"><B>"._PERMISSION_INDEX."</B></A>";
$PermissionFalse .= "</CENTER>";
$PermissionFalse .= "<BR><BR>";

// ส่วนของระบบสมาชิกเพิ่มเติมภายหลังโดย narongrit.net
$home = "".WEB_URL."" ; // url เว็บไซด์ของคุณ เวลาที่ต้องการเรียก
$admin_email = "".WEB_EMAIL."" ; // อีเมล์ของคุณ
$yourcode = "web" ; // รหัสนำหน้าหมายเลขสมาชิกของคุณ เช่น ip00001 , abc00005
$member_num_show = 5 ;  // จำนวนของสมาชิกที่ต้องการให้แสดงต่อ  1 หน้า ในระบบของ admin 
$member_num_show_last = 5 ;  // จำนวนของสมาชิกล่าสุดที่ต้องการให้แสดง
$member_num_last = 1 ;  // จำนวนของสมาชิกล่าสุดที่ต้องการให้แสดงหน้าแรก

$bkk= mktime(gmdate("H")+7,gmdate("i")+0,gmdate("s"),
	gmdate("m") ,gmdate("d"),gmdate("Y"));
$datetimeformat="j/m/y - H:i";
$now = date($datetimeformat,$bkk);

/*
$IPB=$db->select_query("select * from ".TB_IPBLOCK." where ip='".$IPADDRESS."' ");
$IPBS=$db->fetch($IPB);
$db->closedb ();
$IPBLOCK=$IPBS['ip'];
if ($IPBLOCK){
?>
<BR><BR>
<CENTER><A HREF="?name=index"><IMG SRC="images/dangerous.png" BORDER="0"></A><BR><BR>
<FONT COLOR="#336600"><B><?php echo _ADMIN_IPBLOCK_MESSAGE_HACK;?> <?php echo WEB_EMAIL;?></B></FONT><BR><BR>
<A HREF="?name=index"><B><?php echo _ADMIN_IPBLOCK_MESSAGE_HACK1;?></B></A>
</CENTER>
<BR><BR>
<?php 
exit();
} else {
*/

$timestamp = time();
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['user3'] = $db->select_query("SELECT * FROM ".TB_useronline." where timeout < $timestamp");
//$rows['user3'] = $db->fetch($res['user3']);
//if($rows['user3']['useronline']){
while ($rows['user3'] = $db->fetch($res['user3'])){
if ($login_true==$rows['user3']['useronline']){
//$db->del(TB_useronline,"  timeout < $timestamp  "); 
$db->del(TB_useronline,"  timeout < $timestamp and useronline='".$login_true."' "); 
session_unset($rows['user3']['useronline']);
setcookie($rows['user3']['useronline'],'');
} else if ($admin_user==$rows['user3']['useronline']){
$db->del(TB_useronline,"  timeout < $timestamp and useronline='".$admin_user."' "); 
session_unset($rows['user3']['useronline']);
setcookie($rows['user3']['useronline'],'');
} else {
$db->del(TB_useronline,"  timeout < $timestamp  "); 
session_unset($rows['user3']['useronline']);
setcookie($rows['user3']['useronline'],'');
}
}

require_once("templates/".WEB_TEMPLATES."/function.php");
// }

?>

