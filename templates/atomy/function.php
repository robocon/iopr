<?php
define("_TEMPLATES_WIDTH_CONFIG","996"); //��Ҵ��
//loadblock
function LoadBlock($pblock=""){
	global $db ;
	$widthLR=220; //��Ҵ�ͧ block ����,���
	$widthL=5; // ��Ҵ�ͧ��鹢ͺ���� �ͧ block ����,���
	$widthR=4; // ��Ҵ�ͧ��鹢ͺ��� �ͧ block ����,���
	$widthSUM=$widthLR-($widthL+$widthR);  //��Ҵ���������ʴ������� block ����,���

	$widthCU=530; //��Ҵ�ͧ block ����ʴ��ŵç��ҧ
	$widthCL=7; // ��Ҵ�ͧ��鹢ͺ���� �ͧ block �ç��ҧ
	$widthCR=7; // ��Ҵ�ͧ��鹢ͺ��� �ͧ block �ç��ҧ
	$widthSUMC=$widthCU-($widthCL+$widthCR); //��Ҵ���������ʴ������� block �ç��ҧ
	//Check Level
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	$res['blocksx'] = $db->select_query("SELECT * FROM ".TB_BLOCK." WHERE status='1' and pblock='$pblock' order by sort");
	while($arr['blocksx'] = $db->fetch($res['blocksx'])){
	$sfile=$arr['blocksx']['sfile'];
	$filename=$arr['blocksx']['filename'];
	$code=$arr['blocksx']['code'];
	if ($pblock=='left' || $pblock=='right'){
	?>
	<center><table id="Table_01" width="<?=$widthLR;?>" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" class="titleleft" background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/mainleft.png" width="<?=$widthLR;?>" height="44" alt=""><?php echo $arr['blocksx']['blockname'];?></td>
	</tr>
	<tr>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/barleft_02.png" width="<?=$widthL;?>" height="100%" alt=""></td>
		<td >
	<?php
	if($code==''){
	include ("modules/block/".$filename.".".$sfile."");
	}else{
	echo $code;
	}
	?>
	</td>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/barleft_04.png" width="<?=$widthR;?>" height="100%" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/barleft_05.png" width="5" height="12" alt=""></td>
		<td >
		<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/barleft_07.png" width="211" height="12" alt=""></td>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/barleft_08.png" width="4" height="12" alt=""></td>
	</tr>
</table>
	<?php 	} else if ($pblock=='center' || $pblock=='user1' ){
	?>
	<center><table id="Table_01" width="530" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" class="titlecenter" background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/barcenter.png" width="<?=$widthCU;?>" height="45" alt=""><?php echo $arr['blocksx']['blockname'];?></td>
	</tr>
	<tr>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/4.gif" width="<?=$widthCL;?>" height="7" alt=""></td>
		<td >
	<?php 	if($code==''){
	include ("modules/block/".$filename.".".$sfile."");
	}else{
	echo $code;
	}
	?>
			</td>
		<td background="templates/<?php echo WEB_TEMPLATES;?>/images/menu/5.gif" width="<?=$widthCR;?>" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/6.gif" width="7" height="7" alt=""></td>
		<td >
		<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/7.gif" width="100%" height="7" alt=""></td>
		<td>
			<img src="templates/<?php echo WEB_TEMPLATES;?>/images/menu/8.gif" width="7" height="7" alt=""></td>
	</tr>
</table>
	<?php 	} else {
	if($code==''){
	include ("modules/block/".$filename.".".$sfile."");
	}else{
	echo $code;
	}

	}

	}
}
?>