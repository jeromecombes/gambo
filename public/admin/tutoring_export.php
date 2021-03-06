<?php
// Update : 2015-10-14
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.tutorat.inc";		// A continuer

access_ctrl(23);

$t=new tutorat();
$t->fetchAll($_SESSION['vwpp']['login_univ']);
$t=$t->elements;

foreach($_POST['students'] as $elem){
  if($t[$elem])
    $tab[$elem]=$t[$elem];
}

usort($tab,"cmp_lastname");
$tab=array_map("entity_decode",$tab);
$tab=array_map("delete_rnt",$tab);


$Fnm = "../data/internship_" . str_replace(' ', '_', $_SESSION['vwpp']['semestre']);

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

$lines=Array();

$title=array("Lastname","Firstname","Tuteur","Jour","Début","Fin");
$lines[]=join($title,$separate);

foreach($tab as $elem){
  $cells=array($elem['lastname'],$elem['firstname'],$elem["tuteur"],$elem["day"],$elem["start"],$elem["end"]);
  $lines[]=join($cells,$separate);
}

$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

header("Location: $Fnm");
?>
