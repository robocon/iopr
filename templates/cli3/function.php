<?php
define("_TEMPLATES_WIDTH_CONFIG","1000"); //ขนาดไฟล์
//loadblock
function LoadBlock($pblock=""){
	global $db ;
	$widthLR=220; //ขนาดของ block ซ้าย,ขวา
	$widthL=5; // ขนาดของเส้นขอบซ้าย ของ block ซ้าย,ขวา
	$widthR=4; // ขนาดของเส้นขอบขวา ของ block ซ้าย,ขวา
	$widthSUM=$widthLR-($widthL+$widthR);  //ขนาดที่เหลือแสดงผลแต่ละ block ซ้าย,ขวา

	$widthCU=530; //ขนาดของ block ที่แสดงผลตรงกลาง
	$widthCL=5; // ขนาดของเส้นขอบซ้าย ของ block ตรงกลาง
	$widthCR=4; // ขนาดของเส้นขอบขวา ของ block ตรงกลาง
	$widthSUMC=$widthCU-($widthCL+$widthCR); //ขนาดที่เหลือแสดงผลแต่ละ block ตรงกลาง
	//Check Level
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	$res['blocksx'] = $db->select_query("SELECT * FROM ".TB_BLOCK." WHERE status='1' and pblock='$pblock' ORDER BY sort");

	while($arr['blocksx'] = $db->fetch($res['blocksx'])){
	$sfile=$arr['blocksx']['sfile'];
	$filename=$arr['blocksx']['filename'];

	$code=$arr['blocksx']['code'];
	if ($pblock=='left' || $pblock=='right'){

	?>
	<table id="Table_01" width="<?=$widthLR;?>" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" class="titleleft" background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ici_01.png" width="<?=$widthLR;?>" height="34" alt=""><?php echo $arr['blocksx']['blockname'];?></td>
	</tr>
	<tr>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_02.png" width="5" height="100%" alt=""></td>
		<td >
	<?php
	if($code==''){
		include ("modules/block/".$filename.".".$sfile."");
	}else{
		echo $code;
	}
	?>
			</td>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_03.png" width="4" height="100%" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_04.png" width="5" height="15" alt=""></td>
		<td >
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_05.png" width="211" height="15" alt=""></td>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_06.png" width="4" height="15" alt=""></td>
	</tr>
</table>
	<?php
	} else if ($pblock=='center' || $pblock=='user1' ){

	?>
	<center><table id="Table_01" width="<?=$widthCU;?>" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" class="titlecenter" background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/center.png" width="<?=$widthCU;?>" height="39" alt=""><?php echo $arr['blocksx']['blockname'];?></td>
	</tr>
	<tr>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_02.png" width="<?=$widthCL;?>" height="100%" alt=""></td>
		<td width="<?=$widthSUMC;?>">
	<?php
	if($code==''){
	include ("modules/block/".$filename.".".$sfile."");
	}else{
	echo $code;
	}
	?>
			</td>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_03.png" width="<?=$widthCR;?>" height="100%" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_04.png" width="5" height="15" alt=""></td>
		<td >
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_05.png" width="100%" height="15" alt=""></td>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/ict_06.png" width="4" height="15" alt=""></td>
	</tr>
</table>
	<?php
	} else {
	if($code==''){
	include ("modules/block/".$filename.".".$sfile."");
	}else{
	echo $code;
	}

	}

	}
}
?>