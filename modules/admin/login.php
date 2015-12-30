<?php

$username = input('username');
$password = input('password');
var_dump($username);

if(USE_CAPCHA){
	if($_SESSION['security_code'] != $_POST['security_code'] OR empty($_POST['security_code'])) {
		echo "<script language='javascript'>" ;
		echo "alert('"._JAVA_CAPTCHA_NOACC."')" ;
		echo "</script>" ;
		echo "<script language='javascript'>javascript:history.go(-1)</script>";
		exit();
	}
}

$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$sql = "SELECT * FROM ".TB_ADMIN." WHERE username = '$username' AND password='".md5($password)."'; ";
$query = $db->select_query($sql); 
$admin_rows = $db->rows($query); 

//Can Login
if( $admin_rows > 0 ){
	
	$admin = $db->fetch($query);
	
	//Login ผ่าน
	
	$_SESSION['admin_user'] = $username ;
	$_SESSION['admin_pwd'] = md5($password) ;
	$admin_user=$_SESSION['admin_user'];
	$admin_pwd=$_SESSION['admin_pwd'];
	$_SESSION['CKFinder_UserRole'] ='admin';
	$_SESSION['ua'] = $_SESSION['admin_user'].":".$_SERVER['HTTP_USER_AGENT'].":".$IPADDRESS.":".$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	
	$timeoutseconds=20*60*60;
	$_SESSION['timestamp2']=time();
	$timeout=$_SESSION['timestamp2'] + $timeoutseconds;
	//////////////////////		 เพิ่ม  สมาชิกออนไลน์   ////////////////////////////
	
	$query = $db->select_query("SELECT * FROM ".TB_useronline." WHERE useronline='".$_SESSION['admin_user']."' ");
	$user2_rows = $db->rows($query); 
	if($user2_rows){
		$db->update_db(TB_useronline,array(
			"post_date" => $_SESSION['timestamp2'],
			"timeout" => $timeout,
			"ip" => $IPADDRESS
		)," useronline = '".$_SESSION['admin_user']."' ");
	}else{
		$db->add_db(TB_useronline,array(
			"post_date" => $_SESSION['timestamp2'],
			"useronline" => $_SESSION['admin_user'],
			"timeout" => $timeout,
			"ip" => $IPADDRESS
		));
	}
	echo "<meta http-equiv='refresh' content='0; url=?name=admin&file=main'>" ;

}else{
	//Login ไม่ผ่าน
	
?>
<TR>
	<TD width="720" vAlign=top align=left>
		<BR>
		<TABLE width="700" align=center cellSpacing=0 cellPadding=0 border=0>
			<TR>
				<TD>
					<TABLE cellSpacing=0 cellPadding=0 width=820 border=0>
						<TR>
							<td vAlign=top align=center class="login" align="center">
								<FONT COLOR="#990000" size="3"><b><?=_ADMIN_LOGIN_MESSAGE_NOACC;?></b></font>
							</td>
						</tr>
						<TR>
							<TD vAlign=top align=center>
								<BR>
								<div id="maincontent">
									<div id="loginform">
										<h2>Admin<span class="gray">istrator ! login</span></h2>
										<form name="login" id="login" method="post" action="?name=admin&file=login">
										
											<?=_ADMIN_MOD_INDEX_USER;?> :
											<input type="text" name="username" id="username" class="<?php echo $classbox[0]; ?>"  value="<?php echo $username; ?>"  onclick="this.value=''" /><br />
											<?=_ADMIN_MOD_INDEX_PASS;?> : 
											<input type="password" name="password" id="password" class="<?php echo $classbox[1]; ?>"  value="<?php echo $password; ?>"  onclick="this.value=''" /><br />
											<div>
												<?php if(USE_CAPCHA){ ?>
													<?php if(CAPCHA_TYPE == 1){ 
														echo "<img src=\"capcha/CaptchaSecurityImages.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
													}else if(CAPCHA_TYPE == 2){ 
														echo "<img src=\"capcha/val_img.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
													};?>&nbsp;
													<input name="security_code" type="text" id="security_code" class="<?php echo $classbox[1]; ?>" onclick="this.value=''" maxlength="10" size="10">
												<?php } ?>
											</div>
											<br>
											<input type="hidden" name="action" id="action" value="login"> 
											<input name="button" type="submit" class="button" id="button" value="<?=_ADMIN_MOD_BUTTON_ADD;?>"   />
											<input name="button2" type="button" class="button" id="button2" value="<?=_ADMIN_MOD_BUTTON_CANCLE;?>" onClick="window.location='index.php'" /><br />
										</form>
										<div style="line-height: 18px">
										<br />
										<?=_ADMIN_MOD_CREDIT_ATOM1;?> : <a href="http://maxtom.sytes.net"><font color="#3399FF"><b><?=_ADMIN_MOD_CREDIT_ATOM2;?></b></font></a><br>
										<?=_ADMIN_MOD_CREDIT_ATOM3;?>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</TABLE>

				</TD>
			</TR>
		</TABLE>
	</TD>
</TR>
<?php
} // End else
?>