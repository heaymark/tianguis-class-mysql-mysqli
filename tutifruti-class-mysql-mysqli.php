<?php

$hostname = 'localhost';
$database = 'datos';
$username = 'usuario';
$password = 'contraseña';

//MySQL clásico
//require_once 'mysql-login.php';
//Conectando
$con = mysql_connect($hostname, $username, $password);
//Manejo de errores
if (!$con)
die("Falló la conexión a MySQL: " . mysql_error());
else
echo "Conexión exitosa!";
//Seleccionar base de datos
mysql_select_db($database)
or die("Seleccion de base de datos fallida " . mysql_error());
mysql_close();


//MySQL PDO
require_once 'mysql-login.php';
try {
$con = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
print "Conexión exitosa!";
}
catch (PDOException $e) {
print "¡Error!: " . $e->getMessage() . "
";
die();
}
$con =null;


//MySQLi
require_once 'mysql-login.php';
$mysqli = new mysqli($hostname, $username,$password, $database);
if ($mysqli -> connect_errno) {
die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno() 
. ") " . $mysqli -> mysqli_connect_error());
}
else
echo "Conexión exitosa!";
$mysqli -> mysqli_close();

//Ejecutar comandos

//MySQL clásico
$resultado = mysql_query("UPDATE PROFESOR SET NOMBRE ='Brenda' WHERE ID=2");
if(!$resultado)
die("Fallo el comando:".mysql_error());
else
echo mysql_affected_rows()."Filas afectadas";


//PDO
$count = $con->exec("UPDATE PROFESOR SET NOMBRE ='Brenda' WHERE ID=2");
print($count." Filas afectadas");


//MySQLi
if ($mysqli->query("UPDATE PROFESOR SET NOMBRE ='Brenda' WHERE ID=2") === TRUE) {
printf($mysqli->affected_rows." Filas afectadas");
}
else
echo "Error al ejecutar el comando:".$mysqli->error;

///Consultar base de datos 
//MySQL clásico
$query = "SELECT * FROM AVIONES";
$resultado = mysql_query($query);
if(!$resultado)
die("Fallo el comando:".mysql_error());
else{
print("<table>");
while($rows = mysql_fetch_array($resultado,MYSQL_ASSOC)){
print("<tr>");
print("<td>".$rows["ID"]."</td>");
print("<td>".$rows["CAPACIDAD"]."</td>");
print("<td>".$rows["DESCRIPCION"]."</td>");
print("</tr>");
}
print("</table>");
}

mysql_free_result($resultado);

//PDO
$query = "SELECT * FROM AVIONES";
print("<table>");
$resultado = $con->query($query); 
foreach ( $resultado as $rows) { 
print("<tr>");
print("<td>".$rows["ID"]."</td>");
print("<td>".$rows["CAPACIDAD"]."</td>");
print("<td>".$rows["DESCRIPCION"]."</td>");
print("</tr>"); 
}
print("</table>");
$resultado =null;


//MySQLi
$query = "SELECT * FROM AVIONES";
$resultado=$mysqli->query($query);
print("<table>");
while ($rows = $resultado->fetch_assoc()) {
print("<tr>");
print("<td>".$rows["ID"]."</td>");
print("<td>".$rows["CAPACIDAD"]."</td>");
print("<td>".$rows["DESCRIPCION"]."</td>");
print("</tr>");
}
print("</table>");
$resultado->free();

//Ejecutar un Procedimiento almacenado

//PDO
$proc = $con->prepare('CALL sp_clientes_edad(?)');
$proc->bindParam(1, $var, PDO::PARAM_INT);
$proc->execute();
print("<table>");
while($res=$proc->fetch(PDO::FETCH_OBJ)){
print("<tr>");
print("<td>".$res->NO_ALUMNOS."</td>");
print("<td>".$res->NOTA_MEDIA."</td>");
print("<td>".$res->NOTA_MAX."</td>");
print("<td>".$res->NOTA_MIN."</td>");
print("</tr>");
}
print("</table>");



//MySQLi
if ($stmt = $mysqli->prepare("CALL sp_estadistica_curso(?)") ){
/* ligar parámetros para marcadores */
$stmt->bind_param("d", $Id_curso); 
/* ejecutar la consulta */
$stmt->execute();
$resultado = $stmt->get_result();
print("<table>");
while($rows=$resultado->fetch_assoc()){
print("<tr>");
print("<td>".$rows["NO_ALUMNOS"]);
print("<td>".$rows["NOTA_MEDIA"]);
print("<td>".$rows["NOTA_MAX"]);
print("<td>".$rows["NOTA_MIN"]);
print("</tr>");
}
print("</table>"); 
/* cerrar sentencia */
$stmt->close();
}
else{
echo "Error al ejecutar el procedimiento".$mysqli->error;
} 


?>


