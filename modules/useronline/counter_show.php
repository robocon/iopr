<?php
header( 'Content-Type:text/html; charset=tis-620');

// กำหนดชื่อเซิร์ฟเวอร์ , ชื่อฐานข้อมูล , ชื่อผู้ใช้งาน  และ รหัสผ่าน สำหรับติดต่อกับฐานข้อมูล
$ServerName = DB_HOST;
$DatabaseName = DB_NAME;
$User = DB_USERNAME;
$Password = DB_PASSWORD;
$startdate = WEB_TIMESTART; // วันที่เริ่มต้นนับจำนวนสมาชิก
$time_delay = 600; // นับจำนวนเข้าชมขณะนี้ ในช่วงเวลา 10 นาที ( 600 วินาที )
$IPADDRESS = get_real_ip();

function ip2int($ips) {
    if(preg_match('/^\\D*(\\d+)\\D(\\d+)\\D(\\d+)\\D(\\d+)\\D*$/', $ips, $array)) {
        return (16777216 * $array[1] + 65536 * $array[2] + 256 * $array[3] + 1 * $array[4]);
    } else {
        return (0);
    }
}
$ct_ip = $IPADDRESS;
$ct_yyyy = date("Y") ;
$ct_mm = date("m") ;
$ct_dd = date("d") ;
$timecheck = time()-$time_delay; // นับจำนวนเข้าชมขณะนี้ ในช่วงเวลา 15 นาที
?>
<table border="0" cellpadding="0" cellspacing="0" width="185" bgcolor="#FBF7E1">
    <tr><td>ช่วง 15นาทีที่ผ่านมา</td></tr>
    <?php
    $sql = "SELECT * FROM ".TB_ACTIVEUSER."
    WHERE `ct_dd` = '$ct_dd'
    AND `ct_mm` = '$ct_mm'
    AND `ct_yyyy` = '$ct_yyyy'
    AND `ct_time` >= '$timecheck' ";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)){
        $ipss=$row["ct_ip"];
        $tm=$row["ct_time"];
        list($a, $b, $c, $d) = explode('.', $ipss);
        ?>
        <tr>
            <td width="105" height="20" >
                <?php echo "$a.$b.$c<span style=\"color:red\">.xxx</span>"; ?>
                <div style="border-bottom: 1px solid rgb(221, 221, 221);"></div>
            </td>
        </tr>
    <?php
    }
    ?>
</table>
