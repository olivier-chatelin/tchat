<?php
session_start();
require 'Message.php';

class MessageManager{
    private $host = "localhost";
    private $dbname = "Chat";
    private $user = "olivier";
    private $password = "minettes";

    function dbConnect(){
        try{
            $db = new PDO("mysql:hostname=$this->host;charset=utf8;dbname=$this->dbname",$this->user,$this->password);
        }
        catch(Exception $e){
            die('Erreur '.$e->getMessage());
        }
        return $db;
    }
    function getMessage($id){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM chat_table WHERE id=:id');
        $req->bindValue(":id",$id);
        $req->execute();
        $data = $req->fetch();
        $this->refreshLastId($id);
        return new Message($data['id'],$data['author'],$data['message'],$this->transformDate($data['date']));
    }
    function lastId(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT id FROM chat_table ORDER BY id DESC LIMIT 0,1');
        $data = $req->fetch();
        return $data['id'];
    }
    public function setMessage($message){
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO chat_table(author, message, date) VALUES (:author,:message,NOW())');
        $req->bindValue(':author' , $_SESSION['username']);
        $req->bindValue(':message' , $message);
        $req->execute();
        return $this->lastId();


    }
    public function refreshLastId($id){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE login SET lastIdMessage=:id WHERE pseudo = :pseudo');
        $req->bindValue(":id",$id);
        $req->bindValue(":pseudo",$_SESSION['username']);
        $req->execute();
    }
    public function transformDate($oldDate){
        $date = new DateTime($oldDate);
        return "le ".$date->format('d/m/Y à H:i');
    }
    function getLastIdMessage($name){
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT lastIdMessage FROM login WHERE pseudo = :name");
        $req->bindValue(':name',$name);
        $req->execute();
        $data = $req->fetch();
        return $data['lastIdMessage'];
        
    }
}
// $db = new MessageManager();
// echo $db->lastId();
// echo "<br/>";
// $name = $_SESSION['username'];
// echo $db->getLastIdMessage($name);



