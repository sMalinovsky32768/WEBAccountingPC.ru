<?php
session_start();
?>
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<?php if ($_SESSION['loginCompleted']) { ?>
		<a class="navbar-brand" href="#"><?php echo $_SESSION['login'] ?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php } ?>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Главная</a>
				</li>
				<?php if (isset($_SESSION['loginCompleted']) and ($_SESSION['loginCompleted'])) { ?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="action_page.php?page=view_equipment">Оборудование</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="action_page.php?page=view_equipment&type=PC">Компьютеры</a>
						<a class="dropdown-item" href="action_page.php?page=view_equipment&type=notebook">Ноутбуки</a>
						<a class="dropdown-item" href="action_page.php?page=view_equipment&type=monitor">Мониторы</a>
						<a class="dropdown-item" href="action_page.php?page=view_equipment&type=projector">Проекторы</a>
						<a class="dropdown-item" href="action_page.php?page=view_equipment&type=printScan">Принтеры/Сканеры/МФУ</a>
						<a class="dropdown-item" href="action_page.php?page=view_equipment&type=networkSwitch">Коммутаторы</a>
						<a class="dropdown-item" href="action_page.php?page=view_equipment&type=interactiveWhiteboard">Интерактивные доски</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="action_page.php?page=view_equipment">Все</a>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
			<ul class="navbar-nav">
				<?php if (isset($_SESSION['loginCompleted']) and ($_SESSION['loginCompleted'])) { ?>
				<li class="nav-item">
					<form class="form-inline" method="POST" action="action_exit.php">
						<button type="submit" name="exit" id="exit" class="btn my-0 mx-0 py-2 border-0">Выход</button>
					</form>
				</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
</header>