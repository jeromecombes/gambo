<?php

class reidhall{
    public $semester = null;
    public $element = null;
    public $elements = null;
    public $elemExcel = null;
    public $seminar = null;
    public $writings = null;
    public $nb = 0;

  function __construct(){
    $this->semester = $_SESSION['vwpp']['semester'];
    $this->element=array();
    $this->elements=array();
    $this->elemExcel=array();
    $this->seminars=array();
    $this->writings=array();
  }

  function fetch($id){
    $db=new db();
    $db->select("courses","*","id='$id'");
    if($db->result){
      $keys=array_keys($db->result[0]);
      foreach($keys as $key){
	if(in_array($key,array("id","type"))){
	  $this->element[$key]=$db->result[0][$key];
	}
	else{
	  $this->element[$key]=$db->result[0][$key]?decrypt_vwpp($db->result[0][$key]):null;
	}
      }
    }
  }

  function fetchAll(){
    $db=new db();
    $db->select("courses","*","semester='{$this->semester}'");
    if($db->result){
      $keys=array_keys($db->result[0]);
      foreach($db->result as $elem){
	foreach($keys as $key){
	  if(in_array($key,array("id","type"))){
	    $this->elements[$elem['id']][$key]=$elem[$key];
	  }elseif(!is_numeric($key)){
	    $this->elements[$elem['id']][$key]=$elem[$key]?decrypt_vwpp($elem[$key]):null;
	  }

	  $this->elemExcel[$elem['id']][$key]=null;
	  if(array_key_exists($key,$this->elements[$elem['id']])){
	    $this->elemExcel[$elem['id']][$key]=html_entity_decode($this->elements[$elem['id']][$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
	  }
	}
	if($elem['type']=="Seminar"){
	  $this->seminars[$elem['id']]=$this->elements[$elem['id']];
	}
	if($elem['type']=="Writing"){
	  $this->writings[$elem['id']]=$this->elements[$elem['id']];
	}
      }
    }
  }

  function delete($ids){
    $ids=is_array($ids)?join(",",$ids):$ids;
    $db=new db();
    $db->delete("courses","id IN ($ids)");
  }


  function count2($student){
    $db=new db();
    $db->select("courses_attrib_rh","*","student=$student AND semester='{$this->semester}'");
    if(!$db->result)
      return false;

    $i=0;
    if($db->result[0]['writing1'])
      $i++;
    if($db->result[0]['writing2'])
      $i++;
    if($db->result[0]['writing3'])
      $i++;
    if($db->result[0]['seminar1'])
      $i++;
    if($db->result[0]['seminar2'])
      $i++;
    if($db->result[0]['seminar3'])
      $i++;
    $this->nb=$i;
  }

  function update($array){
    $professor=encrypt_vwpp(htmlentities($array['professor'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    $title=encrypt_vwpp(htmlentities($array['title'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    $nom=encrypt_vwpp(htmlentities($array['nom'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    $code=encrypt_vwpp(htmlentities($array['code'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    $jour=encrypt_vwpp(htmlentities($array['jour'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    $debut=encrypt_vwpp(htmlentities($array['debut'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    $fin=encrypt_vwpp(htmlentities($array['fin'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    $type=$array['type'];
    $id=$array['id'];
    $data=array(":title"=>$title, ":nom"=>$nom, ":code"=>$code, ":professor"=>$professor, ":type"=>$type, ":jour"=>$jour, ":debut"=>$debut, ":fin"=>$fin, ":id"=>$id);

    if($id){
      $sql="UPDATE {$GLOBALS['dbprefix']}courses SET title=:title, nom=:nom, code=:code, professor=:professor, type=:type, jour=:jour, debut=:debut, fin=:fin WHERE id=:id;";
      $data=array(":title"=>$title, ":nom"=>$nom, ":code"=>$code, ":professor"=>$professor, ":type"=>$type, ":jour"=>$jour, ":debut"=>$debut, ":fin"=>$fin, ":id"=>$id);
      $db=new dbh();
      $db->prepare($sql);
      $db->execute($data);
    }
    else{
      $sql="INSERT INTO {$GLOBALS['dbprefix']}courses (title,nom,professor,type,semester,code,jour,debut,fin) VALUES (:title,:nom,:professor,:type,:semester,:code,:jour,:debut,:fin);";
      $data=array(":title"=>$title, ":nom"=>$nom, ":professor"=>$professor, ":type"=>$type, ":semester"=>$this->semester, ":code"=>$code, ":jour"=>$jour, ":debut"=>$debut, ":fin"=>$fin);
      $db=new dbh();
      $db->prepare($sql);
      $db->execute($data);
    }
  }

  function isLock($student){
    $semester = $this->semester;
    $db=new db();
    $db->select("courses_rh","*","semester='$semester' AND student='$student'");
    if($db->result)
      return true;
    return false;
  }

  function isPublished($student){
    $semester = $this->semester;
    $db=new db();
    $db->select("courses_rh2","*","semester='$semester' AND student='$student'");
    if($db->result)
      return true;
    return false;
  }

}


?>
