<?php
CheckAdmin($admin_user, $admin_pwd);
include ("editor.php");
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);

?>
<TABLE cellSpacing=0 cellPadding=0 width=820 border=0>
	<TBODY>
		<TR>
			<TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
				<TD width="810" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
					<!-- Admin -->
					&nbsp;&nbsp;<IMG SRC="images/menu/textmenu_video.gif" BORDER="0"><BR>
						<TABLE width="800" align=center cellSpacing=0 cellPadding=0 border=0>
							<TR>
								<TD height="1" class="dotline"></TD>
							</TR>
							<TR>
								<TD>
									<BR>
									<B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main"><?=_ADMIN_GOBACK;?></A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; video </B>
									<BR><BR>
									<A HREF="?name=admin&file=video2"><IMG SRC="images/admin/open.gif"  BORDER="0" align="absmiddle"> <?=_VIDEO_MOD_MENU_MAIN;?> </A> &nbsp;&nbsp;&nbsp;
									<A HREF="?name=admin&file=video_youtube2"><IMG SRC="images/admin/7_40.gif"  BORDER="0" align="absmiddle"> <?=_ADMIN_VIDEO_MENU_ADD_NEW_YOUTUBE;?>  </A>&nbsp;&nbsp;&nbsp;
									<A HREF="?name=admin&file=video_category2"><IMG SRC="images/admin/folders.gif"  BORDER="0" align="absmiddle"> <?=_ADMIN_MENU_DTAIL_CAT;?></A>  &nbsp;&nbsp;&nbsp;
									<A HREF="?name=admin&file=video_category2&op=videocat_add"><IMG SRC="images/admin/opendir.gif"  BORDER="0" align="absmiddle"> <?=_ADMIN_MENU_ADD_CAT;?></A><BR><BR>
									<?php

									//////////////////////////////////////////// แสดงรายการvideo
									if($op == ""){?>
										<FORM NAME="myform" METHOD=POST enctype="multipart/form-data" ACTION="?name=admin&file=video_youtube2&op=video_add&action=add">
											<table border=1 bgcolor=#F7F7F7 bordercolor=#FFFFFF width=700 class="grids">
												<tr>
													<td align="right" width="140"><?=_ADMIN_VIDEO_FORM_SELECT_CAT;?></td>
													<td>
														<SELECT id="CATEGORY" NAME="CATEGORY" >
															<?php
															$res['category'] = $db->select_query("SELECT * FROM web_video_category2 ORDER BY sort ");
															while ($category = $db->fetch($res['category'])){
																?>
																<option value="<?=$category['id'];?>"><?=$category['category_name'];?></option>
																<?php
															}
															?>
														</SELECT>
													</td>
												</tr>
												<tr>
													<td align="right" width="140"  valign="top"><?=_ADMIN_VIDEO_YOUTUBE_FROM_JAK;?></td>
													<td>
														<input id="youtube" name="youtube" type="text" size="60"/><br>
														<font color="#990000">[ <?=_ADMIN_VIDEO_YOUTUBE_FROM_URL_COM;?> ]</font>
													</td>
												</tr>
												<tr>
													<td></td>
													<td>
														<INPUT TYPE="checkbox" NAME="ENABLE_COMMENT" VALUE="1"> <?=_ADMIN_LINK_ALLOW_COMMENT;?>
													</td>
												</tr>
											</table>
											<INPUT id="admin" TYPE="hidden" NAME="admin" size="40" value="<?=$_SESSION['admin_user'];?>">
											<input type="submit" value="<?=_ADMIN_VIDEO_YOUTUBE_BUTTON_ADD;?>" name="submit">
											<input type="reset" value="<?=_ADMIN_BUTTON_CLEAR;?>" name="reset">
										</FORM>
									<?php
									} else if($op == "video_add" AND $action == "add"){

										/**
										 * READ MORE
										 * http://stackoverflow.com/questions/2068344/how-do-i-get-a-youtube-video-thumbnail-from-the-youtube-api
										 */
										
										
										//////////////////////////////////////////// กรณีเพิ่ม Database
										if(CheckLevel($admin_user, $op)){
											//	$Text= "http://www.youtube.com/watch?v=jOhptygCa5s";

											$youtube_id = youtubeID($_POST['youtube']);
											$category = input('CATEGORY');
											$comment = input('ENABLE_COMMENT', 0);
											
											if ( $category === false OR $youtube_id === false ){
												?>
												<script type="text/javascript">
													alert('<?=_JAVA_DATA_NULL;?>');
													javascript:history.back();
												</script>
												<?php
												exit();
											}
											
											$api_key = 'AIzaSyBfLZQBnJqdgk7b1NsHQbKOA8Qc6q5zoUE';
											$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$youtube_id&key=$api_key";
											$data = file_get_contents($url);
											$json = json_decode($data);
											$youtube = $json->items['0']->snippet;
											
											$title = utf8_to_tis620($youtube->title);
											$detail= utf8_to_tis620(htmlspecialchars($youtube->description, ENT_QUOTES));
											$posted = utf8_to_tis620($youtube->channelTitle);
											$times = strtotime($youtube->publishedAt);
											$duration = 0;
											
											$db->add_db("web_video2",array(
												"category" => $category,
												"topic" => $title,
												"detail" => $detail,
												"posted" => $posted,
												"post_date" => $times,
												"pic" => "http://img.youtube.com/vi/$youtube_id/mqdefault.jpg",
												"video" => $youtube_id,
												"enable_comment" => $comment,
												"youtube" => "1",
												"times" => $duration
											));

											$ProcessOutput = "<BR><BR>";
											$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
											$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_YOUTUBE_MESSAGE_ADD."</B></FONT><BR><BR>";
											$ProcessOutput .= "<A HREF=\"?name=admin&file=video_youtube2\"><B>"._ADMIN_VIDEO_YOUTUBE_MESSAGE_GOBACK."</B></A>";
											$ProcessOutput .= "</CENTER>";
											$ProcessOutput .= "<BR><BR>";

										}else{
											//กรณีไม่ผ่าน
											$ProcessOutput = $PermissionFalse ;
										}
										echo $ProcessOutput ;
										
										
									} else if($op == "video_edit" AND $action == "edit"){
										if(CheckLevel($admin_user,$op)){

											$id = intval($_GET['id']);
											$youtube_id = youtubeID($_POST['youtube']);

											$category = input('CATEGORY');
											$comment = input('ENABLE_COMMENT', 0);
											
											if ( $category === false OR $youtube_id === false ){
												?>
												<script type="text/javascript">
													alert('<?=_JAVA_DATA_NULL;?>');
													javascript:history.back();
												</script>
												<?php
												exit();
											}

											$api_key = 'AIzaSyBfLZQBnJqdgk7b1NsHQbKOA8Qc6q5zoUE';
											$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$youtube_id&key=$api_key";
											$data = file_get_contents($url);
											$json = json_decode($data);
											$youtube = $json->items['0']->snippet;
											
											$title = utf8_to_tis620($youtube->title);
											$detail= utf8_to_tis620(htmlspecialchars($youtube->description, ENT_QUOTES));
											$posted = utf8_to_tis620($youtube->channelTitle);
											$times = strtotime($youtube->publishedAt);
											$duration = 0;
											
											$update = $db->update_db("web_video2",array(
												"category" => $category,
												"topic" => $title,
												"detail" => $detail,
												"posted" => $posted,
												"post_date" => $times,
												"pic" => "http://img.youtube.com/vi/$youtube_id/mqdefault.jpg",
												"video" => $youtube_id,
												"enable_comment" => $comment,
												"youtube" => "1",
											)," id='$id'");
											
											$ProcessOutput = "<BR><BR>";
											$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
											$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_YOUTUBE_MESSAGE_EDIT."</B></FONT><BR><BR>";
											$ProcessOutput .= "<A HREF=\"?name=admin&file=video_youtube2\"><B>"._ADMIN_VIDEO_YOUTUBE_MESSAGE_GOBACK."</B></A>";
											$ProcessOutput .= "</CENTER>";
											$ProcessOutput .= "<BR><BR>";

										}else{
											//กรณีไม่ผ่าน
											$ProcessOutput = $PermissionFalse ;
										}
										echo $ProcessOutput ;
									}
											else if($op == "video_edit" ){
												?>
												<FORM NAME="myform" METHOD=POST enctype="multipart/form-data" ACTION="?name=admin&file=video_youtube2&op=video_edit&action=edit&id=<?=$_GET['id'];?>">
													<center><table border=1 bgcolor=#F7F7F7 bordercolor=#FFFFFF width=700><tr><td  align="right" width="140"><?=_ADMIN_VIDEO_FORM_SELECT_CAT;?></td><td>
														<SELECT id="CATEGORY" NAME="CATEGORY" >
															<?php
															// $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
															$res['video'] = $db->select_query("SELECT * FROM web_video2 WHERE id='".$_GET['id']."' ");
															$arr['video'] = $db->fetch($res['video']);

															$res['category'] = $db->select_query("SELECT * FROM web_video_category2 ORDER BY sort ");
															while ($arr['category'] = $db->fetch($res['category'])){
																echo "<option value=\"".$arr['category']['id']."\"";
																if($arr['category']['id'] == $arr['video']['category']){echo " Selected";}
																echo ">".$arr['category']['category_name']."</option>";
															}
															// $db->closedb ();

															?>
														</SELECT>
													</td></tr>
													<tr><td align="right" width="140"  valign="top"><?=_ADMIN_VIDEO_YOUTUBE_FROM_JAK;?> </td><td>
														<input id="youtube" name="youtube" type="text" size="60" value="<?php echo "http://www.youtube.com/watch?v=".$arr['video']['video']."";?>"><br><font color="#990000">[ <?=_ADMIN_VIDEO_YOUTUBE_FROM_URL_COM;?> ]</font>
													</td>
												</tr>
												<tr><td></td><td ><INPUT TYPE="checkbox" NAME="ENABLE_COMMENT" VALUE="1"> <?=_ADMIN_LINK_ALLOW_COMMENT;?>
												</td></tr>
											</table>
											<INPUT id="admin" TYPE="hidden" NAME="admin" size="40" value="<?=$_SESSION['admin_user'];?>">
												<input type="submit" value="<?=_ADMIN_VIDEO_BUTTON_EDIT;?>" name="submit"> <input type="reset" value="<?=_ADMIN_BUTTON_CLEAR;?>" name="reset">
											</FORM>

											<?php

										}
										else if($op == "video_del" ){
											if(CheckLevel($admin_user,$op)){
												// $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
												$db->del("web_video2"," id='".$_GET['id']."' ");
												// $db->closedb ();
												$ProcessOutput = "<BR><BR>";
												$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
												$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_YOUTUBE_MESSAGE_DEL."</B></FONT><BR><BR>";
												$ProcessOutput .= "<A HREF=\"?name=admin&file=video_youtube2\"><B>"._ADMIN_VIDEO_YOUTUBE_MESSAGE_GOBACK."</B></A>";
												$ProcessOutput .= "</CENTER>";
												$ProcessOutput .= "<BR><BR>";

											}else{
												//กรณีไม่ผ่าน
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
