<?php
CheckAdmin($admin_user, $admin_pwd);
?>
<TABLE cellSpacing=0 cellPadding=0 width=820 border=0>
	<TBODY>
		<TR>
			<TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
				<TD width="810" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
					<!-- Admin -->
					&nbsp;&nbsp;<IMG SRC="images/menu/textmenu_admin.gif" BORDER="0"><BR>
						<TABLE width="800" align=center cellSpacing=0 cellPadding=5 border=0>
							<TR>
								<TD height="1" class="dotline"></TD>
							</TR>
							<TR>
								<TD>
									<BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main"><?=_ADMIN_GOBACK;?></A></b>
										<BR><BR>
											<A HREF="?name=admin&file=config"><IMG SRC="images/admin/open.gif"  BORDER="0" align="absmiddle"> <?=_ADMIN_CONFIG_MENU_INDEX;?></A> <BR><BR>
												<?php
												//////////////////////////////////////////// �ʴ���¡�â������ / ��Ъ�����ѹ��
												if($op == ""){
													$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
													?>
													<table width="100%" border="0" cellspacing="0" cellpadding="0" class="grids">
														<tr class="odd">
															<td width="180" scope="col"><CENTER><B><?=_ADMIN_CONFIG_TABLE_TUM;?></B></CENTER></td>
															<td scope="col"><CENTER><B><?=_ADMIN_CONFIG_TABLE_SAMPLE;?></B></td>
																<td width="90" scope="col"><CENTER><B>width (px)</B></CENTER></td>
																<td width="90" scope="col"><CENTER><B>height (px)</B></CENTER></td>
																<td width="80" scope="col"><CENTER><B><?=_ADMIN_CONFIG_TABLE_CAT;?></B></CENTER></td>
															</tr>
															<?php
															$res['config'] = $db->select_query("SELECT * FROM ".TB_CONFIG.",".TB_TEMPLATES." where  name=temname and sort between 1 and 3 ");
															$i=1;
															$count=0;
															while($arr['config'] = $db->fetch($res['config'])){
																$res['category'] = $db->select_query("SELECT * FROM ".TB_CONFIG_CAT." WHERE id='".$arr['config']['sort']."' ");
																$arr['category'] = $db->fetch($res['category']);
																//Comment Icon
																if($count%2==0) { //��ǹ�ͧ��� ��Ѻ��
																	$ColorFill = "";
																} else {
																	$ColorFill = 'class="odd"';
																}
																?>
																<tr <?php echo $ColorFill; ?>>
																	<td valign="top" align="center">
																		<a href="javascript:Confirm('?name=admin&file=config&op=config_del&tem=<?=$arr['config']['name'];?>&id=<?php echo $arr['config']['sort'];?>','<?=_ADMIN_BUTTON_DEL_MESSAGE;?>');"><img src="images/admin/trash.gif"  border="0" alt="<?=_ADMIN_BUTTON_DEL;?>" ></a><br><font color="#CC0000"><b>
																			<?php echo $arr['category']['category_name'];?></b></font></td>
																			<td valign="top">
																				<?php
																				$types=$arr['config']['type'];
																				if ($types="application/x-shockwave-flash" ) {
																					?>
																					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<?=($arr['config']['width'])/2;?>" height="<?=($arr['config']['height'])/2;?>">
																						<param name="movie" value="templates/<?=WEB_TEMPLATES;?>/images/config/<?=$arr['config']['picname'];?>" />
																						<param name="quality" value="high" />
																						<embed src="templates/<?=WEB_TEMPLATES;?>/images/config/<?=$arr['config']['picname'];?>"
																							quality="height"
																							type="application/x-shockwave-flash"
																							width="<?=($arr['config']['width'])/2;?>"
																							height="<?=($arr['config']['height'])/2;?>"
																							pluginspage="http://www.macromedia.com/go/getflashplayer" />
																						</object>
																						<?php
																					} else {
																						?>
																						<img src="images/config/<?=$arr['config']['picname'];?>"  width="50%" height="50%" border="0">

																						<?php
																					}
																					?></td>
																					<td align="center" valign="top"><?php echo $arr['config']['width'];?></td>
																					<td align="center" valign="top"><?php echo $arr['config']['height'];?></td>
																					<td align="center" valign="top"><?php echo $arr['config']['type'];?></td>
																				</tr>

																				<?php
																				$count++;
																				$i++;
																			}
																			?>
																		</table><br>
																		<?php
																		$paths="".WEB_PATH."/templates/".WEB_TEMPLATES."/images/config/";
																		//////////////////////////////////////////// �ʴ���¡�â������ / ��Ъ�����ѹ��
																		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																		$res['configs'] = $db->select_query("SELECT * FROM ".TB_CONFIG."  ORDER BY id ");
																		$sd=1;
																		while($arr['configs'] = $db->fetch($res['configs'])){
																			if ($arr['configs']['posit']=='title'){ $titlex=$arr['configs']['name'];}
																			if ($arr['configs']['posit']=='url'){ $urlx=$arr['configs']['name'];}
																			if ($arr['configs']['posit']=='path'){ $pathx=$arr['configs']['name'];}
																			if ($arr['configs']['posit']=='footer1'){ $footer1x=$arr['configs']['name'];}
																			if ($arr['configs']['posit']=='footer2'){ $footer2x=$arr['configs']['name'];}
																			if ($arr['configs']['posit']=='email'){ $emailx=$arr['configs']['name'];}
																			if ($arr['configs']['posit']=='templates'){ $templatesx=$arr['configs']['name'];}
																			$sd++;
																		}
																		$res['configs'] = $db->select_query("SELECT * FROM ".TB_CONFIG.",".TB_TEMPLATES." where  name=temname and sort='2' ");
																		$arr['configs'] = $db->fetch($res['configs']);
																		?>
																		<table width="100%" cellspacing="2" cellpadding="1" bgcolor="#FFFFCC" >
																			<tr>

																				<!--����Ѻ����Ѿ��Ŵ-->
																				<form method="post" name="form" id="form" action="?name=admin&file=config&op=config_add&action=add" enctype="multipart/form-data">
																					<td align=left><?=_ADMIN_CONFIG_FORM_TOPMINI;?> :</td><td><input type="file" name="fileupload0" class="orenge" size="40"><br> ( <?=_ADMIN_CONFIG_FORM_COMMENT;?> <font color="#CC0000"><b><?=$arr['configs']['width'];?></b></font> px)</td></tr>
																					<td align=left><?=_ADMIN_CONFIG_FORM_TOPBIG;?> :</td><td><input type="file" name="fileupload1" class="orenge" size="40"><br> ( <?=_ADMIN_CONFIG_FORM_COMMENT;?> <font color="#CC0000"><b><?=$arr['configs']['width'];?></b></font> px)</td></tr>
																					<td align=left><?=_ADMIN_CONFIG_FORM_FOOTER;?> :</td><td><input type="file" name="fileupload2" class="orenge" size="40"><br> ( <?=_ADMIN_CONFIG_FORM_COMMENT;?> <font color="#CC0000"><b><?=$arr['configs']['width'];?></b></font> px)</td></tr>

																				</td>
																			</tr>
																		</table><br>
																		<table width="100%" cellspacing="2" cellpadding="1" border="0">
																			<tr>
																				<td align="center">
																					<table  width="100%" cellspacing="2" cellpadding="2" bgcolor="#F4F4F4">
																						<tr>
																							<td align="right"  width="120"><?=_ADMIN_CONFIG_FORM_MESSAGE_TITLE;?>:</td><td><input type="input" name="TITLE" size="100" value="<?=$titlex;?>"> </td></tr>
																							<td align="right"  width="120"><?=_ADMIN_CONFIG_FORM_MESSAGE_URL;?> :</td><td><input type="input" name="URL" size="60" value="<?=$urlx;?>"></td></tr>
																							<td align="right"  width="120"><?=_ADMIN_CONFIG_FORM_MESSAGE_PATH;?>:</td><td><input type="input" name="PATH" size="60" value="<?=$pathx;?>"></td></tr>
																							<td align="right"  width="120"><?=_ADMIN_CONFIG_FORM_MESSAGE_FOOTER1;?>:</td><td><input type="input" name="FOOTER1" size="100" value="<?=$footer1x;?>"></td></tr>
																							<td align="right"  width="120"><?=_ADMIN_CONFIG_FORM_MESSAGE_FOOTER2;?>:</td><td><input type="input" name="FOOTER2" size="100" value="<?=$footer2x;?>"></td></tr>
																							<td align="right"  width="120"><?=_ADMIN_CONFIG_FORM_MESSAGE_EMAIL_ADMIN;?>:</td><td><input type="input" name="EMAIL" size="60" value="<?=$emailx;?>"></td></tr>
																							<td align="right"  width="120" valign=top>Templates :</td><td valign=top>
																								<SELECT name="picture"  id="picture" onChange="showimage()" />
																								<?php

																								if ($handle = opendir("templates")) {
																									while (false !== ($item = readdir($handle))) {
																										if ($item != "." && $item != ".." && $item != "Thumbs.db") {
																											echo "<option value=".$item." ";
																											if($templatesx==$item){ echo "selected";}
																											echo ">$item</option>";
																										}
																									}
																									closedir($handle);
																								}

																								?>
																							</select>
																							<script language="javascript">
																							function showimage()
																							{
																								if (!document.images)
																									return
																									document.images.pictures.src="templates/"+document.form.picture.options[document.form.picture.selectedIndex].value+"/thumbnail.png";
																								}
																								//-->
																								</script>

																								<br><a href="javascript:linkrotate(document.form.picture.selectedIndex)" onMouseover="window.status='';return true"><img src="templates/<?=$templatesx;?>/thumbnail.png" name="pictures" border=0></a>
																							</td></tr>
																						</td>
																					</tr>
																				</table>
																			</td>

																		</tr>
																		<tr>
																			<td colspan="2" align="center"><input type="submit" name="Submit" value="<?=_ADMIN_CONFIG_FORM_BUTTON_EDIT;?>" class="orenge"></d>
																			</tr>
																		</table>

																	</form>
																	<?php
																}
																else if($op == "config_add" AND $action == "add"){
																	//////////////////////////////////////////// �ó������ Database
																	if(CheckLevel($admin_user,$op)){
																		$fileuploads = array();
																		$fileuploads[] = empty($_FILES['fileupload0']) ? '' : $_FILES['fileupload0'];
																		$fileuploads[] = empty($_FILES['fileupload1']) ? '' : $_FILES['fileupload1'];
																		$fileuploads[] = empty($_FILES['fileupload2']) ? '' : $_FILES['fileupload2'];

																		$ProcessOutput = "<BR><BR>";
																		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																		$count_files = count($fileuploads);
																		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																		for ( $i = 0; $i < $count_files; $i++) {

																			$config_file = $fileuploads[$i];

																			// If not an error
																			if ($config_file['error'] == UPLOAD_ERR_OK ){

																				$a = $i+1;

																				$size = getimagesize($config_file['tmp_name']);
																				$width = $size[0];
																				$height = $size[1];
																				if ($width > _TEMPLATES_WIDTH_CONFIG) {
																					$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_CONFIG_MESSAGE_LIMIT_WIDTH_PIC." ".$config_file['name']." "._ADMIN_CONFIG_MESSAGE_LIMIT_WIDTH_PIC1." "._TEMPLATES_WIDTH_CONFIG." px</B></FONT><BR><BR>";
																					$ProcessOutput .= "<BR><BR>";

																				} else if($config_file['size'] > _CONFIG_LIMIT_UPLOAD){
																					$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_LINK_PICTURE."  ".$config_file['name']." "._ADMIN_CONFIG_MESSAGE_LIMIT_SIZE_PIC." ".(_CONFIG_LIMIT_UPLOAD/1024)." kbyte</B></FONT><BR><BR>";
																					$ProcessOutput .= "<BR><BR>";

																				} else {

																					$query = $db->select_query("SELECT * FROM ".TB_TEMPLATES." WHERE sort='".$a."' and temname='".$_POST['picture']."' ");
																					$tem = $db->fetch($query);

																					// Update
																					if (!empty($tem['sort'])){
																						// Remove old file
																						@unlink("templates/".WEB_TEMPLATES."/images/config/".$tem['picname']);
																						$db->update_db(TB_TEMPLATES,array(
																							"picname" => $config_file['name'],
																							"width" => $width,
																							"height" => $height,
																							"type" => $config_file['type'],
																						)," sort='".$a."' and temname='".$_POST['picture']."'");
																					} else {
																						$db->add_db(TB_TEMPLATES,array(
																							"temname" => $_POST['picture'],
																							"picname" => $config_file['name'],
																							"width" => $width,
																							"height" => $height,
																							"type" => $config_file['type'],
																							"sort" => $a
																						));
																					}
																					move_uploaded_file($config_file['tmp_name'], 'templates/'.WEB_TEMPLATES.'/images/config/'.$config_file['name']);

																				}
																			}
																		}

																		$db->update_db(TB_CONFIG,array(
																			"name" => strip_tags($_POST['TITLE'])
																		)," posit='title' ");

																		$db->update_db(TB_CONFIG,array(
																			"name" => strip_tags($_POST['URL'])
																		)," posit='url' ");

																		$db->update_db(TB_CONFIG,array(
																			"name" => $_POST['PATH']
																		)," posit='path' ");

																		$db->update_db(TB_CONFIG,array(
																			"name" => strip_tags($_POST['FOOTER1'])
																		)," posit='footer1' ");

																		$db->update_db(TB_CONFIG,array(
																			"name" => strip_tags($_POST['FOOTER2'])
																		)," posit='footer2' ");

																		$db->update_db(TB_CONFIG,array(
																			"name" => strip_tags($_POST['EMAIL'])
																		)," posit='email' ");

																		$db->update_db(TB_CONFIG,array(
																			"name" => $_POST['picture']
																		)," posit='templates' ");

																		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_CONFIG_MESSAGE_EDIT_REPORT."</B></FONT><BR><BR>";
																		$ProcessOutput .= "<meta http-equiv='refresh' content='1; url=?name=admin&file=config'>";
																		$ProcessOutput .= "<A HREF=\"?name=admin&file=config\"><B>"._ADMIN_CONFIG_MESSAGE_GOBACK."</B></A>";
																		$ProcessOutput .= "</CENTER>";
																		$ProcessOutput .= "<BR><BR>";

																	}else{
																		$ProcessOutput = $PermissionFalse ;
																	}
																	echo $ProcessOutput ;
																}
																else if($op == "config_del"){
																	//////////////////////////////////////////// �ó�ź Form
																	if(CheckLevel($admin_user,$op)){
																		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																		//		$db->del(TB_DOWNLOAD," id='".$_GET['id']."' ");
																		$res['tem'] = $db->select_query("SELECT * FROM ".TB_TEMPLATES." WHERE sort='".$_GET['id']."' and temname='".$_GET['tem']."' ");
																		$arr['tem'] = $db->fetch($res['tem']);
																		$db->del(TB_TEMPLATES," sort='".$_GET['id']."' and temname='".$_GET['tem']."' ");
																		$db->closedb ();
																		@unlink("templates/".WEB_TEMPLATES."/images/config/".$arr['tem']['picname']."");

																		$ProcessOutput = "<BR><BR>";
																		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_CONFIG_MESSAGE_DEL_REPORT."</B></FONT><BR><BR>";
																		$ProcessOutput .= "<meta http-equiv='refresh' content='1; url=?name=admin&file=config'>";
																		$ProcessOutput .= "<A HREF=\"?name=admin&file=config\"><B>"._ADMIN_CONFIG_MESSAGE_GOBACK."</B></A>";
																		$ProcessOutput .= "</CENTER>";
																		$ProcessOutput .= "<BR><BR>";
																	}else{
																		//�ó������ҹ
																		$ProcessOutput = $PermissionFalse ;
																	}
																	echo $ProcessOutput ;
																}
																?>
																<BR><BR>
																</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
											</TABLE>
