<?php
session_start();
if(isset($_GET["out"])){
  unset($_SESSION["LOGIN"]);
  die("logout ok");
}
if($_POST["password"] == "**********"){
  $_SESSION["LOGIN"] = "a";
  header("Location: index.php");
}
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ログイン</title>
</head>
<h1>ログイン</h1>
<form action="" method="post">
パスワード:<input type="password" name="password" size="40" required><br>
<input type="submit" value="Login">
</form>
