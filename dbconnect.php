<?php
$serverName = "SMALINOVSKY\\SMALINOVSKY";
$connectionInfo["Database"] = "AccountingPC";
$connectionInfo["UID"] = "SA";
$connectionInfo["PWD"] = "!'mPr0ger";
$connectionInfo["CharacterSet"] = "UTF-8";
$dbcon=sqlsrv_connect($serverName, $connectionInfo);
if ($dbcon==false) {
	echo "Ошибка подключения к бд";
	exit();
}
?>