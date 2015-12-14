<?php
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['user2'] = $db->select_query("SELECT * FROM ".TB_useronline." ");
$rows['user2'] = $db->rows($res['user2']);

$arr['user2'] = $db->fetch($res['user2']);
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['user'] = $db->select_query("SELECT * FROM ".TB_MEMBER." WHERE user='".$arr['user2']['useronline']."' ");
$arr['user'] = $db->fetch($res['user'])	;

if ( !empty($_SESSION['admin_user']) || !empty($_SESSION['login_true']) ){
?>
<html>
<head>

    <script language="Javascript" type="text/javascript">
    var counter=10
    function countdown() {
        if (counter==0) {
            document.getElementById("download").value="Download Now"
            document.getElementById("download").disabled=""
        } else {
            document.getElementById("download").value="<?echo _DOWNLOAD_MOD_RATE_WAIT;?>"+counter
            document.getElementById("download").disabled="disabled"
            counter--
            setTimeout("countdown()", 1000)
        }
    }
    countdown()
    </script>
    <script>
    var statusmsg=""

    function hidestatus(){
        window.status=statusmsg
        return true
    }

    </script>
</head>
<body onLoad="countdown('10')">
    <link href="templates/<?=WEB_TEMPLATES;?>/css/style.css" rel="stylesheet" type="text/css">
    <TABLE cellSpacing=0 cellPadding=0 width=500 border=0>
        <TBODY>
            <TR>
                <TD width="10" vAlign=top></TD>
                <TD width="490" vAlign=top>
                    <!-- download -->
                    &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_user.gif" BORDER="0"><BR><BR>
                        <TABLE width="490" align=center cellSpacing=0 cellPadding=0 border=0>
                            <?php
                            $_GET['id'] = intval($_GET['id']);
                            //�ʴ��������/��Ъ�����ѹ��
                            $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                            $res['download'] = $db->select_query("SELECT * FROM ".TB_DOWNLOAD." WHERE id='".$_GET['id']."' ");
                            $arr['download'] = $db->fetch($res['download']);
                            $db->closedb ();
                            if(!$arr['download']['id']){
                                echo "<BR><BR><BR><BR><CENTER><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\" ><BR><BR><B>�������¡�� download </B></CENTER><BR><BR><BR><BR>";
                            }
                            ?>
                            <TR>
                                <TD height="1" class="dotline" ></TD>
                            </TR>
                            <TR>
                                <TD align=center width="80%" ><br>
                                    <?php
                                    if($arr['download']['full_text']){
                                        ?>
                                        <h5><img src="images/header.gif"><br><?=_DOWNLOAD_MOD_RATE_ATT;?></h5>
                                        <? }


                                        $file=$arr['download']['full_text'];
                                        $wb_picture="data/download_".$file.""; //���������ͧ��ô�ǹ���Ŵ
                                        //�� ��ҹ���������ͧ��ô�ǹ���Ŵ


                                        ?>

                                        <table id=maintable border=0 cellpadding=0 cellspacing=0 align=center width=100% height=100%><tr><td align=center>
                                            <?php
                                            //  echo "����ѡ���� ��ҡ�ô�ǹ���Ŵ���������鹤�ԡ <a href=$wb_picture>������</a> ";
                                            echo ""._DOWNLOAD_MOD_RATE_THANK." ".WEB_EMAIL."";
                                            $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                                            $q['Pageview'] = "UPDATE ".TB_DOWNLOAD." SET rate = rate+1 WHERE id = '".$_GET['id']."' ";
                                            $sql['Pageview'] = mysql_query ( $q['Pageview'] ) or sql_error ( "db-query",mysql_error() );
                                            $db->closedb ();

                                            $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                                            $res['download'] = $db->select_query("SELECT * FROM ".TB_DOWNLOAD." WHERE id='".$_GET['id']."' ");
                                            $arr['download'] = $db->fetch($res['download']);
                                            $db->closedb ();
                                            $rate=$arr['download']['rate'];
                                            //�ѹ�֡�ӹǹ��ô�ǹ���Ŵŧ����
                                            $count=$rate;
                                            $downloads=file("download.dat"); //��ҹ�����Ũҡ����ŧ�� array (��繺�÷Ѵ)
                                            $f=fopen ("download.dat", "w"); //��Դ������������¹
                                            for ($i=0; $i<count($downloads); $i++) {
                                                $data=explode("|", trim($downloads[$i]));
                                                if ($data[0]==$file) {
                                                    $count=$data[1];
                                                    $count++;
                                                } else fwrite($f, "".$data[0]."|".$data[1]." ");
                                            }
                                            fwrite($f, "$file|$count ");
                                            fclose($f);
                                            //�� �ѹ�֡�ӹǹ��ô�ǹ���Ŵŧ����


                                            //�ʴ��� �ӹǹ��ô�ǹ���Ŵ
                                            echo "<table border=0 cellspacing=2 cellpadding=2 align=center> ";
                                            echo "<tr> ";
                                            echo "<td align=center bgcolor=#5083F9><font color=white size=1>"._DOWNLOAD_MOD_RATE_NUM."</font></td> ";
                                            echo "<td align=center bgcolor=#D5D8F9><font size=1>".substr("0000$count", -4)."</font></td> ";
                                            echo "</tr> ";
                                            echo "</table> ";

                                            // echo "<br /><br /><br />[ <a href=\"javascript:window.close();\"> �Դ˹�ҹ��</a> ]";

                                            ?>
                                            <!--<center><input type="button" onclick="window.open('<?=WEB_URL."/".$wb_picture;?>')" id="download" onMouseover="return hidestatus()"></center>-->
                                            <center><input type="button" onclick="window.open('<?=WEB_URL."/".$wb_picture;?>')" id="download" ></center>
                                            <!--��ǹ���Ŵ ����� 2 �Թҷ�-->

                                            <!--<META HTTP-EQUIV=refresh CONTENT="10; URL=<?=$wb_picture?>">-->

                                            <!--�Դ˹�ҹ�� ����� 10 �Թҷ�-->
                                            <script language=JavaScript>
                                            setTimeout('CloseThisWindow()', 10000)
                                            function CloseThisWindow() {
                                                window.close()
                                            }
                                            </script>
                                        </td></tr></table>


                                    </TD>
                                    <TR>
                                        <TD height="1" class="dotline" ></TD>
                                    </TR>
                                </table>

                            </td>
                        </tr>
                    </table>
                </body>
                </html>
                <?php
                } else {
                    include 'modules/user/danger.php';
                    /*
                    ?>
                    <h1>For member only</h1>
                    <h1>Please <a href="index.php?name=member&file=index" target="_blank">register</a> for download file.</h1>
                    <?php
                    */
                }
                ?>
