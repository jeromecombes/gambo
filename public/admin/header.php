<?php
// Last update : 2018-10-22

ini_set('display_errors',0);
ini_set('error_reporting',E_ERROR | E_WARNING | E_PARSE);
//ini_set('error_reporting',E_ALL);

require_once __DIR__."/../inc/config.php";
require_once __DIR__."/../inc/lang.main.inc";

$title=isset($title)?$title:"VWPP Database";

switch($title){
  case "studentName" :
    $student=isset($_GET['id'])?$_GET['id']:$_SESSION['vwpp']['std-id'];
    $db=new db();
    $db->select("students","lastname,firstname","id='$student'");
    if($db->result){
      $title=decrypt_vwpp($db->result[0]['firstname'])." ".decrypt_vwpp($db->result[0]['lastname']);
    }
    else { $title="VWPP Database"; }
    break;
  default : $title="VWPP Database";	break;
}

if(!array_key_exists('vwpp',$_SESSION) and stripos($_SERVER['PHP_SELF'],"admin")){
  header("Location: ..");	// Redirect to home if try to get admin pages without session
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php echo "<title>$title</title>\n"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
echo "<link rel='shortcut icon' href='{$config['folder']}/favicon.ico' type='image/x-icon' />\n";
echo "<link rel='StyleSheet' href='{$config['folder']}/css/jquery-ui.min.css?rev=20210330' type='text/css' media='all'/>\n";
echo "<link href='/js/DataTables/datatables.min.css?rev=20210414' rel='StyleSheet' type='text/css' media='all'/>\n";

echo "<link rel='StyleSheet' href='{$config['folder']}/css/style.css?rev=20210330' type='text/css' media='screen'/>\n";
echo "<link rel='StyleSheet' href='{$config['folder']}/css/print.css?rev=20210330' type='text/css' media='print'/>\n";

echo "<script type='text/JavaScript' src='{$config['folder']}/js/jquery-ui-1.10.4/jquery-1.10.2.js?rev=20210330'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/jquery-ui-1.10.4/ui/jquery-ui.js?rev=20210330'></script>\n";
echo "<script type='text/JavaScript' src='/js/DataTables/datatables.min.js?rev=20210414'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/dataTables/sort.js?rev=20210330'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/CJScript.js?rev=20210330'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/script.js?rev=20210330'></script>\n";

?>
<noscript><center><h1>ATTENTION : JavaScript is needed</h1></center></noscript>
</head>
<body>
<?php
//	No session	=>	Login form
if(!array_key_exists('vwpp',$_SESSION)){
  header("Location: /login");
  exit;
}				// Else, show the requested page
?>
<div id='body'>

<?php
$msg=filter_input(INPUT_GET,"msg",FILTER_SANITIZE_STRING);
$msgfullstring=filter_input(INPUT_GET,"msgfullstring",FILTER_SANITIZE_STRING);
$error=filter_input(INPUT_GET,"error",FILTER_SANITIZE_STRING);

if($msg){
  $infoType=$error?"error":"highlight";

  if ($msg == 'session_fullstring') {
    $msg = $_SESSION['vwpp']['msg_fullstring'];
    $msg_success = $_SESSION['vwpp']['msg_success_fullstring'];

    if (!empty($msg)) {
        if (is_array($msg)) {
            $msg = implode('<br/>', $msg);
            $msg = str_replace('"', '\"', $msg);
        }

        echo "<script type='text/JavaScript'>CJInfo(\"$msg\",\"$infoType\");</script>\n";
    }

    if (!empty($msg_success)) {
        if (is_array($msg_success)) {
            $msg_success = implode('<br/>', $msg_success);
            $msg_success = str_replace('"', '\"', $msg_success);
        }
        echo "<script type='text/JavaScript'>CJInfo(\"$msg_success\",\"highlight\");</script>\n";
    }

  } else {
    echo "<script type='text/JavaScript'>CJInfo(\"{$GLOBALS['lang'][$msg]}\",\"$infoType\");</script>\n";
  }
}

?>
