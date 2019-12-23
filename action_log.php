<?php
require_once "dbconnect.php";
if (isset($_POST['submit'])) {
   session_start();
   $_SESSION['loginCompleted']=false;
   $log=$_POST['inputLogin'];
   $pass=$_POST['inputPassword'];
   $sql="SELECT * FROM Admins WHERE ((adminLogin = '$log') and (pass = '$pass'));";
   $result=sqlsrv_query($dbcon, $sql);
   if (!$result) {
      session_destroy();
   } else {
      if ($row = sqlsrv_fetch_array($result)) {
         $_SESSION['id']=$row['id'];
         $_SESSION['login']=$row['adminLogin'];
         $_SESSION['pass']=$row['pass'];
         $_SESSION['loginCompleted']=true;
      }
      header("Location:../");
      header("Location:../");
   }
}
?>