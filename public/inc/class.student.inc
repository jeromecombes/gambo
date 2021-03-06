<?php

require_once __DIR__."/class.mails.inc";
require_once __DIR__."/class.users.inc";
require_once __DIR__."/class.univ_reg.inc";

class student{
  public $auth=false;
  public $byUnivList=null;
  public $byUnivTab=array();
  public $error=false;
  public $messages=array();
  public $list=null;
  public $elements=array();
  public $welcomeMessage=array();
  public $id=null;
  public $email=null;
  public $password=null;
  public $token=null;
  public $semester;
  public $university=null;				// university filter

  public $cryptedFieldsNoID=array("lastname","firstname","email");
  public $cryptedFieldsMD5=array("token","password");
  public $cryptedFields=array("gender","dob","citizenship1","citizenship2","town","university",
      "university2","graduation","city","street","zip","state","country","contactlast","contactfirst","contactphone",
      "contactmobile","contactemail","cellphone","home_institution","placeOB","countryOB","frenchNumber","resultatTCF");

  function __construct(){
    if(array_key_exists("vwpp",$_SESSION) and array_key_exists("semester",$_SESSION['vwpp'])){
      $this->semester = $_SESSION['vwpp']['semester'];
    }
  }

  public function createPassword($sendMail=false){
    $this->fetchAll();
    $data=array();
    $users_data=array();
    if(is_array($this->list))
    foreach($this->list as $elem){
      $clearPassword=genTrivialPassword();
      $password = password_hash($clearPassword, PASSWORD_BCRYPT);
      $email = $this->elements[$elem]["email"];
      $token = md5($email);
      $this->elements[$elem]['clearPassword']=$clearPassword;
      $this->elements[$elem]['password']=$password;
      $data[]=array(":id"=>$elem,":password"=>$password,":token"=>$token);
      $users_data[]=array(":password"=>$password,":email"=>$email,":name"=>$email);
      if($sendMail){
	$this->createWelcomeMessage($elem);
	$mail=new vwppMail();
	$mail->addAddress($this->elements[$elem]["email"]);
	$mail->subject=$GLOBALS['config']['Messages-Welcome-Title'];
	$mail->body = $this->welcomeMessage[$elem];
	$mail->send();
	if($mail->error){
	  $this->error=true;
	  $this->messages[]=$mail->error;
	}
      }
    }
    $sql="UPDATE {$GLOBALS['config']['dbprefix']}students SET password=:password, token=:token WHERE id=:id;";
    $db=new dbh();
    $db->prepare($sql);
    foreach($data as $elem){
      $db->execute($elem);
    }

    $sql="UPDATE {$GLOBALS['config']['dbprefix']}users SET password=:password, name=:name WHERE email=:email;";
    $db=new dbh();
    $db->prepare($sql);
    foreach($users_data as $elem){
      $db->execute($elem);
    }
  }

  public function createWelcomeMessage($id){
    $email=$this->elements[$id]['email'];
    $firstname=$this->elements[$id]['firstname'];
    $lastname=$this->elements[$id]['lastname'];
    $password=$this->elements[$id]['clearPassword'];
    $message=$GLOBALS['config']['Messages-Welcome'];
    $message=str_replace(array("[FIRSTNAME]","[LASTNAME]","[EMAIL]","[PASSWORD]"),array($firstname,$lastname,$email,$password),$message);
    $this->welcomeMessage[$id]=$message;
  }

  public function fetch(){
    $univReq=null;
    if($this->university and $this->university!="VWPP"){		// university filter
      $univReq=" AND university like '%{$this->university}%'";
    }
    if($this->id)
      $req="id='{$this->id}' $univReq";
    elseif($this->email)
      $req="token=MD5('{$this->email}') $univReq";

    $db=new db();
    $db->select("students","*",$req);

    if($db->result){
      $elem=$db->result[0];
      $keys=array_keys($db->result[0]);
      $this->elements["semesters"]=unserialize($elem["semesters"]);
      if($this->elements["semesters"]){
	for($i=0;$i<count($this->elements["semesters"]);$i++)
	  $this->elements["semesters"][$i] = $this->elements["semesters"][$i];
      }
      if(!$this->elements["semesters"])
	$this->elements["semesters"] = array($elem["semester"]);
      sort($this->elements["semesters"]);
      $this->elements["semestersJoin"]=join(", ",$this->elements["semesters"]);
      $year=intval(substr($this->elements['semesters'][0],-4));
      $this->elements["newSemester"]=preg_match('/Fall/',$this->elements['semesters'][0])?"Spring ".($year+1):"Fall $year";
      $this->elements['checkedSemester']=in_array($this->elements['newSemester'],$this->elements['semesters'])?"checked='checked'":null;

      foreach($keys as $key){
	if(in_array($key,array("id","token","password","semester","guest")))
	  $this->elements[$key]=$elem[$key];
	elseif(in_array($key,array("lastname","firstname","email")))
	  $this->elements[$key]=$elem[$key]?decrypt_vwpp($elem[$key]):null;
	elseif($key=="university")
	  $this->elements[$key]=$elem[$key];
	elseif(!is_numeric($key) and $key!="semesters")
 	  $this->elements[$key]=$elem[$key]?decrypt_vwpp($elem[$key],$elem['id']):null;
      }

      //	Add HomeInstitution if Vassar or Wesleyan
      if(!$this->elements["home_institution"]){
	$this->elements["home_institution"]=$this->elements["university"];
      }

      //	Add DOB
      if(isset($this->elements['dob']) and $this->elements['dob']!=null){
	$tmp=explode("-",$this->elements['dob']);
	$dob=strToTime($this->elements['dob']);
	$dob=date("M d, Y",$dob);
	$this->elements['dob_text']=$dob;
	$this->elements['dob']=$tmp[2];
	$this->elements['mob']=$tmp[1];
	$this->elements['yob']=$tmp[0];
      }else{
	$this->elements['dob_text']=null;
	$this->elements['dob']=null;
	$this->elements['mob']=null;
	$this->elements['yob']=null;
      }

      //	Add login_name
      $this->elements['login_name']=$this->elements['lastname'].", ".$this->elements['firstname'];

      //	Add logement
      $db=new db();
      $db->select("housing_affect","*","student='{$this->id}' AND semester LIKE '{$this->semester}'");
      if($db->result){
	$this->elements['logement']=$db->result[0]['logement'];
      }

      //	Add French University
      $u=new univ_reg();
      $u->student=$this->id;
      $u->getAttrib();
      $this->elements['frenchUniv']=$u->university;
    }
  }

  public function fetchAll($university=null){
    $university=$university=="VWPP"?null:$university;
    $univReq=" AND university like '%$university%'";
    $db=new db();
    $db->select("students","*","semesters like '%\"{$this->semester}\"%' $univReq");
    if($db->result){
      $students=array();
//       $stdExcel=array();
      $keys=array_keys($db->result[0]);
      foreach($db->result as $elem){
	$students[$elem['id']]["semesters"]=unserialize($elem["semesters"]);
	if(!$students[$elem['id']]["semesters"])
	  $students[$elem['id']]["semesters"]=array($elem["semester"]);
	sort($students[$elem['id']]["semesters"]);
	$students[$elem['id']]["semestersJoin"]=join(", ",$students[$elem['id']]["semesters"]);
// 	$stdExcel[$elem['id']]["semestersJoin"]=html_entity_decode($students[$elem['id']]["semestersJoin"],ENT_QUOTES,"utf-8");
	$students[$elem['id']]["home_institution"]="toto".decrypt_vwpp($elem['home_institution'],$elem['id']);
	foreach($keys as $key){
	  if(in_array($key,array("id","token","password","semester")))
	    $students[$elem['id']][$key]=$elem[$key];
	  elseif(in_array($key,array("lastname","firstname","email")))
	    $students[$elem['id']][$key]=$elem[$key]?decrypt_vwpp($elem[$key]):null;
	  elseif(!is_numeric($key) and $key!="semesters")
	    $students[$elem['id']][$key]=$elem[$key]?decrypt_vwpp($elem[$key],$elem['id']):null;
// 	 if(!is_array($students[$elem['id']][$key]))
// 	  $stdExcel[$elem['id']][$key]=html_entity_decode($students[$elem['id']][$key],ENT_QUOTES,"utf-8");
	}
	if(empty($students[$elem['id']]["home_institution"]))
	  $students[$elem['id']]["home_institution"]=$elem['university'];
// 	$stdExcel[$elem['id']]["home_institution"]=html_entity_decode($students[$elem['id']]["home_institution"],ENT_QUOTES,"utf-8");

	//	Add French University
	$u=new univ_reg();
	$u->student=$elem['id'];
	$u->getAttrib();
	$students[$elem['id']]['frenchUniv']=$u->university;


      }
    $this->elements=$students;
//     $this->elemExcel=$stdExcel;
    }
  }

  public function getByUniv($univ=null){
    $univ=$univ=="VWPP"?null:$univ;
    $db=new db();
    $db->select("students","*","university LIKE '%$univ%'");
    if($db->result){
      foreach($db->result as $elem){
	$this->byUnivTab[]=$elem['id'];
      }
      $this->byUnivList=join(",",$this->byUnivTab);
    }
  }

  public function delete($id){		// $id = int
    $tables=array("courses_attrib_rh","courses_choices","courses_ciph","courses_univ","housing","housing_accept","stages","univ_reg");
    foreach($tables as $table){
      $db=new db();
      $db->delete($table,"student=$id");
    }
    $db=new db();
    $db->delete("students","id=$id");

  }


  public function delete2($ids){	// $ids = array
    //	Send notification by e-mail
    $error=0;
    $msg="delete_success";

    $this->fetchAll();
    foreach($ids as $id){
      $std=$this->elements[$id];
      $studentsList[]="<li>{$std['lastname']} {$std['firstname']}, {$std['university2']} {$std['semestersJoin']}</li>\n";
    }

    $u=new user();
    $u->fetchUsersAlerts();
    $users=$u->elements;

    if(!empty($users)){
      $message="Les &eacute;tudiants suivants ont &eacute;t&eacute; supprim&eacute;s de la base de donn&eacute;es VWPP : <br/><ul>\n";
      $message.=join("\n",$studentsList);
      $message.="</ul><br/>Universit&eacute; : {$_SESSION['vwpp']['login_univ']}";
      $message.="<br/>Auteur : {$_SESSION['vwpp']['login_name']}";
      $message.="<br/><br/>The VWPP Database";

      $mail=new vwppMail();
      foreach($users as $elem){
	$mail->addAddress($elem);
      }
      $mail->subject="VWPP Database, étudiants supprimés";
      $mail->body = $message;
      $mail->send();
      if($mail->error){
	$error=1;
	$msg="send_emails_error";
      }
    }

    //	Delete students
    foreach($ids as $id){
      $this->delete($id);
    }
  }

}

?>
