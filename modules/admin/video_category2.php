<?php CheckAdmin($admin_user, $admin_pwd);
?>
<?php include ("editor.php");?>
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
					<BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> 
					<A HREF="?name=admin&file=main"><?php  echo _ADMIN_GOBACK;?></A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; video </B>
					<BR><BR>
					<A HREF="?name=admin&file=video2"><IMG SRC="images/admin/open.gif"  BORDER="0" align="absmiddle"> <?php  echo _VIDEO_MOD_MENU_MAIN;?> </A> &nbsp;&nbsp;&nbsp;
					<A HREF="?name=admin&file=video_youtube2"><IMG SRC="images/admin/7_40.gif"  BORDER="0" align="absmiddle"> <?php  echo _ADMIN_VIDEO_MENU_ADD_NEW_YOUTUBE;?>  </A>&nbsp;&nbsp;&nbsp;
					<A HREF="?name=admin&file=video_category2"><IMG SRC="images/admin/folders.gif"  BORDER="0" align="absmiddle"> <?php  echo _ADMIN_MENU_DTAIL_CAT;?></A>  &nbsp;&nbsp;&nbsp;
					<A HREF="?name=admin&file=video_category2&op=videocat_add"><IMG SRC="images/admin/opendir.gif"  BORDER="0" align="absmiddle"> <?php  echo _ADMIN_MENU_ADD_CAT;?></A>
					<BR><BR>
<?php //////////////////////////////////////////// �ʴ���¡��
if($op == ""){
?>
<form action="?name=admin&file=video_category2&op=videocat_del&action=multidel" name="myform" method="post">
 <table width="100%" cellspacing="0" cellpadding="0" class="grids">
  <tr class="odd">
   <td><B><CENTER>Option</CENTER></B></td>
   <td><B><CENTER><?=_ADMIN_FORM_CAT;?></CENTER></B></td>
   <td align="center" width="50"><B><?=_ADMIN_FORM_CAT_COUNT;?></B></td>
   <td align="center" width="50"><B><?=_ADMIN_FORM_CAT_ORDER;?></B></td>
   <td><B><CENTER>Check</CENTER></B></td>
  </tr>  
<?php $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['videocat'] = $db->select_query("SELECT * FROM web_video_category2 ORDER BY sort ");
$rows['videocat'] = $db->rows($res['videocat']);
$CATCOUNT = 0 ;
$count=0;
while ($arr['videocat'] = mysql_fetch_array($res['videocat'])){
	$row['sumvideo'] = $db->num_rows("web_video2","id"," category=".$arr['videocat']['id']." ");

    $CATCOUNT ++ ;
   //��˹��������¹�ӴѺ���
   $SETSORT_UP = $arr['videocat']['sort']-1;
   if($CATCOUNT == "1"){
	   $SETSORT_UP = "1" ;
   }
	//��˹��������¹�ӴѺŧ
   $SETSORT_DOWN = $arr['videocat']['sort']+1;
   if($CATCOUNT == $rows['videocat']){
	   $SETSORT_DOWN = $arr['videocat']['sort'] ;
   }

if($count%2==0) { //��ǹ�ͧ��� ��Ѻ�� 
$ColorFill = ' onmouseover="this.style.backgroundColor=\'#FFF0DF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'"  ';
} else {
$ColorFill = 'class="odd"';
}

?>
    <tr <?php echo $ColorFill; ?> >
     <td width="44">
      <a href="?name=admin&file=video_category2&op=videocat_edit&id=<?php echo $arr['videocat']['id'];?>"><img src="images/admin/edit.gif" border="0" alt="<?=_ADMIN_BUTTON_EDIT;?>" ></a> 
      <a href="javascript:Confirm('?name=admin&file=video_category2&op=videocat_del&id=<?php echo $arr['videocat']['id'];?>','<?=_ADMIN_BUTTON_DEL_MESSAGE_CAT;?>');"><img src="images/admin/trash.gif"  border="0" alt="<?=_ADMIN_BUTTON_DEL;?>" ></a>
     </td> 
     <td><?php echo $arr['videocat']['category_name'];?></td>
	 <td align="center" width="50" ><?php echo $row['sumvideo'] ;?></td>
     <td align="center" width="50"><A HREF="?name=admin&file=video_category2&op=videocat_edit&action=sort&setsort=<?php echo $SETSORT_UP ;?>&move=up&id=<?php echo $arr['videocat']['id'];?>"><IMG SRC="images/icon/arrow_up.gif"  BORDER="0" ALT="<?=_ADMIN_ORDER_UP;?>"></A>&nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=video_category2&op=videocat_edit&action=sort&setsort=<?php echo $SETSORT_DOWN ;?>&move=down&id=<?php echo $arr['videocat']['id'];?>"><IMG SRC="images/icon/arrow_down.gif"  BORDER="0" ALT="<?=_ADMIN_ORDER_DOWN;?>"></A></td>
     <td valign="top" align="center" width="40"><input type="checkbox" name="list[']" value="<?php echo $arr['videocat']['id'];?>"></td>
    </tr>

<?php 	$count++;
 }
$db->closedb ();
?>
 </table>
 <div align="right">
 <input type="button" name="CheckAll" value="Check All" onclick="checkAll(document.myform)" >
 <input type="button" name="UnCheckAll" value="Uncheck All" onclick="uncheckAll(document.myform)" >
 <input type="hidden" name="ACTION" value="video_del">
 <input type="submit" value="Delete" onclick="return delConfirm(document.myform)">
 </div>
 </form>
<?php }
else if($op == "videocat_add" AND $action == "add"){
	//////////////////////////////////////////// �ó����� Database
	if(CheckLevel($admin_user,$op)){
		//����� id �͹���������
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res['VIDEOCAT'] = $db->select_query("SELECT sort FROM web_video_category2 ORDER BY sort DESC ");
		$arr['VIDEOCAT'] = mysql_fetch_array($res['VIDEOCAT']);
		$SORTID = $arr['VIDEOCAT']['sort']+1 ;
		//����������ŧ�ҵ����

		$db->add_db("web_video_category2",array(
			"category_name"=>"".addslashes(htmlspecialchars($_POST['CATEGORY']))."",
			"category_detail"=>"".$_POST['DETAIL']."",
			"post_date"=>"".TIMESTAMP."",
			"sort"=>"$SORTID"
		));
		$db->closedb ();
//		umask(0);
//		mkdir("images/video/gal_".TIMESTAMP."");
//		chmod ("images/video/gal_".TIMESTAMP."",0777);
		$ProcessOutput = "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_ADD."</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=video_category2\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_GOBACK."</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//�ó�����ҹ
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($op == "videocat_add"){
	//////////////////////////////////////////// �ó����� Form
	if(CheckLevel($admin_user,$op)){
?>
<FORM METHOD=POST ACTION="?name=admin&file=video_category2&op=videocat_add&action=add" enctype="multipart/form-data">
<B><?=_ADMIN_FORM_CAT_TOPIC;?> :</B><BR>
<INPUT TYPE="text" NAME="CATEGORY" size="40">
<BR><BR>
<B><?=_ADMIN_FORM_DETAIL;?> :</B><BR>
<textarea cols="50" id="editor1" rows="50"  NAME="DETAIL" ></textarea>
<script type="text/javascript">CKEDITOR.replace ( 'editor1',{toolbar: 'AdminBasic'});</script>
<BR><BR>
<INPUT TYPE="submit" value="<?=_ADMIN_VIDEO_BUTTON_CAT_ADD;?>">
</FORM>
<?php 	}else{
		//�ó�����ҹ
		echo  $PermissionFalse ;
	}
}
else if($op == "videocat_edit" AND $action == "edit"){
	//////////////////////////////////////////// �ó���� Database
	if(CheckLevel($admin_user,$op)){
		//��䢢�����ŧ�ҵ����
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$db->update_db("web_video_category2",array(
			"category_name"=>"".addslashes(htmlspecialchars($_POST['CATEGORY']))."",
			"category_detail"=>"".$_POST['DETAIL'].""
		)," id=".$_GET['id']." ");
		$db->closedb ();
		$ProcessOutput = "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_EDIT."</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=video_category2\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_GOBACK."</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//�ó�����ҹ
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($op == "videocat_edit" AND $action == "sort"){
	//////////////////////////////////////////// Set Sort
	if(CheckLevel($admin_user,$op)){
		//�ó�����͹���
		if($_GET['move'] == "up"){
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETD'] = "UPDATE web_video_category2 SET sort = sort+1 WHERE sort = '".$_GET['setsort']."' ";
			$sql['SETD'] = mysql_query ( $q['SETD'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();

			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETU'] = "UPDATE web_video_category2 SET sort = '".$_GET['setsort']."' WHERE id = '".$_GET['id']."' ";
			$sql['SETU'] = mysql_query ( $q['SETU'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();
		}
		if($_GET['move'] == "down"){
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETD'] = "UPDATE web_video_category2 SET sort = sort-1 WHERE sort = '".$_GET['setsort']."' ";
			$sql['SETD'] = mysql_query ( $q['SETD'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();

			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETU'] = "UPDATE web_video_category2 SET sort = '".$_GET['setsort']."' WHERE id = '".$_GET['id']."' ";
			$sql['SETU'] = mysql_query ( $q['SETU'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();
		}
		$ProcessOutput = "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_EDIT."</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=video_category2\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_GOBACK."</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//�ó�����ҹ
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($op == "videocat_edit"){
	//////////////////////////////////////////// �ó���� Form
	if(CheckLevel($admin_user,$op)){
		//�֧���
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res['VIDEOCAT'] = $db->select_query("SELECT * FROM web_video_category2 WHERE id='".$_GET['id']."' ");
		$arr['VIDEOCAT'] = $db->fetch($res['VIDEOCAT']);
		//echo $arr['VIDEOCAT']['icon'];
		$DETAIL = $arr['VIDEOCAT']['category_detail'];
		$DETAIL= stripslashes($DETAIL);

		$db->closedb ();
?>
<FORM METHOD=POST ACTION="?name=admin&file=video_category2&op=videocat_edit&action=edit&id=<?=$_GET['id'];?>" enctype="multipart/form-data">
<B><?=_ADMIN_FORM_CAT_TOPIC;?> :</B><BR>
<INPUT TYPE="text" NAME="CATEGORY" size="40" value="<?=$arr['VIDEOCAT']['category_name'];?>">
<BR><BR>
<B><?=_ADMIN_FORM_DETAIL;?> :</B><BR>
<textarea cols="50" id="editor1" rows="50"  NAME="DETAIL" ><?=$DETAIL;?></textarea>
<script type="text/javascript">CKEDITOR.replace ( 'editor1',{toolbar: 'AdminBasic'});</script>
<BR><BR>
<INPUT TYPE="submit" value="<?=_ADMIN_VIDEO_BUTTON_CAT_EDIT;?>">
</FORM>
<?php 	}else{
		//�ó�����ҹ
		$ProcessOutput = $PermissionFalse ;
	}

}
else if($op == "videocat_edit" AND $_GET['action'] == "sort"){
	//////////////////////////////////////////// Set Sort
	if(CheckLevel($admin_user,$op)){
		//�ó�����͹���
		if($_GET['move'] == "up"){
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETD'] = "UPDATE web_video_category2 SET sort = sort+1 WHERE sort = '".$_GET['setsort']."' ";
			$sql['SETD'] = mysql_query ( $q['SETD'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();

			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETU'] = "UPDATE web_video_category2 SET sort = '".$_GET['setsort']."' WHERE id = '".$_GET['id']."' ";
			$sql['SETU'] = mysql_query ( $q['SETU'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();
		}
		if($_GET['move'] == "down"){
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETD'] = "UPDATE web_video_category2 SET sort = sort-1 WHERE sort = '".$_GET['setsort']."' ";
			$sql['SETD'] = mysql_query ( $q['SETD'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();

			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$q['SETU'] = "UPDATE web_video_category2 SET sort = '".$_GET['setsort']."' WHERE id = '".$_GET['id']."' ";
			$sql['SETU'] = mysql_query ( $q['SETU'] ) or sql_error ( "db-query",mysql_error() );
			$db->closedb ();
		}
		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_EDIT."</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=video_category2\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_GOBACK."</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//�ó�����ҹ
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($op == "videocat_del" AND $_GET['action'] == "multidel"){
/// �ó�ź Multi
	if(CheckLevel($admin_user,$op)){
		while(list($key, $value) = each ($_POST['list'])){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res['video'] = $db->select_query("SELECT * FROM web_video_category2 where id='".$value."' ") ;
		$arr['video'] = $db->fetch($res['video']);
		$CAT=$arr['video']['post_date'];
		$res['cat'] = $db->select_query("SELECT * FROM web_video2 WHERE category='".$value."' ");
		while($arr['cat'] = $db->fetch($res['cat'])){
		if($arr['cat']['youtube'] !=1){
		@unlink("video/".$arr['cat']['video']);
		}
		$db->del("web_video2"," category='".$value."' ");
		$db->del("web_video_comment2"," video_id='".$value."' "); 
		}
			$db->del("web_video_category2"," id='".$value."' "); 
			$db->closedb ();
		}
		$ProcessOutput = "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_DEL."</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=video_category2\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_GOBACK."</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//�ó�����ҹ
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($op == "videocat_del"){
	//////////////////////////////////////////// �ó�ź Form
	if(CheckLevel($admin_user,$op)){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res['video'] = $db->select_query("SELECT * FROM web_video_category2 where id='".$_GET['id']."' ") ;
		$arr['video'] = $db->fetch($res['video']);
		$CAT=$arr['video']['post_date'];
		$res['cat'] = $db->select_query("SELECT * FROM web_video2 WHERE category='".$_GET['id']."' ");
		while($arr['cat'] = $db->fetch($res['cat'])){
		if($arr['cat']['youtube'] !=1){
		@unlink("video/".$arr['cat']['video']);
		}
		$db->del("web_video2"," category='".$arr['video']['id']."' ");
		$db->del("web_video_comment2"," video_id='".$arr['cat']['id']."' "); 
		}
//		$galdir="images/video/gal_".$CAT."";
//		remove_directory($galdir);
		$db->del("web_video_category2"," id='".$_GET['id']."' "); 
		$db->closedb ();

		$ProcessOutput = "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_DEL."</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=video_category2\"><B>"._ADMIN_VIDEO_MESSAGE_CAT_GOBACK."</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//�ó�����ҹ
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
