<?php
require_once "dbconnect.php";
if (!isset($_GET['type'])) {
	$sql="select code, PC.[name], [type], [audience].[name] as audience, [audience].[id] as audienceID from PC inner join location on PC.location=location.id inner join audience on location.audience=audience.id
	union select code, monitor.[name], N'Монитор' as [type], [audience].[name] as audience, [audience].[id] as audienceID from monitor inner join location on monitor.location=location.id inner join audience on location.audience=audience.id
	union select code, projector.[name], N'Проектор' as  [type], [audience].[name] as audience, [audience].[id] as audienceID from projector inner join audience on projector.audience=audience.id
	union select code, printScan.[name], [type], [audience].[name] as audience, [audience].[id] as audienceID from printScan inner join location on printScan.location=location.id inner join audience on location.audience=audience.id
	union select code, networkSwitch.[name], N'Коммутатор' as [type], [audience].[name] as audience, [audience].[id] as audienceID from networkSwitch inner join audience on networkSwitch.audience=audience.id
	union select code, interactiveWhiteboard.[name], N'Интерактивная доска' as [type], [audience].[name] as audience, [audience].[id] as audienceID from interactiveWhiteboard inner join audience on interactiveWhiteboard.audience=audience.id";
	//$sql="select code, [name], [type] from PC union select code, [name], N'Монитор' as [type] from monitor union select code, [name], N'Проектор' as  [type] from projector union select code, [name], [type] from printScan union select code, [name], N'Коммутатор' as [type] from networkSwitch union select code, [name], N'Интерактивная доска' as [type] from interactiveWhiteboard";
	$result=sqlsrv_query($dbcon, $sql);
	if (!$result) {
		echo '<br>Ошибка выполнения запроса';
	} else {
		echo "<h2 class=\"text-right mb-2\">Оборудование</h2>";
		echo "<table class=\"table table-striped table-dark\"><tr><th>Инвентарный номер</th><th>Наименование</th><th>Тип</th><th>Аудитория</th></tr>";
		while ($row = sqlsrv_fetch_array($result)) {
			$type=$row['type']=='Компьютер'?'PC':($row['type']=='Ноутбук'?'notebook':($row['type']=='Монитор'?'monitor':($row['type']=='Проектор'?'projector':($row['type']=='Принтер'?'printScan':($row['type']=='Сканер'?'printScan':($row['type']=='МФУ'?'printScan':($row['type']=='Коммутатор'?'networkSwitch':($row['type']=='Интерактивная доска'?'interactiveWhiteboard':('')))))))));
			echo "<tr><td>".$row['code']."</td><td>".$row['name']."</td><td><a href=\"action_page.php?page=view_equipment&type=".$type."\">".$row['type']."</a></td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."\">".$row['audience']."</a></td></tr>";
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
			,[location].[place] as place
			,[audience].[name] as audience
			,[audience].[id] as audienceID from PC inner join location on PC.location=location.id inner join audience on location.audience=audience.id where type=N'Компьютер'";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Компьютеры</h2>";
				echo "<form method='GET' action='add_delete.php' name='add_delete_form' id='add_delete_form'/>";
				echo "<input type='submit' class='btn btn-danger float-right mb-2' name='delete' value='Удалить'>";
				echo "<input type='hidden' name='typeDevice' value='Компьютер'>";
				echo "<button type=\"button\" class=\"btn btn-primary float-right mb-2 mx-2\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Добавить</button>";
				echo "<input type='hidden' name='table' id='table' value='PC'>";
				echo "</form>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Процессор</th><th>ОЗУ (ГБ)</th><th>Видеокарта</th><th>Документ</th><th>Аудитория</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['CPU']."</td><td>".$row['RAM']."</td><td>".$row['videoAdapter']."</td><td>".$row['doc']."</td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."&type=".$_GET['type']."\">".$row['audience']."</a></td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			echo "
			<div class=\"modal fade bd-example-modal-lg\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
				<div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">
					<div class=\"modal-content\">
						<form method='GET' action='add_delete.php' name='add_form' id='add_form'></form>
						<div class=\"modal-header\">
							<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Добавление устройства</h5>
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						<div class=\"modal-body\">
							<div class=\"form-row\">
								<div class=\"form-group col-md-4\">
									<label for=\"inputCode\">Инвентарный номер</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCode\" name=\"inputCode\" placeholder=\"Инвентарный номер\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-8\">
									<label for=\"inputName\">Название</label>
									<input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"inputName\" placeholder=\"Название устройства\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-4\">
									<label for=\"inputCPU\">CPU</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCPU\" name=\"inputCPU\" placeholder=\"Модель процессора\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputRAM\">RAM</label>
									<input type=\"number\" class=\"form-control\" id=\"inputRAM\" name=\"inputRAM\" placeholder=\"ОЗУ Гб\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-5\">
									<label for=\"inputVideoAdapter\">Видеокарта</label>
									<input type=\"text\" class=\"form-control\" id=\"inputVideoAdapter\" name=\"inputVideoAdapter\" placeholder=\"Модель видеокарты\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-6\">
									<label for=\"inputDoc\">Документ</label>
									<input type=\"text\" class=\"form-control\" id=\"inputDoc\" name=\"inputDoc\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputAudience\">Аудитория</label>
									<select class=\"form-control\" id=\"inputAudience\" name=\"inputAudience\" form=\"add_form\">";
			$sql="select * from audience";
			$result=sqlsrv_query($dbcon, $sql);
			while ($row = sqlsrv_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			echo "
    								</select>
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputPlace\">Место</label>
									<input type=\"number\" class=\"form-control\" id=\"inputPlace\" name=\"inputPlace\" form=\"add_form\" min=\"-1\" max=\"15\">
								</div>
							</div>
							<input type=\"hidden\" name=\"type\" value=\"Компьютер\" form=\"add_form\">
							<input type=\"hidden\" name=\"table\" value=\"PC\" form=\"add_form\">
						</div>
						<div class=\"modal-footer\">
							<button type=\"submit\" class=\"btn btn-secondary\" name=\"add\" form=\"add_form\">Добавить</button>
						</div>
					</div>
				</div>
			</div>";
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
			,[location].[place] as place
			,[audience].[name] as audience
			,[audience].[id] as audienceID from PC inner join location on PC.location=location.id inner join audience on location.audience=audience.id where type=N'Ноутбук'";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Ноутбуки</h2>";
				echo "<form method='GET' action='add_delete.php' name='add_delete_form' id='add_delete_form'>";
				echo "<input type='submit' class='btn btn-danger float-right mb-2' name='delete' value='Удалить'>";
				echo "<input type='hidden' name='typeDevice' value='Ноутбук'>";
				echo "<button type=\"button\" class=\"btn btn-primary float-right mb-2 mx-2\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Добавить</button>";
				echo "<input type='hidden' name='table' id='table' value='PC'>";
				echo "</form>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Процессор</th><th>ОЗУ (ГБ)</th><th>Видеокарта</th><th>Диагональ экрана</th><th>Документ</th><th>Аудитория</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['CPU']."</td><td>".$row['RAM']."</td><td>".$row['videoAdapter']."</td><td>".$row['screenDiagonalInch']."</td><td>".$row['doc']."</td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."&type=".$_GET['type']."\">".$row['audience']."</a></td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			echo "
			<div class=\"modal fade bd-example-modal-lg\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
				<div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">
					<div class=\"modal-content\">
						<form method='GET' action='add_delete.php' name='add_form' id='add_form'></form>
						<div class=\"modal-header\">
							<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Добавление устройства</h5>
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						<div class=\"modal-body\">
							<div class=\"form-row\">
								<div class=\"form-group col-md-4\">
									<label for=\"inputCode\">Инвентарный номер</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCode\" name=\"inputCode\" placeholder=\"Инвентарный номер\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-8\">
									<label for=\"inputName\">Название</label>
									<input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"inputName\" placeholder=\"Название устройства\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-3\">
									<label for=\"inputCPU\">CPU</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCPU\" name=\"inputCPU\" placeholder=\"Модель процессора\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-2\">
									<label for=\"inputRAM\">RAM</label>
									<input type=\"number\" class=\"form-control\" id=\"inputRAM\" name=\"inputRAM\" placeholder=\"ОЗУ Гб\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-4\">
									<label for=\"inputVideoAdapter\">Видеокарта</label>
									<input type=\"text\" class=\"form-control\" id=\"inputVideoAdapter\" name=\"inputVideoAdapter\" placeholder=\"Модель видеокарты\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputDiagonal\">Диагональ экрана</label>
									<input type=\"number\" class=\"form-control\" id=\"inputDiagonal\" name=\"inputDiagonal\" placeholder=\"Диагональ\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-6\">
									<label for=\"inputDoc\">Документ</label>
									<input type=\"text\" class=\"form-control\" id=\"inputDoc\" name=\"inputDoc\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputAudience\">Аудитория</label>
									<select class=\"form-control\" id=\"inputAudience\" name=\"inputAudience\" form=\"add_form\">";
			$sql="select * from audience";
			$result=sqlsrv_query($dbcon, $sql);
			while ($row = sqlsrv_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			echo "
    								</select>
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputPlace\">Место</label>
									<input type=\"number\" class=\"form-control\" id=\"inputPlace\" name=\"inputPlace\" form=\"add_form\" min=\"-1\" max=\"15\">
								</div>
							</div>
							<input type=\"hidden\" name=\"type\" value=\"Ноутбук\" form=\"add_form\">
							<input type=\"hidden\" name=\"table\" value=\"PC\" form=\"add_form\">
						</div>
						<div class=\"modal-footer\">
							<button type=\"submit\" class=\"btn btn-secondary\" name=\"add\" form=\"add_form\">Добавить</button>
						</div>
					</div>
				</div>
			</div>";
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
			,[audience].[id] as audienceID from monitor inner join location on monitor.location=location.id inner join audience on location.audience=audience.id";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Мониторы</h2>";
				echo "<form method='GET' action='add_delete.php' name='add_delete_form' id='add_delete_form'>";
				echo "<input type='submit' class='btn btn-danger float-right mb-2' name='delete' value='Удалить'>";
				echo "<input type='hidden' name='typeDevice' value='Монитор'>";
				echo "<button type=\"button\" class=\"btn btn-primary float-right mb-2 mx-2\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Добавить</button>";
				echo "<input type='hidden' name='table' id='table' value='monitor'>";
				echo "</form>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Диагональ экрана</th><th>Документ</th><th>Аудитория</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['screenDiagonalInch']."</td><td>".$row['doc']."</td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."&type=".$_GET['type']."\">".$row['audience']."</a></td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			echo "
			<div class=\"modal fade bd-example-modal-lg\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
				<div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">
					<div class=\"modal-content\">
						<form method='GET' action='add_delete.php' name='add_form' id='add_form'></form>
						<div class=\"modal-header\">
							<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Добавление устройства</h5>
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						<div class=\"modal-body\">
							<div class=\"form-row\">
								<div class=\"form-group col-md-3\">
									<label for=\"inputCode\">Инвентарный номер</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCode\" name=\"inputCode\" placeholder=\"Инвентарный номер\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-6\">
									<label for=\"inputName\">Название</label>
									<input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"inputName\" placeholder=\"Название устройства\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputDiagonal\">Диагональ экрана</label>
									<input type=\"number\" class=\"form-control\" id=\"inputDiagonal\" name=\"inputDiagonal\" placeholder=\"Диагональ\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-6\">
									<label for=\"inputDoc\">Документ</label>
									<input type=\"text\" class=\"form-control\" id=\"inputDoc\" name=\"inputDoc\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputAudience\">Аудитория</label>
									<select class=\"form-control\" id=\"inputAudience\" name=\"inputAudience\" form=\"add_form\">";
			$sql="select * from audience";
			$result=sqlsrv_query($dbcon, $sql);
			while ($row = sqlsrv_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			echo "
    								</select>
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputPlace\">Место</label>
									<input type=\"number\" class=\"form-control\" id=\"inputPlace\" name=\"inputPlace\" form=\"add_form\" min=\"-1\" max=\"15\">
								</div>
							</div>
							<input type=\"hidden\" name=\"table\" value=\"monitor\" form=\"add_form\">
						</div>
						<div class=\"modal-footer\">
							<button type=\"submit\" class=\"btn btn-secondary\" name=\"add\" form=\"add_form\">Добавить</button>
						</div>
					</div>
				</div>
			</div>";
			break;
		case 'projector':
			$sql="select projector.[id] as id
			,[code]
			,projector.[name]
			,[doc]
			,[audience].[name] as audience
			,[audience].[id] as audienceID as audience from projector inner join audience on projector.audience=audience.id";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Проекторы</h2>";
				echo "<form method='GET' action='add_delete.php' name='add_delete_form' id='add_delete_form'>";
				echo "<input type='submit' class='btn btn-danger float-right mb-2' name='delete' value='Удалить'>";
				echo "<button type=\"button\" class=\"btn btn-primary float-right mb-2 mx-2\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Добавить</button>";
				echo "<input type='hidden' name='table' id='table' value='projector'>";
				echo "</form>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Документ</th><th>Аудитория</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['doc']."</td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."&type=".$_GET['type']."\">".$row['audience']."</a></td></tr>";
				}
				echo "</tbody></table>";
			}
			echo "
			<div class=\"modal fade bd-example-modal-lg\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
				<div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">
					<div class=\"modal-content\">
						<form method='GET' action='add_delete.php' name='add_form' id='add_form'></form>
						<div class=\"modal-header\">
							<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Добавление устройства</h5>
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						<div class=\"modal-body\">
							<div class=\"form-row\">
								<div class=\"form-group col-md-4\">
									<label for=\"inputCode\">Инвентарный номер</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCode\" name=\"inputCode\" placeholder=\"Инвентарный номер\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-8\">
									<label for=\"inputName\">Название</label>
									<input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"inputName\" placeholder=\"Название устройства\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-6\">
									<label for=\"inputDoc\">Документ</label>
									<input type=\"text\" class=\"form-control\" id=\"inputDoc\" name=\"inputDoc\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputAudience\">Аудитория</label>
									<select class=\"form-control\" id=\"inputAudience\" name=\"inputAudience\" form=\"add_form\">";
			$sql="select * from audience";
			$result=sqlsrv_query($dbcon, $sql);
			while ($row = sqlsrv_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			echo "
    								</select>
								</div>
							</div>
							<input type=\"hidden\" name=\"table\" value=\"projector\" form=\"add_form\">
						</div>
						<div class=\"modal-footer\">
							<button type=\"submit\" class=\"btn btn-secondary\" name=\"add\" form=\"add_form\">Добавить</button>
						</div>
					</div>
				</div>
			</div>";
			break;
		case 'printScan':
			$sql="SELECT printScan.[id] as id
			,[type]
			,[code]
			,printScan.[name]
			,[max_format]
			,[doc]
			,[location].[place] as place
			,[audience].[name] as audience
			,[audience].[id] as audienceID
			FROM [dbo].[printScan] inner join location on printScan.location=location.id inner join audience on location.audience=audience.id";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Многофункциональные устройства</h2>";
				echo "<form method='GET' action='add_delete.php' name='add_delete_form' id='add_delete_form'>";
				echo "<input type='submit' class='btn btn-danger float-right mb-2' name='delete' value='Удалить'>";
				echo "<button type=\"button\" class=\"btn btn-primary float-right mb-2 mx-2\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Добавить</button>";
				echo "<input type='hidden' name='table' id='table' value='printScan'>";
				echo "</form>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Тип</th><th>Макс. формат</th><th>Документ</th><th>Аудитория</th><th>Место</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['type']."</td><td>".$row['max_format']."</td><td>".$row['doc']."</td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."&type=".$_GET['type']."\">".$row['audience']."</a></td><td>".$row['place']."</td></tr>";
				}
				echo "</tbody></table>";
			}
			echo "
			<div class=\"modal fade bd-example-modal-lg\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
				<div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">
					<div class=\"modal-content\">
						<form method='GET' action='add_delete.php' name='add_form' id='add_form'></form>
						<div class=\"modal-header\">
							<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Добавление устройства</h5>
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						<div class=\"modal-body\">
							<div class=\"form-row\">
								<div class=\"form-group col-md-4\">
									<label for=\"inputCode\">Инвентарный номер</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCode\" name=\"inputCode\" placeholder=\"Инвентарный номер\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-8\">
									<label for=\"inputName\">Название</label>
									<input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"inputName\" placeholder=\"Название устройства\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-3\">
									<label for=\"type\">Тип</label>
									<select class=\"form-control\" id=\"type\" name=\"type\" form=\"add_form\">
										<option value=\"Принтер\">Принтер</option>
										<option value=\"Сканер\">Сканер</option>
										<option value=\"МФУ\">МФУ</option>
										<option value=\"Плоттер\">Плоттер</option>
    								</select>
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"format\">Максимальный формат</label>
									<select class=\"form-control\" id=\"format\" name=\"format\" form=\"add_form\">
										<option value=\"А0\">А0</option>
										<option value=\"А1\">А1</option>
										<option value=\"А2\">А2</option>
										<option value=\"А3\">А3</option>
										<option value=\"А4\">А4</option>
										<option value=\"B0\">B0</option>
										<option value=\"B1\">B1</option>
										<option value=\"B2\">B2</option>
										<option value=\"B3\">B3</option>
										<option value=\"B4\">B4</option>
										<option value=\"C1\">C1</option>
										<option value=\"C2\">C2</option>
										<option value=\"C3\">C3</option>
										<option value=\"C4\">C4</option>
    								</select>
								</div>
								<div class=\"form-group col-md-6\">
									<label for=\"inputDoc\">Документ</label>
									<input type=\"text\" class=\"form-control\" id=\"inputDoc\" name=\"inputDoc\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-3\">
									<label for=\"inputAudience\">Аудитория</label>
									<select class=\"form-control\" id=\"inputAudience\" name=\"inputAudience\" form=\"add_form\">";
			$sql="select * from audience";
			$result=sqlsrv_query($dbcon, $sql);
			while ($row = sqlsrv_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			echo "
    								</select>
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputPlace\">Место</label>
									<input type=\"number\" class=\"form-control\" id=\"inputPlace\" name=\"inputPlace\" form=\"add_form\" min=\"-1\" max=\"15\">
								</div>
							</div>
							<input type=\"hidden\" name=\"table\" value=\"printScan\" form=\"add_form\">
						</div>
						<div class=\"modal-footer\">
							<button type=\"submit\" class=\"btn btn-secondary\" name=\"add\" form=\"add_form\">Добавить</button>
						</div>
					</div>
				</div>
			</div>";
			break;
		case 'networkSwitch':
			$sql="SELECT [id]
			,[code]
			,[name]
			,[numberOfPorts]
			,[doc]
			,[audience].[name] as audience
			,[audience].[id] as audienceID from networkSwitch inner join audience on networkSwitch.audience=audience.id";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Коммутаторы</h2>";
				echo "<form method='GET' action='add_delete.php' name='add_delete_form' id='add_delete_form'>";
				echo "<input type='submit' class='btn btn-danger float-right mb-2' name='delete' value='Удалить'>";
				echo "<button type=\"button\" class=\"btn btn-primary float-right mb-2 mx-2\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Добавить</button>";
				echo "<input type='hidden' name='table' id='table' value='networkSwitch'>";
				echo "</form>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Количество портов</th><th>Документ</th><th>Аудитория</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['numberOfPorts']."</td><td>".$row['doc']."</td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."&type=".$_GET['type']."\">".$row['audience']."</a></td></tr>";
				}
				echo "</tbody></table>";
			}
			echo "
			<div class=\"modal fade bd-example-modal-lg\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
				<div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">
					<div class=\"modal-content\">
						<form method='GET' action='add_delete.php' name='add_form' id='add_form'></form>
						<div class=\"modal-header\">
							<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Добавление устройства</h5>
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						<div class=\"modal-body\">
							<div class=\"form-row\">
								<div class=\"form-group col-md-3\">
									<label for=\"inputCode\">Инвентарный номер</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCode\" name=\"inputCode\" placeholder=\"Инвентарный номер\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-6\">
									<label for=\"inputName\">Название</label>
									<input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"inputName\" placeholder=\"Название устройства\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"numberOfPorts\">Количество портов</label>
									<input type=\"number\" class=\"form-control\" id=\"numberOfPorts\" name=\"numberOfPorts\" placeholder=\"Количество портов\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-6\">
									<label for=\"inputDoc\">Документ</label>
									<input type=\"text\" class=\"form-control\" id=\"inputDoc\" name=\"inputDoc\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputAudience\">Аудитория</label>
									<select class=\"form-control\" id=\"inputAudience\" name=\"inputAudience\" form=\"add_form\">";
			$sql="select * from audience";
			$result=sqlsrv_query($dbcon, $sql);
			while ($row = sqlsrv_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			echo "
    								</select>
								</div>
							</div>
							<input type=\"hidden\" name=\"table\" value=\"networkSwitch\" form=\"add_form\">
						</div>
						<div class=\"modal-footer\">
							<button type=\"submit\" class=\"btn btn-secondary\" name=\"add\" form=\"add_form\">Добавить</button>
						</div>
					</div>
				</div>
			</div>";
			break;
		case 'interactiveWhiteboard':
			$sql="SELECT interactiveWhiteboard.[id]
			,[code]
			,interactiveWhiteboard.[name]
			,[doc]
			,[audience].[name] as audience
			,[audience].[id] as audienceID FROM [dbo].[interactiveWhiteboard] inner join audience on interactiveWhiteboard.audience=audience.id";
			$result=sqlsrv_query($dbcon, $sql);
			if (!$result) {
				echo '<br>Ошибка выполнения запроса';
			} else {
				echo "<h2 class=\"text-right mb-2\">Интерактивные доски</h2>";
				echo "<form method='GET' action='add_delete.php' name='add_delete_form' id='add_delete_form'>";
				echo "<input type='submit' class='btn btn-danger float-right mb-2' name='delete' value='Удалить'>";
				echo "<button type=\"button\" class=\"btn btn-primary float-right mb-2 mx-2\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Добавить</button>";
				echo "<input type='hidden' name='table' id='table' value='interactiveWhiteboard'>";
				echo "</form>";
				echo "<table class=\"table table-striped table-dark\"><thead><tr><th></th><th>Инвентарный номер</th><th>Наименование</th><th>Документ</th><th>Аудитория</th></tr></thead><tbody>";
				while ($row = sqlsrv_fetch_array($result)) {
					echo "<tr><td><input type='checkbox' name='".$row['id']."' id='".$row['id']."' form='add_delete_form'/></td><td>".$row['code']."</td><td>".$row['name']."</td><td>".$row['doc']."</td><td><a href=\"action_page.php?page=view_audience&audienceID=".$row['audienceID']."&type=".$_GET['type']."\">".$row['audience']."</a></td></tr>";
				}
				echo "</tbody></table>";
			}
			echo "
			<div class=\"modal fade bd-example-modal-lg\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
				<div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">
					<div class=\"modal-content\">
						<form method='GET' action='add_delete.php' name='add_form' id='add_form'></form>
						<div class=\"modal-header\">
							<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Добавление устройства</h5>
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						<div class=\"modal-body\">
							<div class=\"form-row\">
								<div class=\"form-group col-md-4\">
									<label for=\"inputCode\">Инвентарный номер</label>
									<input type=\"text\" class=\"form-control\" id=\"inputCode\" name=\"inputCode\" placeholder=\"Инвентарный номер\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-8\">
									<label for=\"inputName\">Название</label>
									<input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"inputName\" placeholder=\"Название устройства\" form=\"add_form\">
								</div>
							</div>
							<div class=\"form-row\">
								<div class=\"form-group col-md-6\">
									<label for=\"inputDoc\">Документ</label>
									<input type=\"text\" class=\"form-control\" id=\"inputDoc\" name=\"inputDoc\" form=\"add_form\">
								</div>
								<div class=\"form-group col-md-3\">
									<label for=\"inputAudience\">Аудитория</label>
									<select class=\"form-control\" id=\"inputAudience\" name=\"inputAudience\" form=\"add_form\">";
			$sql="select * from audience";
			$result=sqlsrv_query($dbcon, $sql);
			while ($row = sqlsrv_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			echo "
    								</select>
								</div>
							</div>
							<input type=\"hidden\" name=\"table\" value=\"interactiveWhiteboard\" form=\"add_form\">
						</div>
						<div class=\"modal-footer\">
							<button type=\"submit\" class=\"btn btn-secondary\" name=\"add\" form=\"add_form\">Добавить</button>
						</div>
					</div>
				</div>
			</div>";
			break;
		default:
			break;
	}
	echo "<input type=\"hidden\" name=\"typeDevice\" value=\"".$_GET['type']."\" form=\"add_form\">";
}
?>