<?php
require ("IdManager.php");
$idMan = new IdManager();
echo $idMan->setUser($_POST['pseudo'],$_POST['pass']);