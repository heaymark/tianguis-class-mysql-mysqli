<?php 

class ConexionMySQL{ 
  private $conexion;
  private $total_consultas; 
  
  private $h="localhost";
  private $u="root"; 
  private $p="root"; 
  private $bd="mydatabase"; 
  
  public function ConexionMySQL(){
  //a traves de echo se puede ejecutar sentencias html 
  echo "<script>console.log('objeto de conexion creado');</script>";
  //ejecuto una salida por consola con javascript   
    if(!isset($this->conexion)){ 
    //para acceder a las variables de la clase necesitas la palabra reservada 
    $this $this->conexion = (mysql_connect($this->h, $this->u, $this->p))or die("Error al crear la conexion".mysql_error());
    mysql_select_db($this->bd,$this->conexion) or die("Error al seleccionar la base de datos".mysql_error());
    } 
  }  
  
  public function consultar($consulta){ 
  //Determina el numero de consultas con la conexion
  $this->total_consultas++; 
  $resultado=mysql_query($consulta,$this->conexion); 
    if(!$resultado){
      echo 'Error al cosultar '.mysql_error(); exit; 
    } 
    return $resultado; 
  }   
  //a esta función le pasas el objeto que creas de esta clase 
  
  public function num_rows($consulta){ 
    return mysql_num_rows($consulta); 
  } 
  
  public function getTotalConsultas(){ 
  return $this->total_consultas; 
  }
  
  public function close(){
  mysql_close($this->conexion); 
  }
}
?>

<?php 

include("conexion_mysql.php");
//nombre con el que guardas este archivo 
$obj = new ConexionMySQL();   
$consulta = $obj->consultar("SELECT id FROM mitabla"); 
if($obj->num_rows($consulta)>0){ 
  while($resultados = $obj->fetch_array($consulta)){ 
    echo "ID: ".$resultados['id'].<br>";
    } 
}else{
  echo "No se encontraron resultados relativos a la consulta"; 
}   

echo "Numero de registros encontrados igual a ".$obj->num_rows($consulta); 
$obj->close();
?> 
