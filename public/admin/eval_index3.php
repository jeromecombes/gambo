<?php
require_once "header.php";
require_once "../inc/class.eval.inc";
require_once "../inc/class.reidhall.inc";
require_once "../inc/class.univ4.inc";
require_once "menu.php";
access_ctrl(22);

$s=new student();
$s->fetchAll($_SESSION['vwpp']['login_univ']);
$students=$s->elements;

usort($students,"cmp_lastname");

$e=new evaluation();
$e->fetchStudents();
$e=$e->students;
// print_r($e);

echo "<h3>Evaluations for {$_SESSION['vwpp']['semester']}</h3>\n";

echo "<table class='datatable' data-sort='[[0,\"asc\"],[1,\"asc\"]]' style='text-align:center;'>\n";
echo "<thead>\n";
echo "<tr><th>Lastname</th><th>Firstname</th><th>Program</th><th>VWPP Courses</th>
  <th>Univ. Courses</th><th>Tutorats</th><th>Ateliers Linguistiques</th><th>Ateliers M&eacute;thodologiques</th><th>Internship</th></tr>\n";
echo "</thead>\n";
echo "<tbody>\n";
foreach($students as $s){
  $r=new reidhall();
  $r->count2($s['id']);
  $nbVWPP=$r->nb;

  $u=new univ4();
  $u->student=$s['id'];
  $u->fetchAll();
  $nbUniv=count($u->elements);

  $classProgram=$e[$s['id']]['program']>0?"green bold":"red bold";
  $classVWPP=$e[$s['id']]['ReidHall']==$nbVWPP?"green bold":null;
  $classUniv=$e[$s['id']]['univ']==$nbUniv?"green bold":null;
  $classTutorats=$e[$s['id']]['tutorats']>0?"green bold":"red bold";
  $classAteliers=$e[$s['id']]['linguistique']>0?"green bold":"red bold";
  $classAteliers=$e[$s['id']]['method']>0?"green bold":"red bold";
  $classInternship=$e[$s['id']]['internship']>0?"green bold":null;

  echo "<tr><td>{$s['lastname']}</td><td>{$s['firstname']}</td>
    <td class='$classProgram'>{$e[$s['id']]['program']}</td>
    <td class='$classVWPP'>{$e[$s['id']]['ReidHall']} / $nbVWPP</td>
    <td class='$classUniv'>{$e[$s['id']]['univ']} / $nbUniv</td>
    <td class='$classTutorats'>{$e[$s['id']]['tutorats']}</td>
    <td class='$classAteliers'>{$e[$s['id']]['linguistique']}</td>
    <td class='$classAteliers'>{$e[$s['id']]['method']}</td>
    <td class='$classInternship'>{$e[$s['id']]['internship']}</td></tr>\n";
}

echo "</tbody>\n";
echo "</table>\n";

require_once "footer.php";
?>
