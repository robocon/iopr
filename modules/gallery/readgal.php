<?include ("editor.php");?>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript">
function showemotion() {
	emotion1.style.display = 'none';
	emotion2.style.display = '';
}
function closeemotion() {
	emotion1.style.display = '';
	emotion2.style.display = 'none';
}

function emoticon(theSmilie) {

	document.form2.COMMENT.value += ' ' + theSmilie + ' ';
	document.form2.COMMENT.focus();
}
</script>
	<TABLE cellSpacing=0 cellPadding=0 width=750 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top></TD>
          <TD width="740" vAlign=top>
		  <!-- gallery -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_gallery.gif" BORDER="0"><BR><BR>
				<TABLE width="740" align=center cellSpacing=2 cellPadding=2 border=0>
<?
empty($_GET['id'])?$id="":$id=$_GET['id'];
//แสดง Gallery  
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['gallery'] = $db->select_query("SELECT * FROM ".TB_GALLERY." WHERE id='".$id."' ");
$arr['gallery'] = $db->fetch($res['gallery']);
$db->closedb ();
if(!$arr['gallery']['id']){
	echo "<BR><BR><BR><BR><CENTER><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\" ><BR><BR><B>"._GALLERY_ALBUM_NULL."</B></CENTER><BR><BR><BR><BR>";
}else{

	//ทำการเพิ่มจำนวนคนเข้าชม
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	$q['Pageview'] = "UPDATE ".TB_GALLERY." SET pageview = pageview+1 WHERE id = '".$id."' ";
	$sql['Pageview'] = mysql_query ( $q['Pageview'] ) or sql_error ( "db-query",mysql_error() );
	//ชื่อหมวดหมู่ 
	$res['category'] = $db->select_query("SELECT * FROM ".TB_GALLERY_CAT." WHERE id='".$arr['gallery']['category']."' "); 
	$arr['category'] = $db->fetch($res['category']);
	$CAT=$arr['category']['post_date'];
	$db->closedb ();
?>
				<TR>
					<TD height="1" class="dotline" colspan="2"></TD>
				</TR>
				<TR>
					<TD valign="top" bgcolor="#F7F7F7" colspan="2" align="center" >
	 			<table cellspacing=0 cellpadding=0 border=0 class='iconframe'>
				<tr>
				<td  border=0  align="center" class='imageframe'>
					<a HREF="images/gallery/<? echo "gal_".$CAT."/".$arr['gallery']['pic'];?>" rel="lightbox"><img class="highslide-display-block" border=0 src="<?if($arr['gallery']['id']){ echo "images/gallery/gal_".$CAT."/thb_".$arr['gallery']['pic'].""; } else { echo "images/gallery_blank.gif";}?>" /></a>
				  </td><td class='shadow_right'><div class='shadow_top_right'></div></td>
</tr>
<tr>
  <td class='shadow_bottom'><div class='shadow_bottom_left'></div></td>
  <td class='shadow_bottom_right'></td>
  </tr>
  </table>[ <?=_GALLERY_IMG_BIG;?> ]
					</td>
				</TR>
				<tr>
				<td bgcolor="#F7F7F7" valign="top" width="50">		
				<B><FONT COLOR="#990000"><?=_GALLERY_ALBUM_ID;?> </td><td width="80%" bgcolor="#F7F7F7" valign="top"><FONT COLOR="#0066FF"><?=$arr['category']['category_name'];?>
				</td>
				</tr>
					<tr>
					<td bgcolor="#F7F7F7" valign="top">	<?=_GALLERY_ALBUM_POSTED;?> </td><td bgcolor="#F7F7F7" valign="top"><?=$arr['gallery']['posted'];?></B>

					</td>
					</tr>
					<tr>
					<td bgcolor="#F7F7F7" valign="top"><?=_GALLERY_ALBUM_PREVIEW;?> </td><td bgcolor="#F7F7F7" valign="top"><?=$arr['gallery']['pageview'];?>
					</td>
					</tr>
					<tr>
					<td bgcolor="#F7F7F7" valign="top"><?=_GALLERY_ALBUM_POSTED_DATE;?> </td><td bgcolor="#F7F7F7" valign="top">
					<?= ThaiTimeConvert($arr['gallery']['post_date'],"1","");?>
					
<?
if($admin_user){
	//Admin Login Show Icon
?>
				  <a href="?name=admin&file=gallery&op=gallery_edit&id=<? echo $arr['gallery']['id'];?>"><img src="images/admin/edit.gif" border="0" alt="<?=_FROM_IMG_EDIT;?>" ></a> 
				  <a href="javascript:Confirm('?name=admin&file=gallery&op=gallery_del&id=<? echo $arr['gallery']['id'];?>&prefix=<? echo $arr['gallery']['post_date'];?>','<?echo _FROM_COMFIRM_DEL;?>');"><img src="images/admin/trash.gif"  border="0" alt="<?=_FROM_IMG_DEL;?>" ></a>
<?
}
?>
</td>
</tr>
<tr>
<td bgcolor="#F7F7F7" valign="top" ><?=_GALLERY_VOTE;?> </td><td bgcolor="#F7F7F7" valign="top">
<table  width="100%">
<tr>
<td >
<?
$rater_ids=$id;
$rater_item_name='gallery';
include("modules/rater/rater.php");
?>
</td>
</tr>
					
			  </table>
					</TD>
				</TR>
				<TR>
					<TD height="1" class="dotline" colspan=2></TD>
				</TR>
<tr>
					<TD colspan=2>
					<BR>
					<B><FONT COLOR="#009900"><?=_GALLERY_ALBUM_FIVEIMG;?>  <FONT COLOR="#990000">[<?=$arr['category']['category_name'];?>]</B></FONT>
					</td>
				  <tr>
<tr>
					<TD colspan=2><B><FONT COLOR="#990099">
<?
//แสดง Gallery  5 อันดับล่าสุดของหมวดหมู่ 
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['cat_gallery'] = $db->select_query("SELECT * FROM ".TB_GALLERY." WHERE category='".$arr['category']['id']."' ORDER BY id DESC LIMIT 5 ");
$rows['cat_gallery'] = $db->rows($res['cat_gallery']); 
if(!$rows['cat_gallery']){
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"._FROM_CAT_NO."";
}
while($arr['cat_gallery'] = $db->fetch($res['cat_gallery'])){
?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/suggest.gif" BORDER="0" ALIGN="absmiddle"> <B><A HREF="?name=gallery&file=readgal&id=<?=$arr['cat_gallery']['id'];?>" target="_blank"><?=$arr['cat_gallery']['pic'];?></A></B> <?= ThaiTimeConvert($arr['cat_gallery']['post_date'],"","");?><BR>
<?
}
$db->closedb ();
?>
					</TD>
				</TR>
<?
}
?>
			</TABLE>
		  </TD>
        </TR>
      </TBODY>
    </TABLE>