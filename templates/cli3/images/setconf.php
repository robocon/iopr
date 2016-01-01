<?php require_once("includes/config.in.php");
if(ISO =='utf-8'){
require_once("lang/thai_utf8.php");
} else {
require_once("lang/thai_tis620.php");
}
require_once("includes/class.mysql.php");
require_once("includes/function.in.php");
$db = New DB();
include ("modules/useronline/counter.php");
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res['configs'] = $db->select_query("SELECT * FROM ".TB_CONFIG."  ORDER BY id ");
$sd=1;
while($arr['configs'] = $db->fetch($res['configs'])){
if ($arr['configs']['posit']=='title'){ $title=$arr['configs']['name'];}
if ($arr['configs']['posit']=='url'){ $url=$arr['configs']['name'];}
if ($arr['configs']['posit']=='path'){ $path=$arr['configs']['name'];}
if ($arr['configs']['posit']=='footer1'){ $footer1=$arr['configs']['name'];}
if ($arr['configs']['posit']=='footer2'){ $footer2=$arr['configs']['name'];}
if ($arr['configs']['posit']=='email'){ $email=$arr['configs']['name'];}
if ($arr['configs']['posit']=='templates'){ $templates=$arr['configs']['name'];}
if ($arr['configs']['posit']=='iso'){ $iso=$arr['configs']['name'];}
$sd++;
}
define("WEB_TITILE","".$title.""); 
define("WEB_URL","".$url."") ; 
define("WEB_PATH","".$path."") ; 
define("WEB_FOOTER1","".$footer1."") ; 
define("WEB_FOOTER2","".$footer2."") ; 
define("WEB_EMAIL","".$email."") ;
define("WEB_TEMPLATES","".$templates."") ;
?>
<script type="text/javascript">
var dayArrayShort = new Array('<?php echo _S_Sunday;?>', '<?php echo _S_Monday;?>', '<?php echo _S_Tuesday;?>', '<?php echo _S_Wednesday;?>', '<?php echo _S_Thursday;?>', '<?php echo _S_Friday;?>', '<?php echo _S_Saturday;?>');
var dayArrayMed = new Array('<?php echo _S_Sunday;?>', '<?php echo _S_Monday;?>', '<?php echo _S_Tuesday;?>', '<?php echo _S_Wednesday;?>', '<?php echo _S_Thursday;?>', '<?php echo _S_Friday;?>', '<?php echo _S_Saturday;?>');
var dayArrayLong = new Array('<?php echo _Sunday;?>', '<?php echo _Monday;?>', '<?php echo _Tuesday;?>', '<?php echo _Wednesday;?>', '<?php echo _Thursday;?>', '<?php echo _Friday;?>', '<?php echo _Saturday;?>');
var monthArrayShort = new Array('<?php echo _Month_1;?>', '<?php echo _Month_2;?>', '<?php echo _Month_3;?>', '<?php echo _Month_4;?>', '<?php echo _Month_5;?>', '<?php echo _Month_6;?>', '<?php echo _Month_7;?>', '<?php echo _Month_8;?>', '<?php echo _Month_9;?>', '<?php echo _Month_10;?>', '<?php echo _Month_11;?>', '<?php echo _Month_12;?>');
var monthArrayMed = new Array('<?php echo _Month_1;?>', '<?php echo _Month_2;?>', '<?php echo _Month_3;?>', '<?php echo _Month_4;?>', '<?php echo _Month_5;?>', '<?php echo _Month_6;?>', '<?php echo _Month_7;?>', '<?php echo _Month_8;?>', '<?php echo _Month_9;?>', '<?php echo _Month_10;?>', '<?php echo _Month_11;?>', '<?php echo _Month_12;?>');
var monthArrayLong = new Array('<?php echo _F_Month_1;?>', '<?php echo _F_Month_2;?>', '<?php echo _F_Month_3;?>', '<?php echo _F_Month_4;?>', '<?php echo _F_Month_5;?>', '<?php echo _F_Month_6;?>', '<?php echo _F_Month_7;?>', '<?php echo _F_Month_8;?>', '<?php echo _F_Month_9;?>', '<?php echo _F_Month_10;?>', '<?php echo _F_Month_11;?>', '<?php echo _F_Month_12;?>');
</script>