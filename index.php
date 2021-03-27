<?php
session_start();
// header('Location:connexion.html');
// exit();
// echo $_SESSION['username'];
if($_GET['endsession']=="true"){
    session_destroy();
    header('Location:connexion.html');
    exit();

}
if (isset($_GET['inscription'])){
    header('Location:inscription.html');
    exit();
}

if (!isset($_SESSION['username']) || $_SESSION['username'] == null){
    header('Location:connexion.html');
    exit();
}
else {
    header("Location:exchange.html");
    exit();
}