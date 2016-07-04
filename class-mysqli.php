 <?php 
$mysqli = new mysqli("localhost", "root", "t00r00r", "my_shop");
if ($mysqli === false){
	die("ERROR: No se estableció la conexión. ". mysqli_connect_error());
} 
$sql = "Select * from customers limit 10";
if ($result = $mysqli->query($sql) ){
	if ($result->num_rows > 0 ){
 
		while($row = $result->fetch_array() ){
			echo $row[0]. " : ". trim($row[1])."\n";
		}
 
		$result->close();
	} else {
		echo "NO se encontró ningún registro que coincida con su busqueda.";
	}
 
} else {
	echo "Error: No fue posible ejecutar la consulta $sql ". $mysqli->error;
}
$mysqli->close();
?> 
