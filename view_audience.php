<?php
require_once "dbconnect.php";
$audienceID=$_GET['audienceID'];
$audience="";
$sql="SELECT name FROM audience Where id=N'$audienceID'";
$result=sqlsrv_query($dbcon, $sql);
if ($row = sqlsrv_fetch_array($result)) {
	$audience=$row['name'];
}
if (!isset($_GET['type'])) {
	$sql="select code, PC.[name], [type] from PC inner join location on PC.location=location.id inner join audience on location.audience=audience.id where audience.id=$audienceID 
	union select code, monitor.[name], N'Монитор' as [type] from monitor inner join location on monitor.location=location.id inner join audience on location.audience=audience.id where audience.id=$audienceID 
	union select code, projector.[name], N'Проектор' as  [type] from projector inner join audience on projector.audience=audience.id where audience.id=$audienceID 
	union select code, printScan.[name], [type] from printScan inner join location on printScan.location=location.id inner join audience on location.audience=audience.id where audience.id=$audienceID 
	union select code, networkSwitch.[name], N'Коммутатор' as [type] from networkSwitch inner join audience on networkSwitch.audience=audience.id where audience.id=$audienceID 
	union select code, interactiveWhiteboard.[name], N'Интерактивная доска' as [type] from interactiveWhiteboard inner join audience on interactiveWhiteboard.audience=audience.id where audience.id=$audienceID";
	//$sql="select code, [name], [type] from PC union select code, [name], N'Монитор' as [type] from monitor union select code, [name], N'Проектор' as  [type] from projector union select code, [name], [type] from printScan union select code, [name], N'Коммутатор' as [type] from networkSwitch union select code, [name], N'Интерактивная доска' as [type] from interactiveWhiteboard";
	$result=sqlsrv_query($dbcon, $sql);
	if (!$result) {
		echo '<br>Ошибка выполнения запроса';
	} else {
		echo "<h2 class=\"text-right mb-2\">$audience</h2>";
		echo "<table class=\"table table-striped table-dark\"><tr><th>Инвентарный номер</th><th>Наименование</th><th>Тип</th></tr>";
		while ($row = sqlsrv_fetch_array($result)) {
			$type=$row['type']=='Компьютер'?'PC':($row['type']=='Ноутбук'?'notebook':($row['type']=='Монитор'?'monitor':($row['type']=='Проектор'?'projector':($row['type']=='Принтер'?'printScan':($row['type']=='Сканер'?'printScan':($row['type']=='МФУ'?'printScan':($row['type']=='Коммутатор'?'networkSwitch':($row['type']=='Интерактивная доска'?'interactiveWhiteboard':('')))))))));
			echo "<tr><td>".$row['code']."</td><td>".$row['name']."</td><td><a href=\"action_page.php?page=view_equipment&type=".$type."\">".$row['type']."</a></td></tr>";
		}
		echo "</table>";
	}
}
else {
	switch ($_GET['type']) {
		case 'PC':
			$sql="select PC.[id] as id
			,[type]
			,[code]
			,PC.[name]
			,[CPU]
			,[RAM]
			,[videoAdapter]
			,[doc]
			,[location].[place] as place from PC inner join location on PC.location=location.id inner join audience on location.audience=audience.id where type=N'Компьютер' and audience.id=$audienceID";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Компьютеры в $audience</h2>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Процессор</th><th>ОЗУ (ГБ)</th><th>Видеокарта</th><th>Документ</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['CPU']."</td><td>".$row['RAM']."</td><td>".$row['videoAdapter']."</td><td>".$row['doc']."</td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			break;
		case 'notebook':
			$sql="select PC.[id]as id
			,[type]
			,[code]
			,PC.[name]
			,[CPU]
			,[RAM]
			,[videoAdapter]
			,[screenDiagonalInch]
			,[screenResolution]
			,[doc]
			,[location].[place] as place from PC inner join location on PC.location=location.id inner join audience on location.audience=audience.id where type=N'Ноутбук' and audience.id=$audienceID";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Ноутбуки в $audience</h2>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Процессор</th><th>ОЗУ (ГБ)</th><th>Видеокарта</th><th>Диагональ экрана</th><th>Документ</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['CPU']."</td><td>".$row['RAM']."</td><td>".$row['videoAdapter']."</td><td>".$row['screenDiagonalInch']."</td><td>".$row['doc']."</td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			break;
		case 'monitor':
			$sql="select monitor.[id] as id
			,[code]
			,monitor.[name]
			,[doc]
			,[screenDiagonalInch]
			,[screenResolution]
			,[location].[place] as place
			,[audience].[name] as audience
			,[audience].[id] as audienceID from monitor inner join location on monitor.location=location.id inner join audience on location.audience=audience.id where  audience.id=$audienceID";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Мониторы в $audience</h2>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Диагональ экрана</th><th>Документ</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['screenDiagonalInch']."</td><td>".$row['doc']."</td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			break;
		case 'projector':
			$sql="select projector.[id] as id
			,[code]
			,projector.[name]
			,[doc] as audience from projector inner join audience on projector.audience=audience.id where audience.id=$audienceID";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Проекторы в $audience</h2>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Документ</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['doc']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			break;
		case 'printScan':
			$sql="SELECT printScan.[id] as id
			,[type]
			,[code]
			,printScan.[name]
			,[max_format]
			,[doc]
			,[location].[place] as place
			FROM [dbo].[printScan] inner join location on printScan.location=location.id inner join audience on location.audience=audience.id where  audience.id=$audienceID";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Многофункциональные устройства в $audience</h2>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Тип</th><th>Макс. формат</th><th>Документ</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['type']."</td><td>".$row['max_format']."</td><td>".$row['doc']."</td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			break;
		case 'networkSwitch':
			$sql="SELECT [id]
			,[code]
			,[name]
			,[numberOfPorts]
			,[doc] from networkSwitch inner join audience on networkSwitch.audience=audience.id where audience.id=$audienceID";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Коммутаторы в $audience</h2>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Количество портов</th><th>Документ</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['numberOfPorts']."</td><td>".$row['doc']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			break;
		case 'interactiveWhiteboard':
			$sql="SELECT interactiveWhiteboard.[id]
			,[code]
			,interactiveWhiteboard.[name]
			,[doc] inner join audience on interactiveWhiteboard.audience=audience.id where audience.id=$audienceID";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Интерактивные доски в $audience</h2>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Документ</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['doc']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			break;
		default:
			break;
	}
}
?>