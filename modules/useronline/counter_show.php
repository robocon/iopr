<?php
header( 'Content-Type:text/html; charset=tis-620');

// ��˹�������������� , ���Ͱҹ������ , ���ͼ����ҹ  ��� ���ʼ�ҹ ����Ѻ�Դ��͡Ѻ�ҹ������
$ServerName = DB_HOST;
$DatabaseName = DB_NAME;
$User = DB_USERNAME;
$Password = DB_PASSWORD;
$startdate = WEB_TIMESTART; // �ѹ���������鹹Ѻ�ӹǹ��Ҫԡ
$time_delay = 600; // �Ѻ�ӹǹ��Ҫ���й�� 㹪�ǧ���� 10 �ҷ� ( 600 �Թҷ� )
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
$timecheck = time()-$time_delay; // �Ѻ�ӹǹ��Ҫ���й�� 㹪�ǧ���� 15 �ҷ�
?>
<table border="0" cellpadding="0" cellspacing="0" width="185" bgcolor="#FBF7E1">
    <tr><td>��ǧ 15�ҷշ���ҹ��</td></tr>
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
