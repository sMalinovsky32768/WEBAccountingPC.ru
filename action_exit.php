<?php
session_start();
if (isset($_POST['exit'])) {
   $_SESSION['loginCompleted']=false;
   session_destroy();
   header("Location:index.php");
}
header("Location:../");
header("Location:../");
?>