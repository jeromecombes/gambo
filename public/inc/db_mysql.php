<?php
// Last update : 09/30/2014, Jérôme Combes

class db{
  public $host = null;
  public $dbname = null;
  public $user = null;
  public $password = null;
  public $conn = null;
  public $result = null;
  public $nb = null;
  public $error = null;

  function __construct(){
    $this->host=$GLOBALS['config']['dbhost'];
    $this->dbname=$GLOBALS['config']['dbname'];
    $this->user=$GLOBALS['config']['dbuser'];
    $this->password=$GLOBALS['config']['dbpass'];
  }

  function connect(){
    $this->conn=mysqli_connect($this->host,$this->user,$this->password,$this->dbname);
    $this->conn->set_charset("utf8mb4");
    mysqli_query($this->conn, "SET SESSION sql_mode = ''");
    if(mysqli_connect_errno($this->conn)){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
  }

  function query($requete){
    $this->connect();
    $req=mysqli_query($this->conn,$requete);

    if(!$req){
      echo "<br/><br/>### ERREUR SQL ###<br/><br/>$requete<br/><br/>";
      echo mysqli_error($this->conn);
      echo "<br/><br/>";
      $this->error=true;
    }
    elseif(strtolower(substr(trim($requete),0,6))=="select" or strtolower(substr(trim($requete),0,4))=="show"){
      $this->nb=mysqli_num_rows($req);
      for($i=0;$i<$this->nb;$i++){
	$this->result[]=mysqli_fetch_array($req);
      }
    }
    if(!$this->result){
      $this->result=array();
    }
    $this->disconnect();
  }

  function disconnect(){
    mysqli_close($this->conn);
  }

  function select($table,$infos=null,$where=null,$options=null){
    $infos=$infos?$infos:"*";
    $where=$where?$where:"1";
    $requete="SELECT $infos FROM `{$GLOBALS['config']['dbprefix']}$table` WHERE $where $options";
    $this->query($requete);
  }

  function update($table,$set,$where){
    $requete="UPDATE `{$GLOBALS['config']['dbprefix']}$table` SET $set WHERE $where";
    $this->query($requete);
  }

  function update2($table,$fields,$ids){
    $tab=array();
    $keys=array_keys($fields);
    foreach($keys as $elem){
      $tab[]="$elem='{$fields[$elem]}'";
    }
    $set=join(",",$tab);
    $tab=array();
    $keys=array_keys($ids);
    foreach($keys as $elem){
      $tab[]="$elem='{$ids[$elem]}'";
    }
    $where=join(",",$tab);
    $this->update($table,$set,$where);
  }

  function delete($table, $where = 1, $not_really = false) {
    $requete="DELETE FROM `{$GLOBALS['config']['dbprefix']}$table` WHERE $where";

    if ($not_really) {
        echo $requete . "\n";
    } else {
        $this->query($requete);
    }
  }

  function delete2($table,$field,$ids){
    $ids=is_array($ids)?join("','",$ids):$ids;
    $this->query("DELETE FROM `{$GLOBALS['config']['dbprefix']}$table` where $field in ('$ids');");
  }

  function insert($table,$values,$fields=null){
    $fields=$fields?"($fields)":null;
    if(is_array($values)){
      for($i=0;$i<count($values);$i++){
	$values[$i]=substr($values[$i],1,-1);
	$values[$i]="'".$values[$i]."'";
      }
      $values="(".join("),(",$values).")";
    }
    else{
      $values=substr($values,1,-1);
      $values=mysqli_real_escape_string($this->conn,$values);
      $values="('$values')";
    }
    $requete="INSERT INTO `{$GLOBALS['config']['dbprefix']}$table` $fields VALUES $values;";
    $this->connect();
    $req=mysqli_query($this->conn,$requete);
    if(mysqli_error($this->conn)){
      echo mysqli_error($this->conn);
      echo "<br/>".$requete;
      }
    $this->disconnect();
  }

  function insert2($table,$values,$options=null){
    $tab=array();
    if(array_key_exists(0,$values)){
      $fields=array_keys($values[0]);
      $fields=join(",",$fields);

      foreach($values as $elem){
	$tab[]="'".join("','",$elem)."'";
	}
    }
    else{
      $fields=array_keys($values);
      $fields=join(",",$fields);

      $tab[]="'".join("','",$values)."'";
    }

    $this->insert($table,$tab,$fields);
    }
  }

class dbh{
  public $dbhost = null;
  public $dbname = null;
  public $dbuser = null;
  public $dbpass = null;
  public $pdo = null;
  public $stmt = null;
  public $result = null;


  function __construct(){
    $this->dbhost=$GLOBALS['config']['dbhost'];
    $this->dbname=$GLOBALS['config']['dbname'];
    $this->dbuser=$GLOBALS['config']['dbuser'];
    $this->dbpass=$GLOBALS['config']['dbpass'];

    $this->pdo=new PDO("mysql:host={$this->dbhost};dbname={$this->dbname};charset=utf8mb4",$this->dbuser,$this->dbpass);
  }

  function exec($sql){
    $this->pdo->exec($sql);
  }

  function prepare($sql){
    $this->stmt=$this->pdo->prepare($sql);
  }

  function execute($data){
    $this->stmt->execute($data);
    $this->result=$this->stmt->fetchAll();

    $errors=$this->stmt->errorInfo();
    $this->error= implode (' ; ',$errors);
  }
}

?>
