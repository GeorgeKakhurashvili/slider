<?php
function show_good($str){
	$str=trim($str);
	$str=htmlspecialchars($str,ENT_QUOTES,'UTF-8');
	$str=preg_replace('/\s\s+/', '<br>', $str);
	$str=str_replace("\n","<br>",$str);
	$str=str_replace("&amp;","&",$str);

	return $str;
}
function post($a){
	if(is_array($a))$a=$a[0];
	return show_good($a);
}
function remove_br($str){
	$str=trim($str);
	$str=preg_replace('/\s\s+/', ' ', $str);

	return $str;
}
function laz_br2nl($str){
	// $str=trim($str);
	// $str=preg_replace('<br>', "\n", $str);
	$str=str_replace(post("<br>"), "\n", $str); 
	$str=str_replace("<br>", "\n", $str); 
    
	
	// $str=preg_replace("<br>", ' ', $str);
	
	return $str;
}

function obrabotka($obrabotka_dannie){
if($obrabotka_dannie==null){return false;}
	while(($obrabotka_dannie_stroka=$obrabotka_dannie->fetch_assoc()) != false)
			{
			$obrabotka_dannie_result[]=$obrabotka_dannie_stroka;
			
		}
	return $obrabotka_dannie_result;
}



function baza_do($q){
	global $connect;
	$result=null;
	$result_sql=$connect->query($q);
	if(!$result_sql){echo "<center><b style='color:darkred'>$q: ".$connect->error."</b></center>";return;}
	$result=obrabotka($result_sql);
	return $result;
}
function baza_do_only($q){
	global $connect;
	if($result_sql = mysqli_query($connect, $q)) return true;
	else{
		echo "<center><b style='color:darkred'>$q: ".$connect->error."</b></center>";
		return false;
	}
}
function baza_do_one($q){
	global $connect;
	$result=null;
	// echo $q;
	$result_sql=$connect->query($q);
	if(!$result_sql){echo "<center><b style='color:darkred'>$q: ".$connect->error."</b></center>";return;}
	
	$result=obrabotka($result_sql);
	return $result[0];
}

function db_disconnect($dase_db){
	$dase_db->close();
}	

function check_sess(){
	global $is_index;
	global $connect;
	global $ip;
	global $user_data;
	global $general_settings;
	global $core_db_result;
	
	global $core_skins;
	// print_r($core_skins);
	// global $db_user;
	// echo $db_user;
	if($is_index){$user_id_in_bd="`id_in_org`";}
	else $user_id_in_bd="`id`";
	if(!isset($connect))return false;
	if(strlen($_SESSION['session'])<30 && $_GET['a']!="logout")$_SESSION['session']=post($_COOKIE['session']);
	
	
	if(strlen($_SESSION['session'])>30){

		$q="SELECT * FROM `sessions` WHERE `session`='$_SESSION[session]' and `active`='1' and `ip`='$ip'";
		$session=baza_do_one($q);
		$org=$session['org'];
		$q="SELECT * FROM `users` WHERE $user_id_in_bd='$session[user_id]'";
		// echo $q;
		$user_data=baza_do_one($q);
		// print_r( $q);
		if($is_index){
		
		}
		else{
			$q="SELECT * FROM `groups` WHERE `id`='$user_data[g_id]'";
			$group_info=baza_do_one($q);
			
			$skin_found=false;
			for($i=0;$i<count($core_skins);$i++){
				$tmp=$core_skins[$i];
				if($tmp['id']=="$general_settings[def_skin]" && $tmp['skin_active']==1){$skin_found=true;$skin_info=$core_skins[$i];break;}
			}
			if(!$skin_found)$skin_info=$core_skins[0];
			// print_r($core_skins);
			// $q="SELECT * FROM `skins` WHERE `id`='$general_settings[def_skin]'";
			// $skin_info=baza_do_one($q);
			// if($skin_info['skin_active']!=1){
				// $q="SELECT * FROM `skins` WHERE `id`='1'";
				// $skin_info=baza_do_one($q);
			// }
		}
		$tmp=$user_data['id'];
		
		//make sure that these vars are array
		$user_data['funct_test']="";
		$group_info['funct_test2']="";
		$skin_info['funct_test3']="";
		if(!is_array($core_db_result)){
			unset($core_db_result);
			$core_db_result['funct_test3']="";
		}
		
		//merge arrays
		$user_data = array_merge ($user_data, $group_info,$skin_info);
		$user_data['id']=$tmp;
		
		if($is_index){
			$user_data['org']=$org; //enable access only from index.php
			$user_data['rule_access']=1; //enable access only from index.php
			$general_settings['comp_folder']=$user_data['org']; //get organisation
		}
		// print_r($general_settings);
		if($general_settings['logo']=="")$general_settings['logo']="../../images/pixel.gif";
		
		if($user_data['active']==1 && $user_data['rule_access']==1){
			$general_settings=array_merge ($general_settings,$core_db_result);
			return true;
		}
	}
	$_SESSION['session']="";
	setcookie("session", '', time()-24*3600*30);
	return false;
}

function stop_now(){
	global $connect;
	if(isset($connect))db_disconnect($connect);
	die();
}


function get_chart_color($number=0){
	$result=array();
	switch($number){
	
		case 1:
			//red
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#cc1a1a';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#ffcbcb';// Цвет заливки окружности при наведении //AVG
			break;
		case 2:
			//orange
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#cc7a1a';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#ffdeab';// Цвет заливки окружности при наведении //AVG
			break;
		case 3:
			//yellow
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#ddeb00';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#e5f3a6';// Цвет заливки окружности при наведении //AVG
			break;
		case 4:
			//green
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#1acc2f';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#b4f3a6';// Цвет заливки окружности при наведении //AVG
			break;
		case 5:
			//skyblue
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#1ac6cc';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#a6f3ee';// Цвет заливки окружности при наведении //AVG
			break;	
		case 6:
			//blue
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#1a44cc';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#a6b1f3';// Цвет заливки окружности при наведении //AVG
			break;
		case 7:
			//purple
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#1a44cc';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#a6b1f3';// Цвет заливки окружности при наведении //AVG
			break;
		default:
			$result=get_chart_color(6);
			break;	
	}
	/*
	
			$result['pointHighlightStroke']=$result['pointColor']=$result['strokeColor']='#1a8bcc';// Цвет линии // Цвет заливки окружности // Цвет окружностипри наведении
			$result['avg_col']=$result['pointHighlightFill']='#abe0ff';// Цвет заливки окружности при наведении //AVG
	*****
	
			$result['strokeColor']='#1a8bcc';// Цвет линии
			$result['pointColor']='#025a8d';// Цвет заливки окружности
			$result['pointStrokeColor']='#fff';// Цвет окружности
			$result['pointHighlightFill']='#cbecff';// Цвет заливки окружности при наведении
			$result['pointHighlightStroke']='#025a8d';// Цвет окружностипри наведении
			$result['avg_col']='#abe0ff';
			*/
			
			
	$result['pointStrokeColor']='#fff';// Цвет окружности
	$result['fillColor']='rgba(220,220,220,0)'; // Цвет фона заливки
	$result['col_100']='rgba(100,100,100,0.7)';
	return $result;
	
}

function check_mail_pre($mail){
	if(filter_var($mail, FILTER_VALIDATE_EMAIL)==false)return false;
	else return true;
$white_arr=array(
	'q','w','e','r','t','y','u','i','o','p',
	'a','s','d','f','g','h','j','k','l','z',
	'x','c','v','b','n','m',
	'1','2','3','4','5','6','7','8','9','0','.','_','-'
	);
	$mail_=explode("@",$mail);
	if(count($mail_)!=2)return false;
	else{
		$mail_[0]=strtolower($mail_[0]);
		$mail_[1]=strtolower($mail_[1]);
		$res=true;
		$check=$mail_[0];for($i=0;$i<strlen($check);$i++)if(!in_array($check[$i],$white_arr))return false;
		$check=$mail_[1];for($i=0;$i<strlen($check);$i++)if(!in_array($check[$i],$white_arr))return false;
		if(strlen($check)<3)return false;
		
		$check2_=explode(".",$check);
		if(strlen($check2_[0])<1)return false;
		$ind=count($check2_)-1;
		if(count($check2_)==1 || count($check2_)==0)return false;
		if(strlen($check2_[$ind])<1)return false;
	}
		return $res;
		return preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+(?:[-_.]?[a-z0-9]+)+(?:[-_.]?[a-z0-9]+)+(?:[-_.]?[a-z0-9]+))?@[a-z0-9]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",$mail);

}


function only_eng($check){
	$result=true;
	$check=strtolower($check);
	$white_arr=array(
	'q','w','e','r','t','y','u','i','o','p',
	'a','s','d','f','g','h','j','k','l','z',
	'x','c','v','b','n','m',
	'1','2','3','4','5','6','7','8','9','0','.','_','@', '-', ' '
);
	for($i=0;$i<strlen($check);$i++){
		if(!in_array($check[$i],$white_arr)){
			$result=false;
			break;
		}
	}
	return $result;


}


function autolink($str, $attributes=array()) {
	$attrs = '';
	foreach ($attributes as $attribute => $value) {
		$attrs .= " {$attribute}=\"{$value}\"";
	}

	$str = ' ' . $str;
	$str = preg_replace(
		'`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
		'$1<a href="$2"'.$attrs.'>$2</a>',
		$str
	);
	$str = substr($str, 1);
	
	return $str;
}


function send_email($var1, $var2, $var3, $var4){

$subject = $var1;
$message = $var2;
$to      = $var3;

    $headers    = array
    (
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset="UTF-8";',
        'Content-Transfer-Encoding: 7bit',
        'Date: ' . date('r', $_SERVER['REQUEST_TIME']),
        'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>',
        'From: ' .$var4,
        'Reply-To: ' . $var4,
        'Return-Path:' . $var4,
        'X-Mailer: PHP v' . phpversion(),
        'X-Originating-IP: ' . $_SERVER['SERVER_ADDR'],
    );
	return mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, implode("\n", $headers));

}


function check_wo_read_only($workorder){
	if($workorder['status']==0){
		return true;
	}
	else if($workorder['status']==3){
		$time=time();
		if($workorder['cancel_time']+7*24*3600<$time)
			return true;
	}
	
	
	return false;
}


// --------- Gio's Functions ----------
function chkQuoteForInv($qtid) {
	// Determine if any invoice was created for this quote
	$result = baza_do_one("SELECT count(*) as 'count' FROM invoices WHERE quoteid=$qtid");
	if($result['count'] > 0) { return true; } else { return false; }
	// ---------------------------------------------------
}

function chkQuoteForWorder($qtid) {
	// Determine if any work order was created for this quote
	$result = baza_do_one("SELECT count(*) as 'count' FROM workorders WHERE quoteid=$qtid");
	if($result['count'] > 0) { return true; } else { return false; }
	// ------------------------------------------------------
}

function chkIfQuoteExists($qtid) {
	// Determine if this quote exists and can be edited
	$result = baza_do_one("SELECT count(*) as 'count' FROM quotes WHERE id=$qtid");
	if($result['count'] > 0) { return true; } else { return false; }
	// ------------------------------------------------
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

?>