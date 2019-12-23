<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap-reboot.css">
	<link rel="stylesheet" href="css/bootstrap-grid.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body class="row no-gutters">
	<div class="col-12 border" id="center">
		<?php require 'header.php'; ?>
		<div id="content" class="px-4 pt-4 col-md-12 col-lg-11 col-xl-10 mx-auto">
		<?php 
		if (!isset($_SESSION['loginCompleted'])) {
			header("Location:");
			require 'login.php';
		}
		if ($_SESSION['loginCompleted'] and isset($_GET['page'])) {
			require 'http://accountingpc.ru/'.$_GET['page'].'.php?'.(isset($_GET['type'])?'type='.$_GET['type']:'').(isset($_GET['audienceID'])?'&audienceID='.$_GET['audienceID']:'');
		}
		?>
		</div>
		<?php require 'footer.php'; ?>
	</div>
</body>
</html>