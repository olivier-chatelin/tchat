<?php
session_start();
require ("IdManager.php");
$idMan = new IdManager();
echo $idMan->checkUser($_POST['pseudo'],$_POST['pass']);