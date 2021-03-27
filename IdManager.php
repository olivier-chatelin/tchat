<?php
session_start();
class IdManager{    
    private $host = "localhost";
    private $dbname = "Chat";
    private $user = "olivier";
    private $password = "minettes";

    private function dbConnect(){
        try{
            $db = new PDO("mysql:hostname=$this->host;charset=utf8;dbname=$this->dbname",$this->user,$this->password);
        }
        catch (Exception $e){
            die('Erreur '.$e->getMessage());
        }
        return $db;
    }
    function checkUser($name,$pass){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM login WHERE pseudo = :name');
        $req->bindValue(":name",$name);
        $req->execute();
        $reponse = $req->fetch();
        if ($reponse['loginId'] == null){
            return  $name." n'existe pas dans la base de donnée ";
        }
        else{
            if ($pass == $reponse['pass']){
                $_SESSION['username'] = $name;
                return "ok";
            }
            else {
                return "Le mot de passe n'est pas bon ";
            }
            
            
        }
        
    }
    function setUser($name,$pass){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM login WHERE pseudo = :name');
        $req->bindValue(":name",$name);
        $req->execute();
        $reponse = $req->fetch();
        if ($reponse['loginId'] != null){
            return  $name." est un nom qui existe déjà";
        }
        
        else{
            $req->closeCursor();
            $req = $db->prepare('INSERT INTO login (pseudo, pass) VALUES (:pseudo,:pass)');
            $req->bindValue(':pseudo' , $name);
            $req->bindValue(':pass' , $pass);
            $req->execute();
            $_SESSION['username'] = $name;
            return "ok";


        }
    
        
    }



}

