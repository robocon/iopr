<TABLE WIDTH="750"  border="0" ALIGN="center" CELLPADDING="0" CELLSPACING="0">
  <TR>
            <TD width="10" vAlign=top></TD>
          <TD width="740" vAlign=top >

      &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_member.gif" BORDER="0">
				<TABLE width="740" align=center cellSpacing=0 cellPadding=0 border=0>
				<TR>
					<TD height="1" class="dotline" colspan="4"></TD>
				</TR>
      <TR>
        <TD> </TD>
      </TR>
      <TR>
        <TD>
		<P>&nbsp;</P>
		<?php 
require("includes/class.resizepic.php");
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['admin'] = $db->select_query("SELECT * FROM ".TB_ADMIN." WHERE username='".$_POST['USERNAME']."' "); 
$arr['admin'] = $db->fetch($res['admin']);

if($arr['admin']['username']){
			echo "<script language='javascript'>" ;
			echo "alert('<?php echo _MEMBER_MOD_FORM_JAVA_USERACC;?>')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.go(-1)</script>";
			exit();
}
$FILE = $_FILES['FILE'];

// $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
//ÃÐººÊÁÒªÔ¡àÊÃÔÁ maxsite 1.10 ¾Ñ²¹Òâ´Â www.narongrit.net


$member_id=$_POST['member_id'];
$username=$_POST['USERNAME'];
//$password=$_POST['PASSWORD'];
$nic_name=$_POST['nic_name'];
$name=$_POST['name'];
$age=$_POST['age'];
$province=$_POST['province'];
$email=$_POST['email'];
$date=$_POST['date'];
$month=$_POST['month'];
$year=$_POST['year'];
$office=$_POST['office'];
$sex=$_POST['sex'];
$amper=$_POST['amper'];
$education=$_POST['education'];
$work=$_POST['work'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$zipcode=$_POST['zipcode'];
$member_pic=$_POST['member_pic'];

$session_user = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : $_SESSION['login_true'] ;

$statement = sprintf("SELECT * FROM `web_member` WHERE `user` = '%s' ;", $session_user);
$query = $db->select_query($statement);
$user = $db->fetch($query);


$sql = sprintf("SELECT * FROM `web_member` WHERE `user` = '%s' AND `id` != '%s'", $username, $user['id']);
$query = $db->select_query($sql);
$rows = $db->rows($query);
if ($rows > 0) {
	?>
	<script type="text/javascript">
		alert('<?php echo toTis620("ชื่อผู้ใช้งานซ้ำกับคนอื่น กรุณาตรวจสอบอีกครั้ง");?>');
		window.history.back(-1);
	</script>
	<?php
	exit();
}


// ¶éÒ¡ÃÍ¡ÍÕàÁÅìäÁè¶Ù¡µéÍ§
if(!preg_match("/.+@.+\..+/i", $email)){
//if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)$",$email)){
$showmsg="<br><br><center><font size='3' face='MS Sans Serif'><b>"._MEMBER_MOD_CHEMAIL_CONF."</b></font><br><br>
<input type='button' value='"._MEMBER_MOD_FORM_JAVA_RETERN."' onclick='history.back();'></center>" ;
	showerror($showmsg);
}

	//Check Pic Size
	$FILE = $_FILES['FILE'];
	//á»Å§¹ÒÁÊ¡ØÅ áÅÐ·Ó¡ÒÃ upload
	if ( empty($FILE['tmp_name']))
			{$Filenames = $member_pic ;} 
			else {
	$size = getimagesize($FILE['tmp_name']);
	$sizezz=$size[0]*$size[1];
	$widths = $size[0];
	$heights = $size[1];
	if ( $FILE['size'] > _MEMBER_LIMIT_UPLOAD ) {
	$showmsg="<br><br><center><font size='3' face='MS Sans Serif'><b>"._MEMBER_MOD_FORM_PIC_NOWIDTH." ".(_MEMBER_LIMIT_UPLOAD/1024)." kB "._MEMBER_MOD_FORM_PIC_NOWIDTH1."</b></font><br><br>
	<input type='button' value='"._MEMBER_MOD_FORM_JAVA_RETERN."' onclick='history.back();'></center>" ;
	showerror($showmsg);
	echo "<meta http-equiv='refresh' content='2; url=?name=admin&file=member'>" ;
	exit();
	} 

if (($FILE['type']=='image/jpg') || ($FILE['type']=='image/jpeg') || ($FILE['type']=='image/pjpeg') || ($FILE['type']=='image/JPG') || ($FILE['type']=='image/gif') || ($FILE['type']=='image/x-png') || ($FILE['type']=='image/png')){
//$sqlnew="select * from ".TB_MEMBER." where member_id='$member_id'";
//$result=mysql_db_query($db,$sqlnew);
$resmember = $db->select_query("SELECT * FROM ".TB_MEMBER." WHERE member_id='$member_id' ");

while ($r=mysql_fetch_array($resmember)) {
	$image=$r[member_pic];
	if ($image) {
	if (file_exists("icon/$image")) {
	unlink("icon/$image");
	} }
}

	if ($widths > _MEMBER_LIMIT_PICWIDTH) {
		$images = $FILE["tmp_name"];
		$new_images = "members_".TIMESTAMP."_".$FILE["name"];
		@copy($FILE["tmp_name"],"icon/members_".TIMESTAMP."_".$FILE["name"]);
		$original_image = "icon/members_".TIMESTAMP."_".$FILE["name"]."";
		$width=_MEMBER_LIMIT_PICWIDTH; 
//		$size=GetimageSize($images);
		$im=$widths/$width;
		$imheight=$heights/$im;
		$image = new hft_image($original_image);
		$image->resize($width,$imheight,  '0');
		if (($FILE['type']=='image/jpg') || ($FILE['type']=='image/jpeg') || ($FILE['type']=='image/pjpeg') || ($FILE['type']=='image/JPG')){
		$image->output_resized("icon/members_".TIMESTAMP."_".$FILE["name"]."", "JPG");
		}
		if (($FILE['type']=='image/gif')){
		$image->output_resized("icon/members_".TIMESTAMP."_".$FILE["name"]."", "GIF");
		}
		if (($FILE['type']=='image/x-png')|| ($FILE['type']=='image/png')){
		$image->output_resized("icon/members_".TIMESTAMP."_".$FILE["name"]."", "PNG");
		}
		$Filenames="members_".TIMESTAMP."_".$FILE["name"]."";
} else {
@copy ($FILE['tmp_name'] , "icon/members_".TIMESTAMP."_".$FILE["name"] );
$Filenames="members_".TIMESTAMP."_".$FILE["name"]."";
}
	} else {
	$showmsg="<br><br><center><font size='3' face='MS Sans Serif'><b>"._MEMBER_MOD_FORM_JAVA_TYPE_PIC."</b></font><br><br>
	<input type='button' value='"._MEMBER_MOD_FORM_JAVA_RETERN."' onclick='history.back();'></center>" ;
	showerror($showmsg);
	exit();
	}
}
$signup = date("j/n/").(date("Y")+543) ;

$textshow = htmlspecialchars($textshow) ;
$name = htmlspecialchars($name) ;
$address = htmlspecialchars($address) ;
$zipcode = htmlspecialchars($zipcode) ;
$phone = htmlspecialchars($phone) ;

       // for($i=0;$i<21;$i++) {
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET user='$username' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET name='$name' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET sex='$sex' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET date='$date' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET month='$month' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET year='$year' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET work='$work' WHERE id = '".$user['id']."'") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET age='$age' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET address='$address' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET amper='$amper' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET province='$province' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET zipcode ='$zipcode' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET phone='$phone' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET education='$education' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET work='$work' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET member_pic='$Filenames' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET office='$office' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET signature='$signature' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET nic_name='$nic_name' WHERE id = '".$user['id']."' ") ;
	$result =  $db->select_query("UPDATE ".TB_MEMBER." SET email='$email' WHERE id = '".$user['id']."' ") ;
       // }

	// Reset session
	if (isset($_SESSION['admin_user'])) {
		$_SESSION['admin_user'] = $username;
	}else{
		$_SESSION['login_true'] = $username;
	}

if($result) {
echo "<br><br><center><font size=\"3\" face='MS Sans Serif'><b>"._MEMBER_MOD_EDIT_ACCESS."</b></font></center>" ;
echo "<meta http-equiv='refresh' content='2; url=?name=member&file=member_detail'>" ;
}


?>
            
            <P>&nbsp;</P>
          <P>&nbsp;</P></TD>
      </TR>
    </TABLE></TD>
  </TR>
</TABLE>

