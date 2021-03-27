<?php
session_start();
require 'MessageManager.php';
require 'IdManager.php';
$db = new MessageManager();
if ($_GET['session']=="ok"){

    echo $_SESSION['username'];
}

switch ($_GET['which']){
    case "all":
        $firstMessage = 1;
        $lastMessage = $db->lastId();
        sendMessages($db,$firstMessage,$lastMessage); 
    break;
    case "last":
    break;
}
if ($_GET['data'] == "refresh"){
    $lastRecieved = (int)$db->getLastIdMessage($_SESSION['username']);
    $lastWrittenOnLine = (int)$db->lastId();
    if ($lastRecieved == $lastWrittenOnLine){
        $reponse = ["null"];
        echo json_encode($reponse);
    }
    else {
        $first = $lastRecieved+1;
        $last = $lastWrittenOnLine;
        sendMessages($db,$first,$last);
    }
    
}

if (isset($_POST['text'])){
    $firstMessage = $db->setMessage($_POST['text']);
    $lastMessage = $firstMessage;
    sendMessages($db,$firstMessage,$lastMessage); 

}
function sendMessages($db,$first,$last){
    
    $messages = [];
    for ( $i = $first; $i <= $last; $i++){
        $messages[]= $db->getMessage($i);
    }
    echo json_encode($messages);
}