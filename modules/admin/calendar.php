<?php CheckAdmin($admin_user, $admin_pwd);
?>
<link rel="stylesheet" href="css/calendar.css" type="text/css" media="screen" />
<style type="text/css">
<!--
.calendar { 
    width:220;
    background-color: #FFFFFF;
}
-->
</style>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/java.js"></script>
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
					<BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main"><?=_ADMIN_GOBACK;?></A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; <?=_ADMIN_CALENDAR_MENU_TITLE;?> &nbsp;&nbsp;<IMG SRC="images/icon/calendar.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; <A HREF="popup.php?name=admin&file=addevent" onclick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe', objectWidth: 700, objectHeight: 800} )" class="highslide"><?=_ADMIN_CALENDAR_MENU_ADD_NEW;?> </A></B>
					<BR><BR>
						<CENTER>
								<table >
		<tr>
		<td>
						<?php 						if(empty($_GET['year'])){
							$_GET['year'] = date("Y");
						}
						$cal = new MyCalendar;
						echo $cal->getYearView($_GET['year']);
						?>
						</CENTER>
						<BR><BR>
									<!-- End News -->
		</td>
		</tr>
		</table>
		<table width="100%" cellspacing="0" cellpadding="0" class="grids">
		<tr ><td colspan=5 align=center ><b><?=_ADMIN_CALENDAR_HEADER;?></b></td></tr>

		<tr class="odd">
		<td width="20" align="center"><?=_ADMIN_CALENDAR_TABLE_HEADER_NUM;?></td><td width="100" align="center"><?=_ADMIN_CALENDAR_TABLE_HEADER_DATE;?></td><td  width="150" align="center"><?=_ADMIN_CALENDAR_TABLE_HEADER_SUBJ;?></td><td  width="300" align="center"><?=_ADMIN_CALENDAR_TABLE_HEADER_DETAIL;?></td><td  width="60" align="center"><?=_ADMIN_CALENDAR_TABLE_HEADER_TIME;?></td></tr>

	<?php 	$mt=date('m');
	$my=date('Y');
$res['calendar'] = $db->select_query("SELECT * FROM ".TB_CALENDAR." where date_event between  '$my-$mt-01' and '$my-$mt-31' ORDER BY date_event  ");
$count=0;
$rank=1;
$resa['calendar'] = $db->select_query("SELECT * FROM ".TB_CALENDAR." where date_event between  '$my-$mt-01' and '$my-$mt-31' ORDER BY date_event  ");
$arrs['calendar'] = $db->fetch($resa['calendar']);
$id=$arrs['calendar']['id'];
if ($id !='') {
$count=0;
while($arr['calendar'] = $db->fetch($res['calendar'])){

	$year=substr($arr['calendar']['date_event'],0,4);
    $month=substr($arr['calendar']['date_event'],6,2)-1;
	$day=substr($arr['calendar']['date_event'],8,2);
//echo "$day-$month-$year";
//	$link = $this->getDateLink($day, $month, $year);
            $link['link'] = "popup.php?name=calendar&file=view&id=".$arr['calendar']['id']."&dates=".$arr['calendar']['date_event']."";
			$arr['calendar']['subject'] = preg_replace("/\'/i", "&#039;", $arr['calendar']['subject']);
			$arr['calendar']['subject'] = htmlspecialchars($arr['calendar']['subject']);
			$link['title'] = "".stripslashes($arr['calendar']['subject'])."";

if($count%2==0) { //ส่วนของการ สลับสี 
$ColorFill = ' onmouseover="this.style.backgroundColor=\'#FFF0DF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'"  ';
} else {
$ColorFill = 'class="odd"';
}

?>
    <tr <?php echo $ColorFill; ?> >
			<TD  align="center"><?=$rank;?></td><TD   valign=top align="center">[ <?php echo $arr['calendar']['date_event']; ?>]</td><TD valign=top><img src="images/a.gif" border="0"><?php echo "<a href=\"".$link['link']."\" onclick=\"return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe', objectWidth: 700, objectHeight: 500} )\" )\">"; ?><font color="<?=$textfill; ?>"><b><?php echo $arr['calendar']['subject']; ?></a>
<?php if($admin_user){
	//Admin Login Show Icon
?>
				  <a href="?name=admin&file=editevent&id=<?php echo $arr['calendar']['id'];?>"><img src="images/admin/edit.gif" border="0" alt="<?=_FROM_IMG_EDIT;?>" ></a> 
      <a href="javascript:Confirm('?name=admin&file=news&op=news_del&id=<?php echo $arr['calendar']['id'];?>&pic=<?php echo $arr['news']['pic'];?>&prefix=<?php echo $arr['calendar']['post_date'];?>','<?=_ADMIN_BUTTON_DEL_MESSAGE;?>');">

				  <a href="javascript:Confirm('?name=admin&file=delevent&id=<?php echo $arr['calendar']['id'];?>&op=calendar_del','<?php echo _FROM_COMFIRM_DEL;?>');"><img src="images/admin/trash.gif"  border="0" alt="<?=_FROM_IMG_DEL;?>" ></a>
<?php }
?>
</td><TD >	<?php echo $arr['calendar']['detail']; ?></td><TD  align="center"><?php echo $arr['calendar']['timeout']; ?></td>
												</tr>

<?php 	$count++;
				$rank++;
}

}	
else {
echo "<tr class=odd><td colspan=5 align=center ><b><< "._ADMIN_CALENDAR_MESSAGE_NULL_SUBJ." >></b></td></tr>";
}
$db->closedb ();
?>


		</table>
					</TD>
				</TR>
			</TABLE>
				</TD>
				</TR>
			</TABLE>
