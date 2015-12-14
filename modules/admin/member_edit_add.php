<?php
#### Ê¤ÃÔê»¹Õéãªéã¹¡ÒÃàªç¤ ÇèÒÅçÍ¡ÍÔ¹ËÃ×ÍÂÑ§ ãËé¹ÓÊ¤ÃÔê»¹Õéä»äÇé·ÕèË¹éÒ·Õè¤Ø³µéÍ§¡ÒÃãËéàªç¤ ####
//ÃÐººÊÁÒªÔ¡àÊÃÔÁ maxsite 1.10 ¾Ñ²¹Òâ´Â www.narongrit.net

CheckAdmin($admin_user, $admin_pwd);

	if(CheckLevel($admin_user,"member_edit")){
?>

	<TABLE cellSpacing=0 cellPadding=0 width=650 border=0>
      <TBODY>
        <TR><td>
		  <!-- Admin -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_admin.gif" BORDER="0"><BR>
				<TABLE width="650" align=center cellSpacing=0 cellPadding=0 border=0>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
				<TR>
					<TD>
		<?php 
require("includes/class.resizepic.php");
if($_GET['op'] == ""){
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
//ÃÐººÊÁÒªÔ¡àÊÃÔÁ maxsite 1.10 ¾Ñ²¹Òâ´Â www.narongrit.net
//echo $_POST['PASSWORD'];

$member_id=$_POST['member_id'];
$username=$_POST['USERNAME'];
$password=$_POST['PASSWORD'];
$oldpass=$_POST['oldpass'];
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
$signature=$_POST['signature'];

$sql = sprintf("SELECT * FROM `web_member` WHERE `user` = '%s'", $username);
$query = $db->select_query($sql);
$rows = $db->rows($query);
if ($_POST['USERNAME_OLD']!=$username && $rows > 0) {
	?>
	<script type="text/javascript">
		alert('<?php echo toTis620("ชื่อผู้ใช้งานซ้ำกับคนอื่น กรุณาตรวจสอบอีกครั้ง");?>');
		window.history.back(-1);
	</script>
	<?php
	exit();
}

// ¶éÒ¡ÃÍ¡ÍÕàÁÅìäÁè¶Ù¡µéÍ§
if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)$/i",$email)){
$showmsg="<br><br><center><font size='3' face='MS Sans Serif'><b>"._MEMBER_MOD_CHEMAIL_CONF."</b></font><br><br><input type='button' value='"._MEMBER_MOD_FORM_JAVA_RETERN."' onclick='history.back();'></center>" ;
	showerror($showmsg);
}

	if($_POST['PASSWORD']){
		$NewPass = md5($_POST['PASSWORD']);
	}else{
		$NewPass = $_POST['oldpass'];
	}

	//Check Pic Size
	$FILE = $_FILES['FILE'];

	//á»Å§¹ÒÁÊ¡ØÅ áÅÐ·Ó¡ÒÃ upload
	// if ( empty($FILE['tmp_name'])){
	if($FILE['error']==4){
		$Filenames = $member_pic ;
	}else{

		$size = @getimagesize($FILE['tmp_name']);
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
		$oldImage = $db->fetch($resmember);
		// 	var_dump($oldImage);
		// exit;

		@unlink("icon/".$oldImage['member_pic']);
		// while ($r=mysql_fetch_array($resmember)) {
		// 	$image=$r[member_pic];
		// 	if ($image) {
		// 		if (file_exists("icon/$image")) {
		// 			unlink("icon/$image");
		// 		} 
			
		// 	}
		// }

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
			echo "<script language='javascript'>" ;
			echo "alert('"._MEMBER_MOD_FORM_JAVA_TYPE_PIC."')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.go(-1)</script>";
			exit();
	}
}
// var_dump($Filenames);
// exit;
$signup = date("j/n/").(date("Y")+543) ;
$textshow = htmlspecialchars($textshow) ;
$name = htmlspecialchars($name) ;
$address = htmlspecialchars($address) ;
$zipcode = htmlspecialchars($zipcode) ;
$phone = htmlspecialchars($phone) ;

	$sql = array();
	    $sql[] = "UPDATE ".TB_MEMBER." SET name='$name' WHERE member_id='$member_id' ";
		
		$sql[]= "UPDATE ".TB_MEMBER." SET sex='$sex' WHERE member_id='$member_id' ";
		
		$sql[] = "UPDATE ".TB_MEMBER." SET date='$date' WHERE member_id='$member_id' ";
       
        $sql[] = "UPDATE ".TB_MEMBER." SET month='$month' WHERE member_id='$member_id' ";
               
        $sql[] = "UPDATE ".TB_MEMBER." SET year='$year' WHERE member_id='$member_id' ";
      
		$sql[] = "UPDATE ".TB_MEMBER." SET work='$work' WHERE member_id='$member_id'";
	
		$sql[] = "UPDATE ".TB_MEMBER." SET age='$age' WHERE member_id='$member_id' ";
	
		$sql[] = "UPDATE ".TB_MEMBER." SET email='$email' WHERE member_id='$member_id' ";
	
		$sql[] = "UPDATE ".TB_MEMBER." SET address='$address' WHERE member_id='$member_id' ";
	
		$sql[] = "UPDATE ".TB_MEMBER." SET amper='$amper' WHERE member_id='$member_id' ";
		
		$sql[] = "UPDATE ".TB_MEMBER." SET province='$province' WHERE member_id='$member_id' ";
	
	    $sql[] = "UPDATE ".TB_MEMBER." SET zipcode ='$zipcode' WHERE member_id='$member_id' ";

		$sql[] = "UPDATE ".TB_MEMBER." SET phone='$phone' WHERE member_id='$member_id' ";
	
		$sql[] = "UPDATE ".TB_MEMBER." SET education='$education' WHERE member_id='$member_id' ";
		
	   $sql[] = "UPDATE ".TB_MEMBER." SET work='$work' WHERE member_id='$member_id' ";
	   
	   $sql[] = "UPDATE ".TB_MEMBER." SET member_pic='$Filenames' WHERE member_id='$member_id' ";

  	   $sql[] = "UPDATE ".TB_MEMBER." SET office='$office' WHERE member_id='$member_id' ";

	   $sql[] = "UPDATE ".TB_MEMBER." SET signature='$signature' WHERE member_id='$member_id' ";

	   $sql[] = "UPDATE ".TB_MEMBER." SET nic_name='$nic_name' WHERE member_id='$member_id' ";

	   $sql[] = "UPDATE ".TB_MEMBER." SET user='$username' WHERE member_id='$member_id' ";

	   $sql[] = "UPDATE ".TB_MEMBER." SET password='".$NewPass."' WHERE member_id='$member_id' ";

       for($i=0;$i<21;$i++) {
      $result = mysql_query($sql[$i])  ;
       }

$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$MemResult = $db->select_query("SELECT * FROM ".TB_ADMIN." WHERE username='".$username."' ");
$EditMem= $db->fetch($MemResult);
$level=$EditMem['level'];

if ($EditMem){
			$db->update_db(TB_ADMIN,array(
				"username"=>"".$username."",
				"password"=>"".$NewPass."",
				"name"=>"".$_POST['name']."",
				"email"=>"".$_POST['email']."",
				"picture"=>"".$Filenames."",
				"level"=>"".$level.""
			)," username='".$_POST['USERNAME_OLD']."' ");

			// Reset session
			if (isset($_SESSION['admin_user'])) {
				$_SESSION['admin_user'] = $username;
			}else{
				$_SESSION['login_true'] = $username;
			}

			if($admin_user==$username){
				$URLre = "?name=admin&logout";
				// session_unset();
				// session_destroy();
			} else {
				$URLrx = "?name=admin&file=member";
			}
			$ProcessOutput = "<BR><BR>";
			$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_USER_MESSAGE_EDIT."</B></FONT><BR><BR>";
			$ProcessOutput .= "<A HREF=\"".$URLre."\"><B>"._ADMIN_USER_MESSAGE_CHPASS_GOBACK."</B></A><br><br>";
			$ProcessOutput .= "<A HREF=\"".$URLrx."\"><B>"._ADMIN_USER_MESSAGE_CHPASS_USER."</B></A>";
			$ProcessOutput .= "</CENTER>";
			$ProcessOutput .= "<BR><BR>";
			echo $ProcessOutput ;
} else {
			$URLre = "?name=admin&file=member";
echo "<br><br><center><font size=\"3\" face='MS Sans Serif'><b>"._MEMBER_MOD_EDIT_ACCESS."</b></font></center>" ;
echo "<meta http-equiv='refresh' content='2; url=$URLre'>" ;
}
}

}
?>

		  </TD>
      </TR>
    </TABLE>
	</TD>
  </TR>
</TABLE>
