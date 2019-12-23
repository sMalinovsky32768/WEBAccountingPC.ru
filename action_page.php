<?php
session_start();
/*if (!isset($_GET['type'])) {
	//$_SESSION['page']=$_GET['page'].'.php';
	header("Location:../?page=view_equipment");
}
else {
	//$_SESSION['page']=$_GET['page'].'.php?type='.$_GET['type'];
	header("Location:../?page=view_equipment&type=".$_GET['type']);
	header("Location:../?page=view_equipment&type=".$_GET['type']);
}*/
// header("Location:../?page=view_equipment".(isset($_GET['type'])?'type='.$_GET['type']:''));
header("Location:../?page=".$_GET['page'].(isset($_GET['type'])?'&type='.$_GET['type']:'').(isset($_GET['audienceID'])?'&audienceID='.$_GET['audienceID']:''));
?>