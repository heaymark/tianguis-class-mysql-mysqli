<?php class MySQL{
  private $conexion; private $total_consultas;
  public function MySQL(){ 
    if(!isset($this->conexion)){
      $this->conexion = (mysql_connect("Servidor","usuario","password"))
        or die(mysql_error());
      mysql_select_db("nombreBD",$this->conexion) or die(mysql_error());
    }
  }
  public function consulta($consulta){ 
    $this->total_consultas++; 
    $resultado = mysql_query($consulta,$this->conexion);
    if(!$resultado){ 
      echo 'MySQL Error: ' . mysql_error();
      exit;
    }
    return $resultado;
  }
  public function fetch_array($consulta){
   return mysql_fetch_array($consulta);
  }
  public function num_rows($consulta){
   return mysql_num_rows($consulta);
  }
  public function getTotalConsultas(){
   return $this->total_consultas; 
  }
}?>


include("class-mysql2.php");
$db = new MySQL();
$consulta = $db->consulta("SELECT id FROM mitabla1");
if($db->num_rows($consulta)>0){
  while($resultados = $db->fetch_array($consulta)){ 
   echo "ID: ".$resultados['id']."<br />"; 
 }
}
