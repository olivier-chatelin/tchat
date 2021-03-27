<?php
session_start();

class Message{
    public $id;
    public $author;
    public $text;
    public $date;

    public function __construct($id,$author,$text,$date)
    {
        $this->id = $id;
        $this->author = $author;
        $this->text = $text;
        $this->date = $date;

    }
}