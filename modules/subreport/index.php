<?php 
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$session_user = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : $_SESSION['login_true'] ;
$invalid_user = false;
try {
	if (is_null($session_user)) {
		$msg = toTis620('ผู้ใช้งานไม่ถูกต้องกรุณาตรวจสอบอีกครั้งหนึ่ง');
		$invalid_user = true;
		throw new Exception( $msg );
	}
} catch (Exception $e) {
	echo '<h3 class="errortxt">'.$e->getMessage().'</h3>';
}

if ($invalid_user===false) {

	$sql = "SELECT a.*, b.`level` FROM `web_member` AS a 
	LEFT JOIN `web_admin` AS b ON a.`user`=b.`username` 
	WHERE `user` = '%s' ;";
	$statement = sprintf($sql, $session_user);
	$query = $db->select_query($statement);
	$user = $db->fetch($query);

	$level = empty($user['level']) ? 0 : 99 ;
	$action = !isset($_GET['action']) ? null : $_GET['action'] ;
	?>
	<style type="text/css">
		#menu-ul{padding: 0; }
		#menu-ul li{display: inline-block; margin-right: 8px; }
		#menu-ul a{font-size: 16px; }
	</style>
	<ul id="menu-ul">
		<li><a href="index.php?name=subreport"><img src="images/admin/open.gif"> <?php echo toTis620('แสดงรายงาน');?></a></li>
		<li><a href="index.php?name=subreport&action=form"><img src="images/icon/plus.gif"> <?php echo toTis620('ฟอร์มส่งข้อมูลถึง สปสข.');?></a></li>
	</ul>
	<?php 
	if ($action===null) {
		?>
		<table class="grids" style="width: 100%;">
			<tr>
				<th>#</th>
				<th><?php echo toTis620('ชื่อเรื่อง');?></th>
				<th><?php echo toTis620('หน่วยงาน');?></th>
				<th><?php echo toTis620('ตำแหน่งผู้ส่ง');?></th>
				<th><?php echo toTis620('ชื่อไฟล์');?></th>
				<th><?php echo toTis620('วันเวลา');?></th>
				<th><?php echo toTis620('การจัดการ');?></th>
			</tr>
			
		<?php
		$where = empty($user['level']) ? sprintf(" WHERE `user_id` = %d ", $user['id']) : '' ;
		$query = $db->select_query("SELECT * FROM `web_subreport` $where ORDER BY `id` DESC;");
		$rows = $db->rows($query);
		if ($rows > 0) {
			
			$i=1;
			while($item = $db->fetch($query)){
				?>
				<tr>
					<td align="center"><?php echo $i;?></td>
					<td><a href="index.php?name=subreport&action=form&id=<?php echo $item['id'];?>" title="<?php echo toTis620('คลิกเพื่อแก้ไข');?>"><?php echo $item['title']; ?></a></td>
					<td><?php echo $item['section']; ?></td>
					<td><?php echo $item['position']; ?></td>
					<td><a href="<?php echo $item['filepath'];?>" title="<?php echo toTis620('คลิกเพื่อดาวโหลดไฟล์');?>"><?php echo $item['filename']; ?></a></td>
					<td align="center">
						<?php 
						$time = strtotime($item['time']);
						echo ThaiTimeConvert($time, false, 1); 
						?>
					</td>
					<td align="center">
						<a href="index.php?name=subreport&action=delete&id=<?php echo $item['id'];?>" title="<?php echo toTis620('คลิกเพื่อลบ');?>" onclick="return confirm('<?php echo toTis620('ยืนยันที่จะลบข้อมูล?');?>');"><img src="images/admin/trash.gif"></a>
					</td>
				</tr>
				<?php
				$i++;
			}// End while

		}
		?>
			
		</table>
		<?php

	}else if ($action == "form") {
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
		if ($id > 0) {
			$sql = "SELECT * FROM `web_subreport` WHERE `id` = %s";
			$statement = sprintf($sql, $id);
			$query = $db->select_query($statement);
			$item = $db->fetch($query);
		}
		?>
		<style type="text/css">
		#adminForm p{
			margin: 0;
		}
		#adminForm label{
			display: block;
			line-height: 40px;
			vertical-align: middle;
		}
		#adminForm span{
			width: 92px;
			display: inline-block;
			text-align: right;
			font-weight: bold;
		}
		#adminForm input[type="text"]{
			margin: 0;
			line-height: 16px;
			width: 192px;
			padding-left: 8px;
		}
		</style>
		<form method="post" id="adminForm" action="index.php?name=subreport&action=save" enctype="multipart/form-data">
			<h1><?php echo toTis620('ฟอร์มส่งเอกสาร');?></h1>
			<label>
				<span><?php echo toTis620('ชื่อเรื่อง');?>: </span>
				<input type="text" name="title" value="<?php echo isset($item['title']) ? $item['title'] : '' ; ?>">
			</label>
			<label>
				<span><?php echo toTis620('หน่วยงานผู้ส่ง');?>: </span>
				<input type="text" name="section" value="<?php echo isset($item['section']) ? $item['section'] : '' ; ?>">
			</label>
			<label>
				<span><?php echo toTis620('ตำแหน่งผู้ส่ง');?>: </span>
				<input type="text" name="position" value="<?php echo isset($item['position']) ? $item['position'] : '' ; ?>">
			</label>
			<label>
				<span><?php echo toTis620('แนบไฟล์');?>: </span>
				<input type="file" name="attach">
				<?php 
				if ($id > 0) {
					?>
					<p style="padding-left: 92px;"><?php echo $item['filename'];?></p>
					<input type="hidden" name="oldFile" value="<?php echo $item['filepath'];?>">
					<?php
				}
				?>
			</label>
			<label>
				<span></span>
				<input type="submit" value="<?php echo toTis620('บันทึก');?>">
				<button type="button" onclick="window.location='index.php?name=subreport';"><?php echo toTis620('ยกเลิก');?></button>
				<?php 
				if ($id > 0) {
					?>
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<?php
				}
				?>
				<input type="hidden" name="token" value="<?php echo getToken();?>">
			</label>
		</form>
		<?php
	}else if ($action == "save") {

		$file = isset($_FILES) ? $_FILES['attach'] : null ;
		$check_invalid = false;

		try {
			if (checkToken()===false) {
				$check_invalid = true;
				throw new Exception( toTis620('การเข้าถึงข้อมูลไม่ถูกต้องกรุณาตรวจสอบอีกครั้งหนึ่ง') );
			}

			if (empty($_POST['title']) OR empty($_POST['section']) OR empty($_POST['position'])) {
				$check_invalid = true;
				throw new Exception( toTis620('กรุณาใส่ข้อมูลให้ครบถ้วน') );
			}else if ($file!==null && $file['error'] > 0) {
				$check_invalid = true;
				throw new Exception( toTis620('กรุณาตรวจสอบไฟล์แนบ') );
			}
		} catch (Exception $e) {
			echo '<h3 class="errortxt">'.$e->getMessage().'</h3>';
		}

		// if ($file['error'] > 0 && $id) {
		// 	echo "Invalid file attachment please check your file again";
		// 	$check_invalid = true;
		// }

		if ($check_invalid===false) {

			$data = array(
				"title" => $_POST['title'],
				"section" => $_POST['section'],
				"user_id" => $user['id'],
				"position" => $_POST['position'],
			);

			if (!is_null($file) && $file['error']===0) {

				// If edit and add new file
				if (isset($_POST['id'])) {
					// Remove an old file
					$statement = sprintf("SELECT * FROM `web_subreport` WHERE `id` = %s", $id);
					$query = $db->select_query($statement);
					$item = $db->fetch($query);
					@unlink($item['filepath']);
				}

				$info = pathinfo($file['name']);
				$ext_name = md5(mt_rand()).".".$info['extension'];
				$filepath = 'data/'.$ext_name;
				move_uploaded_file($file['tmp_name'], $filepath);

				$data['filename'] = $file['name'];
				$data['filepath'] = $filepath;
			}

			// Save
			if (!isset($_POST['id'])) {
				$data['time'] = date('Y-m-d H:i:s');
				$db->add_db("web_subreport", $data); 
			}else{
			// Update
				$data_set = array();
				foreach ($data as $field => $value) {
					$data_set[] = $field."='".$value."'";
				}
				$update_data = implode(',', $data_set);
				$db->update("web_subreport", $update_data, " `id` = $id");
			}
			
			echo '<h3 class="successtxt">'.toTis620('บันทึกข้อมูลเรียบร้อย').'<br><a href="index.php?name=subreport">'.toTis620('คลิกที่นี่เพื่อกลับไปหน้ารายการ').'</a></h3>';
		}
	}else if ($action == "delete") {
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
		if ($id > 0) {
			$where = $level===0 ? " AND `user_id` = '".$user['id']."'" : '' ;
			$statement = sprintf("SELECT * FROM `web_subreport` WHERE `id` = %s".$where, $id);
			$query = $db->select_query($statement);
			$item = $db->fetch($query);

			@unlink($item['filepath']);
			$db->del("web_subreport"," `id` = $id"); 
		}
		echo '<h3 class="successtxt">'.toTis620('ลบข้อมูลเรียบร้อย').'<br><a href="index.php?name=subreport">'.toTis620('คลิกที่นี่เพื่อกลับไปหน้ารายการ').'</a></h3>';
	}
} // Ending check invalid user