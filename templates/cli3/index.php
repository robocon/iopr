<?php 
if ($name!=="index") {
	if (is_file('routes/'.$name.'.php')) {
		require_once 'routes/'.$name.'.php';
		if (method_exists($name, $file)) {
			$classname = new $name();
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns#">
<head>
<?php 
$host_url = ($_SERVER['HTTPS'] ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ;

$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD); // Connect DB
$query = $db->select_query("SELECT * FROM ".TB_CONFIG." AS a, ".TB_TEMPLATES." AS b WHERE a.`name` = b.`temname` AND b.`id` = 2;");
$config_fb = $db->fetch($query);

$img = ($_SERVER['HTTPS'] ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].'/templates/'.$config_fb['temname'].'/images/config/'.$config_fb['picname'];

$title = WEB_TITILE;
$description = WEB_TITILE;
$picture = $img;

$tag = $classname->fb_tag;
if ($tag!==null) {
	$title = $tag['title'];
	$description = $tag['description'];
	$picture = $tag['picture'];
}
?>
<title><?php echo $title; ?></title>
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:site_name" content="<?php echo WEB_TITILE; ?>" />
<meta property="og:url" content="<?php echo $host_url;?>" />
<meta property="og:description" content="<?php echo $description; ?>" />
<meta property="og:image" content="<?php echo $picture; ?>" />
<meta property="fb:app_id" content="668685863216459" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="th_TH"/>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo ISO;?>">
<meta name="keywords" content="<?php echo $title; ?>">
<meta name="description" content="<?php echo $description; ?>">
<link rel="shortcut icon" href="images/favicon.ico">

<link href="templates/cli3/css/cli3.css" rel="stylesheet" type="text/css">
<link href="css/template_css.css" rel="stylesheet" type="text/css">
<link href="css/Scroller_Stop.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="highslide/highslide.js"></script>
<script type="text/javascript" src="highslide/highslide-html.js"></script>
<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/java.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/Style_event.js" ></script>
<script type="text/javascript" src="js/Style_cookie.js" ></script>
<script type="text/javascript" src="js/Style_size.js" ></script>
<script type="text/javascript" src="js/Set_text.js" ></script>
<script type="text/javascript">
function checkAll(field)
{
  for(i = 0; i < field.elements.length; i++)
     field[i].checked = true ;
}

function uncheckAll(field)
{
 for(i = 0; i < field.elements.length; i++)
    field[i].checked = false ;
}

function Confirm(link,text) 
{
  if (confirm(text))
     window.location=link
}

function delConfirm(obj){
	var status=false;
	for(var i=0 ; i < obj.elements.length ; i++ ){
		if(obj[i].type=='checkbox'){
			if(obj[i].checked==true){
				status=true;
			}
		}
	}
	if(status==false){
		alert('<?php echo _ADMIN_JAVA_CONFIRM_SELECT_DEL;?>');
		return false;
	}else{
		if(confirm('<?php echo _ADMIN_JAVA_CONFIRM_DEL;?>')){
			return true;
		}else{
			return false;
		}
	}
}

// Highslide
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.outlineWhileAnimating = true;
hs.objectLoadTime = 'after';

/*
Fading Image Script 
Dynamic Drive (www.dynamicdrive.com)
*/
function makevisible(cur,which){
  if (which==0)
    cur.filters.alpha.opacity=100
  else
    cur.filters.alpha.opacity=50
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_displayStatusMsg(msgStr) { //v1.0
  status=msgStr;
  document.MM_returnValue = true;
}

// create a new Date object then get the current time
var start = new Date();
var startsec = start.getTime();

// run a loop counting up to 250,000
var num = 0;
for( var i = 0; i < 250000; i++ )
{
  num++;
}

var stop  = new Date();
var stopsec = stop.getTime();

var loadtime = ( stopsec - startsec ) / 1000;

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>

<script type="text/javascript">
var dayArrayShort = new Array('<?php echo _S_Sunday;?>', '<?php echo _S_Monday;?>', '<?php echo _S_Tuesday;?>', '<?php echo _S_Wednesday;?>', '<?php echo _S_Thursday;?>', '<?php echo _S_Friday;?>', '<?php echo _S_Saturday;?>');
var dayArrayMed = new Array('<?php echo _S_Sunday;?>', '<?php echo _S_Monday;?>', '<?php echo _S_Tuesday;?>', '<?php echo _S_Wednesday;?>', '<?php echo _S_Thursday;?>', '<?php echo _S_Friday;?>', '<?php echo _S_Saturday;?>');
var dayArrayLong = new Array('<?php echo _Sunday;?>', '<?php echo _Monday;?>', '<?php echo _Tuesday;?>', '<?php echo _Wednesday;?>', '<?php echo _Thursday;?>', '<?php echo _Friday;?>', '<?php echo _Saturday;?>');
var monthArrayShort = new Array('<?php echo _Month_1;?>', '<?php echo _Month_2;?>', '<?php echo _Month_3;?>', '<?php echo _Month_4;?>', '<?php echo _Month_5;?>', '<?php echo _Month_6;?>', '<?php echo _Month_7;?>', '<?php echo _Month_8;?>', '<?php echo _Month_9;?>', '<?php echo _Month_10;?>', '<?php echo _Month_11;?>', '<?php echo _Month_12;?>');
var monthArrayMed = new Array('<?php echo _Month_1;?>', '<?php echo _Month_2;?>', '<?php echo _Month_3;?>', '<?php echo _Month_4;?>', '<?php echo _Month_5;?>', '<?php echo _Month_6;?>', '<?php echo _Month_7;?>', '<?php echo _Month_8;?>', '<?php echo _Month_9;?>', '<?php echo _Month_10;?>', '<?php echo _Month_11;?>', '<?php echo _Month_12;?>');
var monthArrayLong = new Array('<?php echo _F_Month_1;?>', '<?php echo _F_Month_2;?>', '<?php echo _F_Month_3;?>', '<?php echo _F_Month_4;?>', '<?php echo _F_Month_5;?>', '<?php echo _F_Month_6;?>', '<?php echo _F_Month_7;?>', '<?php echo _F_Month_8;?>', '<?php echo _F_Month_9;?>', '<?php echo _F_Month_10;?>', '<?php echo _F_Month_11;?>', '<?php echo _F_Month_12;?>');
</script>

</head>
<body onload="MM_preloadImages('../../images/random/ram.jpg')">

<?php
// require_once("mainfile.php");
$_SERVER['PHP_SELF'] = "index.php";
if(ISO =='utf-8'){
require_once("templates/".WEB_TEMPLATES."/lang/tem_thai_utf8.php");
} else {
require_once("templates/".WEB_TEMPLATES."/lang/tem_thai_tis620.php");
}
?>
<TABLE width="1024" height="100%" border="0" align="center" cellPadding="0" cellSpacing="0" bgcolor="#ffffff">
	<tr>
		<TD width="1024" align="center" >
			<div align="center">
			<div id="outer1" >
				<div id="outer2" >
				<table id="Table_01" width="<?=_TEMPLATES_WIDTH_CONFIG;?>" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="6" >
<?php

//$db->closedb (); // Disconnect DB
$query = $db->select_query("SELECT * FROM ".TB_CONFIG.",".TB_TEMPLATES." where name=temname and sort='1' ");
$config = $db->fetch($query);
 $types=$config['type'];

 if ($types !='application/x-shockwave-flash' ) {
?>
<TABLE width="<?=$config['width'];?>" align=right cellSpacing=0 cellPadding=0 border=0>
<TR>
<TD valign="top" width="<?=$config['width'];?>" background="templates/<?php echo WEB_TEMPLATES;?>/images/config/<?=$config['picname'];?>"  width="<?=$config['width'];?>" height="<?=$config['height'];?>" border="0" valign="top" colspan="6" style="background-repeat: no-repeat;">
<table align=right cellSpacing=0 cellPadding=0 border="0">
<tr>
<td colspan="6" align="right" >
		<?php
empty($_SESSION['admin_user'])?$admin_user="":$admin_user=$_SESSION['admin_user'];
empty($_SESSION['admin_pwd'])?$admin_pwd="":$admin_pwd=$_SESSION['admin_pwd'];
empty($_SESSION['login_true'])?$login_true="":$login_true=$_SESSION['login_true'];
if ($admin_user) {
echo "<font color=#CFCFCF><b>"._TEM_WEL." </font><font color=#3366FF>$admin_user </b></font>";
}else if($login_true){
echo "<font color=#CFCFCF><b>"._TEM_WEL." </font><font color=#00CC33>$login_true </b></font>";
} else {
echo "<font color=#CFCFCF><b>"._TEM_WEL." </font><font color=#CC0000>"._TEM_WEL_GUEST."</b></font>";
}
?>
&nbsp;&nbsp;<br>
</td>
</tr>
<?php if (CountBlock('header')) { ?>
<tr><td colspan="6" align="right" >
<?php
	LoadBlock('header'); 
?>
</td>
</tr>
<?php } ?>
					<tr>
						<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_01.png" width="95" height="37" border="0">
			<a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('home','','templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu1_01.png',1)"><img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_01.png" width="95" height="37" alt="" name="home"></a></td>
						<td  background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_02.png" width="83" height="37" border="0" >
			<a href="?name=news" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('news','','templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu1_02.png',1)"><img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_02.png" width="83" height="37" alt="" name="news"></a></td>
						<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_03.png" border="0" width="96" height="37">
			<a href="?name=webboard" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('webboard','','templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu1_03.png',1)"><img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_03.png" width="96" height="37" name="webboard" alt=""></a></td>
						<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_04.png" border="0" width="102" height="37">
			<a href="?name=gallery" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('gallery','','templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu1_04.png',1)"><img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_04.png" width="102" height="37" alt="" name="gallery"></a></td>
						<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_05.png" border="0" width="93" height="37">
				<a href="?name=gbook" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('gbook','','templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu1_05.png',1)"><img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_05.png" width="93" height="37" alt="" name="gbook"></a></td>
						<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_06.png" border="0" width="91" height="37"><a href="?name=admin" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('admin','','templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu1_06.png',1)"><img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/menu_06.png" width="91" height="37" alt="" name="admin"></a></td>
					</tr>
</table>
</td>
</tr>
</table>
<?php 	} else {
		  ?>

<TABLE width="<?=$config['width'];?>" align=center cellSpacing=0 cellPadding=0 border=0>
<TR>
<TD width="<?=$config['width'];?>" border="0">
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<?=$config['width'];?>" height="<?=$config['height'];?>" border="0">
 <param name="movie" value="templates/<?=WEB_TEMPLATES;?>/images/config/<?=$config['picname'];?>" />
<param name="quality" value="high" />
<param name="wmode" value="transparent">
<embed src="templates/<?=WEB_TEMPLATES;?>/images/config/<?=$config['picname'];?>"
      quality="high"
      type="application/x-shockwave-flash"
      width="<?=$config['width'];?>"
      height="<?=$config['height'];?>"
pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="opaque"></embed>
</object>
</td>
</tr>
</table>
<?php
}
?>


						</td>
					</tr>
					<tr>
						<td colspan="6"><?php include 'modules/config/top2.php'; ?></td>
					</tr>
					<tr>
						<td colspan="6" background="templates/<?php echo WEB_TEMPLATES;?>/images/bar.png" width=1000 height=27 >
							<?php if (CountBlock('pathway')) { ?>
													<?php LoadBlock('pathway'); ?>
									<?php } ?>
						</td>
					</tr>
				</table>

<center>
				<TABLE cellSpacing=0 cellPadding=0 width=<?=_TEMPLATES_WIDTH_CONFIG;?> align=center border=0>
				<TBODY>
				</table>
<table cellSpacing=0 cellPadding=0 width=990 align=center border=0>
<tr>
<td width=990>
				<TABLE cellSpacing=0 cellPadding=0 width=990 align=center border=0>
				<TBODY>
					<TR>
					<td width="220" valign="top">
								<?php if($name<>"admin" && $name<>"admin/workboard" && $name<>"admin/backup" ) { ?>


								<?php //blockleft;?>

									<?php if (CountBlock('left')) { ?>

										<table cellspacing="0" cellpadding="0" width="220" >
											<tr><td width="220" valign="top" id="leftcol">
													<?php LoadBlock('left'); ?>
													</td>
											</tr>
										</table><br>
									<?php } ?>


						<?php } ?>
				  </td>
						<TD vAlign="top" align="center" width="10" ></TD>
<TD vAlign="top" align="center" width="100%" align="center">
<?php 
// var_dump($name);
 ?>
	<?php if($name=="index") { ?>

										<table width="100%" cellspacing="0" cellpadding="0" >
											<tr>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="770" vAlign=top align=left><IMG src="images/topfader.gif" border=0><BR>
		  <!-- Admin -->
		  &nbsp;&nbsp;
								<?php
								// var_dump(CountBlock('user2'));
								?>
 									<?php if (CountBlock('user2')) { ?>

										<table width="100%" cellspacing="0" cellpadding="0" >
											<tr>
												<td >
                        							<div >
													<?php LoadBlock('user2'); ?>
													</div>
												</td>
											</tr>
										</table>
										<br>
									<?php } ?>

									<?php if (CountBlock('center')) { ?>
									<table cellspacing="0" cellpadding="0" width="100%">
										<tr>
										<td >
										<div >
											<?php LoadBlock('center'); ?>
                         				<div>
										</td>
										</tr>
									</table>
										<br>
									<?php } ?>
									
									<?php if (CountBlock('user1')) { ?>
									<center>
									<table width="100%" cellspacing="0" cellpadding="0" >
										<tr>
											<td >
												<div id="main_top_wrape">
												<?php LoadBlock('user1'); ?>
												</div>
											</td>
										</tr>
									  </table><br>
			  </center>
										<?php } ?>

				</td>


<?php //blockright;?>
							<?php if (CountBlock('right')) { ?>
        <TD width="10" vAlign=top></TD>
          <TD width="220" vAlign=top align=left>
									
							<table cellspacing="0" cellpadding="0" width="220" >
							<tr>
								<td width="220" valign="top"  align="center">
								<?php LoadBlock('right'); ?>
						</td>
						</tr>
						</table><br><br>
						</td>
						<?php } ?>
			</td>
			</tr>
			</table>

<?php } else {
OpenTable();
require_once ("".$MODPATHFILE."");
 CloseTable();
} ?>
</td>
				  </tr>
	</table>
</td>
</tr>
									<?php if (CountBlock('bottom')) { ?>
<tr>
<td>
									<table width="<?=_TEMPLATES_WIDTH_CONFIG;?>" cellspacing="0" cellpadding="0">
										<tr>
											<td >
                        					<div >
											<?php LoadBlock('bottom'); ?>
											</div>
											</td>
										</tr>
									</table>
</td>
</tr>
									<?php } ?>
</table>

	  <table border="0" align="center" cellpadding="0" cellspacing="0" width="<?=_TEMPLATES_WIDTH_CONFIG;?>">
        <tr>
          <td valign="top" class="footer" bgcolor="#1B6AE0"><?php include "modules/config/top3.php";?>
		  </td>
	    </tr>
		  <tr>
          <td valign="top" class="footer" bgcolor="#1B6AE0">
		  <div align="center" ><strong><b><?=WEB_FOOTER1;?></b></strong><br><?=WEB_FOOTER2;?>
<br>
<SCRIPT>
 document.write(" : <?php echo _TEM_LOAD_PAGE;?>" +loadtime+ " <?php echo _TEM_LOAD_PAGE_TIME;?> : ");
</SCRIPT>
<br>

</div>

		  </td>
		 </tr>
      </table>

</td>
</tr>
</table>
</div>
</div>
</div>
  </TD>

    </TR>
  </TBODY>
</TABLE>

<!-- Script for HeightSlide -->
<div class="highslide-html-content" id="highslide-html" style="width: 500px">
	<div class="highslide-move" style="border: 0; height: 18px; padding: 2px; cursor: default">
	    <a href="#" onclick="return hs.close(this)" class="control">[x] <?php echo _HIGH_CLOSE;?></a>
	</div>
	<div class="highslide-body"></div>
	<div style="text-align: center; border-top: 1px solid silver; padding: 5px 0">
		Powered by <A HREF="<?php echo WEB_URL;?>" target="_blank"><?php echo  _SCRIPT." "._VERSION ;?></A>
	</div>
</div>

</body>
</html>