<?php
$connStr = 'odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};' . 
			'Dbq=C:\\xampp\\htdocs\\20180942\\rugby.mdb;';

	// ------------------ dont touch  below -----------------
function data($dataSQL,$params,$isShowEcho,$isReturned){
	global $connStr;
	try {
		$dbh = new PDO($connStr);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $dataSQL;
		$sth = $dbh->prepare($sql);
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

function setData($dataSQL,$params,$isShowEcho){
	data($dataSQL,$params,$isShowEcho,false);
}
function getData($dataSQL,$params,$isShowEcho){
	data($dataSQL,$params,$isShowEcho,true);
}
?>
