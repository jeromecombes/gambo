<?php

require_once("../inc/config.php");
require_once("../inc/class.reidhall.inc");
require_once("../inc/class.univ4.inc");
require_once("../inc/class.student.inc");
require_once("../inc/class.grades.inc");

access_ctrl("18,19,20");

//	Reid Hall Courses
$r=new reidhall();
$r->fetchAll();
$reidhall=$r->elemExcel;
$reidhall=array_map("utf8_decode2",$reidhall);
usort($reidhall,"cmp_title");

//	Univ. Courses
$u=new univ4();
$u->fetchAllStudents(true);
$univ=$u->elements;
$univ=array_map("entity_decode",$univ);
$univ=array_map("utf8_decode2",$univ);

//	File Name
$Fnm = '../data/grades_' . str_replace(' ', '_', $_SESSION['vwpp']['semester']);

//	File Format
if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

//	First Line
$lines=Array();
$cells=array("University","Type / Level","Code","Title","Nom","Professor","Credits","Student's lastname","Student's Firstname","Student's Univ.","Note","Date received");
if(in_array(19, $_SESSION['vwpp']['access']) or in_array(20, $_SESSION['vwpp']['access'])){
  $cells=array_merge($cells,array("Pass/Fail NRO","Actual Grade","Reported Grade","Date recorded"));
}
$lines[]=join($cells,$separate);

//	Reid Hall Lines
foreach($reidhall as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("VWPP",$course["id"]);
    $grades=array_map("utf8_decode2",$g->grades);
    foreach($grades as $grade){
      $cells=array("VWPP",$course["type"],$course["code"],$course["title"],$course["nom"],$course["professor"],"",$grade['lastExcel'],$grade['firstExcel'],$grade['university'],$grade['note'],$grade['date1']);
      if(in_array(19, $_SESSION['vwpp']['access']) or in_array(20, $_SESSION['vwpp']['access'])){
	$cells=array_merge($cells,array($grade['grade1'],$grade['grade2'],$grade['grade'],$grade['date2']));
      }
      $lines[]=join($cells,$separate);
    }
  }
}

//	Univ. Lines
foreach($univ as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("univ",$course['id']);
    $grades=array_map("utf8_decode2",$g->grades);
    foreach($grades as $grade){
      $course["nom_en"]=$course["nom_en"]?$course["nom_en"]:$course["nom"];
      $cells=array($course["institution"],$course["niveau"],$course["code"],$course["nom_en"],$course["nom"],$course["prof"],$course["credits"],$grade["lastExcel"],$grade["firstExcel"],$grade['university'],$grade['note'],$grade['date1']);
      if(in_array(19, $_SESSION['vwpp']['access']) or in_array(20, $_SESSION['vwpp']['access'])){
	$cells=array_merge($cells,array($grade['grade1'],$grade['grade2'],$grade['grade'],$grade['date2']));
      }
      $lines[]=join($cells,$separate);
    }
  }
}

//	Write In File
$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

//	Open the file
header("Location: $Fnm");
?>
