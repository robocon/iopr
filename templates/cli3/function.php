<?php
define("_TEMPLATES_WIDTH_CONFIG","1000"); //��Ҵ���
//loadblock
function LoadBlock($pblock=""){
	global $db ;
	$widthLR=220; //��Ҵ�ͧ block ����,���
	$widthL=5; // ��Ҵ�ͧ��鹢ͺ���� �ͧ block ����,���
	$widthR=4; // ��Ҵ�ͧ��鹢ͺ��� �ͧ block ����,���
	$widthSUM=$widthLR-($widthL+$widthR);  //��Ҵ���������ʴ������� block ����,���

	$widthCU=530; //��Ҵ�ͧ block ����ʴ��ŵç��ҧ
	$widthCL=5; // ��Ҵ�ͧ��鹢ͺ���� �ͧ block �ç��ҧ
	$widthCR=4; // ��Ҵ�ͧ��鹢ͺ��� �ͧ block �ç��ҧ
	$widthSUMC=$widthCU-($widthCL+$widthCR); //��Ҵ���������ʴ������� block �ç��ҧ
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