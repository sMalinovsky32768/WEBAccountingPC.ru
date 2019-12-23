<?php
session_start();
require_once "dbconnect.php";
$table = $_GET['table'];
$typeDevice=$_GET['typeDevice'];
if (isset($_GET['delete'])) {
	foreach ($_GET as $key => $value) {
		if ($value == 'on') {
			$sql="delete from ".$table." where id=".$key;
			echo $sql;
			echo $_GET;
			print_r($_GET);
			$result=sqlsrv_query($dbcon, $sql);
		}
	}
}
if (isset($_GET['add'])) {
	switch ($_GET['table']) {
		case 'PC':
			$type=$_GET['type'];
			echo $type;
			echo $_GET['type'];
			$code=$_GET['inputCode'];
			$name=$_GET['inputName'];
			$CPU=$_GET['inputCPU'];
			$RAM=$_GET['inputRAM'];
			$Video=$_GET['inputVideoAdapter'];
			if ($type='Ноутбук') {
				$Diagonal=$_GET['inputDiagonal'];
			}
			else {
				$Diagonal=null;
			}
			$Doc=$_GET['inputDoc'];
			$Audience=$_GET['inputAudience'];
			$Place=$_GET['inputPlace'];
			$sql="INSERT INTO [dbo].[PC]
			([type]
			,[code]
			,[name]
			,[CPU]
			,[RAM]
			,[videoAdapter]
			,[screenDiagonalInch]
			,[screenResolution]
			,[doc]
			,[location])
			VALUES
			(N'".$type."'
			,N'$code'
			,N'$name'
			,N'$CPU'
			,$RAM
			,N'$Video'
			,N'$Diagonal'
			,null
			,N'$Doc'
			,(SELECT FIRST_VALUE(location.id) OVER(ORDER BY id) from location where location.audience=$Audience and location.place=$Place))";
			//$result=sqlsrv_query($dbcon, $sql);
			echo $sql;
			break;
		case 'monitor':
			$code=$_GET['inputCode'];
			$name=$_GET['inputName'];
			$Diagonal=$_GET['inputDiagonal'];
			$Doc=$_GET['inputDoc'];
			$Audience=$_GET['inputAudience'];
			$Place=$_GET['inputPlace'];
			$sql="INSERT INTO [dbo].[monitor]
			([code]
			,[name]
			,[doc]
			,[screenDiagonalInch]
			,[screenResolution]
			,[location])
			VALUES
			(N'$code'
			,N'$name'
			,N'$Doc'
			,N'$Diagonal'
			,null
			,(SELECT FIRST_VALUE(location.id) OVER(ORDER BY id) from location where location.audience=$Audience and location.place=$Place))";
			$result=sqlsrv_query($dbcon, $sql);
			break;
		case 'projector':
			$code=$_GET['inputCode'];
			$name=$_GET['inputName'];
			$Doc=$_GET['inputDoc'];
			$Audience=$_GET['inputAudience'];
			$sql="INSERT INTO [dbo].[projector]
			([code]
			,[name]
			,[doc]
			,[audience])
			VALUES
			(N'$code'
			,N'$name'
			,N'$Doc'
			,$Audience)";
			$result=sqlsrv_query($dbcon, $sql);
			break;
		case 'printScan':
			$type=$_GET['type'];
			$code=$_GET['inputCode'];
			$name=$_GET['inputName'];
			$format=$_GET['format'];
			$Doc=$_GET['inputDoc'];
			$Audience=$_GET['inputAudience'];
			$Place=$_GET['inputPlace'];
			$sql="INSERT INTO [dbo].[printScan]
			([type]
			,[code]
			,[name]
			,[max_format]
			,[doc]
			,[location])
			VALUES
			(N'$type'
			,N'$code'
			,N'$name'
			,N'$format'
			,N'$Doc'
			,(SELECT FIRST_VALUE(location.id) OVER(ORDER BY id) from location where location.audience=$Audience and location.place=$Place))";
			$result=sqlsrv_query($dbcon, $sql);
			break;
		case 'networkSwitch':
			$code=$_GET['inputCode'];
			$name=$_GET['inputName'];
			$ports=$_GET['numberOfPorts'];
			$Doc=$_GET['inputDoc'];
			$Audience=$_GET['inputAudience'];
			$sql="INSERT INTO [dbo].[networkSwitch]
			([code]
			,[name]
			,[numberOfPorts]
			,[doc]
			,[audience])
			VALUES
			(N'$code'
			,N'$name'
			,$numberOfPorts
			,N'$Doc'
			,$Audience)";
			$result=sqlsrv_query($dbcon, $sql);
			break;
		case 'interactiveWhiteboard':
			$code=$_GET['inputCode'];
			$name=$_GET['inputName'];
			$Doc=$_GET['inputDoc'];
			$Audience=$_GET['inputAudience'];
			$sql="INSERT INTO [dbo].[interactiveWhiteboard]
			([code]
			,[name]
			,[doc]
			,[audience])
			VALUES
			(N'$code'
			,N'$name'
			,N'$Doc'
			,$Audience)";
			$result=sqlsrv_query($dbcon, $sql);
			break;
		default:
			break;
	}
}
print_r($_GET);
//header("Location:../?page=view_equipment&type=".$typeDevice);
?>