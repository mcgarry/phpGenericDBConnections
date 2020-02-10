<?php
// ------------------ List Available Drivers ---------------- //
// echo '<pre>';
// print_r(PDO::getAvailableDrivers());
//echo '</pre>';
?>

<?php
// Location to file
$db = 'C:\XAMPP\htdocs\csc-odbc\RugbyClub.accdb';


function setData($dataSQL,$params,$isShowEcho){
	data($dataSQL,$params,$isShowEcho,false);
	exit;	
}
function getData($dataSQL,$params,$isShowEcho){
	data($dataSQL,$params,$isShowEcho,true);
	exit;
}

// Connection to ms access
function data($sql,$params,$isShowEcho,$isReturned)
{
	global $db;
	$db_param["name"]=$db;
	if(!file_exists($db)){
		die('Error finding access database');
	}
	if ($isShowEcho) echo "<br>Testing Access PDO";
	$db = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=".$db.";Uid=; Pwd=;");
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	if ($isShowEcho) {
		if ($db){
			"<br>PDO connection success\n";
		}else{ 
			"<br>pdo connection failed\n";
		}
	}
	try
	{
		$result = $db->query($sql);
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		if ($isShowEcho) print_r($row);
	}
	catch(PDOExepction $e)
	{
		if ($isShowEcho) echo $e->getMessage();
	}
	
	try
	{
		if ($isShowEcho){
			echo "Calling access_result_pdo_x<br>";
		}
		if(!file_exists($db_param["name"]))
		{
			throw new RuntimeException('Access Database file path is incorrect or file does not exist.');
		}

		try
		{	
			$cnnt_str="odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=".$db_param["name"].";Uid=; Pwd=;";
			$db = new PDO($cnnt_str);
			if ($isShowEcho) echo $cnnt_str;
			$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (exception $e)
		{
			print_r($e,true);
			$data["error_flag"]="true";
			$data["error_mesg"]="access connection error ". $e->getMessage() ;
			$data["legends"]=array("Error");
			$data["data"]=array(0);
			return $data;
		}
		// ---------------- My version ---------------- //
		try{
			//$sql = $dataSQL;
			$sql = 'select * from "Players"';
			$sth = $db->prepare($sql);
			$sth->execute($params);
			if ($isReturned){
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			$dbh = null; 
			if ($isShowEcho){ 
				echo "Connected successfully";
			}
		}
		catch(PDOException $e)
		{
			if ($isShowEcho){
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}
    catch (exception $e)
    {
		$data["legends"]=array("Error");
		$data["data"]=array(0);
		$data["error_flag"]="true";
		$data["error_mesg"]="fetch error ".print_r($e,true);
		return $data;
    }
	
}

		
?>
