<table class='iconframe' cellpadding='0' cellspacing='0' style="width: 100%;">
<tbody>
<tr>
<td class='imageframe'>
<TABLE width="<?php //echo $widthSUMC;?>" style="width: 100%;" align=center cellSpacing=0 cellPadding=0 border=0>
<?php

empty($_GET['category'])?$category="2":$category=$_GET['category'];
//$_GET['category']=1;
if(!empty($category)){
$SQLwhere = " category='".$category."' ";
$SQLwhere2 = " WHERE category='".$category."' ";
}
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$limit = 4;


$query = $db->select_query("SELECT * FROM web_video2 ORDER BY id DESC LIMIT $limit ");

// <iframe width="210" height="162" src="//www.youtube.com/embed/242V05_aUJc" frameborder="0" allowfullscreen></iframe>
$count=0;
$i=1;
while($video = $db->fetch($query)){

if($i%2==0) {
	$ColorFill = "#ffffff";
} else {
	$ColorFill = "#F9F9F9";
}

if ($count==0) { echo "<TR>"; }
$content = $video['detail'];
$Detail = stripslashes(FixQuotes($content));
$res['category'] = $db->select_query("SELECT * FROM web_video_category2 WHERE id='".$video['category']."' "); 
$arr['category'] = $db->fetch($res['category']);
$videoid=$video['id'];
$ress['com'] = $db->select_query("SELECT *,count(video_id) as com FROM web_video_comment2 WHERE video_id ='".$videoid."' group by video_id"); 
$arrs['com'] = $db->fetch($ress['com']);

if($video['youtube']==1){
$durationx=timeyoutube($video['times']);
} else {
$durationx = $video['times'];
}
?>
<TD width="50%" valign=top align="center">	
<TABLE width="100%" border=0 cellSpacing=0 cellPadding=0>
<tr>
<TD align="center" >
<TABLE width="200" border=0 cellSpacing=0 cellPadding=0>
<tr>
<TD align="left" >
	<img src="images/video_icon.png" border="0">
	<a HREF="index.php?name=video2&file=readvideo&id=<?=$video['id'];?>" ><b><? echo $video['topic'];?></a>
	<?=NewsIcon(TIMESTAMP, $video['post_date'], "images/icon_new.gif");?></b>
</td>
</tr>
<TD align="left" ><b>By : <FONT COLOR="#990000"><?php echo $video['posted'];?></font></b>
</td>
</tr>
<tr>
<TD align="center" >
<div class="photo" >
	<iframe width="210" height="157" src="//www.youtube.com/embed/<?php echo $video['video'];?>" frameborder="0" allowfullscreen></iframe>
	<div class="photox"><?php echo $durationx;?></div>
</div>
</td>
</tr>
<tr >
<TD align="left" ><b>Rated :</b>
<?php
$rater_ids = $video['id'];
$rater_item_name = 'video';
include("modules/rater/raterx.php");
?>
</td>
</tr>
<tr >
<?php
//$date = date("D M j G:i:s T Y",$video['post_date']);
$date = date("M,j Y",$video['post_date']);
?>
<TD align="left" ><b>Added :</b> <?php echo $date;?>
</td>
</tr>

<tr >
<TD align="left" ><b>Duration :</b> <?php echo "".$durationx."";?>
</td>
</tr>
</table>
</td>
</tr>
</TABLE>

</TD>

<?php
$count++;

if (($count%_VIDEO_COL) == 0) { echo "</TR><TR><TD colspan=2 height=\"1\" class=\"dotline\"></TD></TR>"; $count=0; 
} else{
echo "</TD>";
}
$i++;
} // End while
$db->closedb ();
?>
</tr>
<tr>
<td align="left"></td><td  align="right"><A HREF="index.php?name=video2" ><img src="images/admin/2_15.gif"></a></td>
</tr>
</table>
</td>
</tr>
</table>