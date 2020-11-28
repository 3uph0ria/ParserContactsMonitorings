<?php
class Database
{
    private $link;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $config = require_once 'config_bd.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbName'] . ';charset=' . $config['charset'];
        $this->link = new PDO($dsn, $config['userName'], $config['password']);
        return $this;
    }

    public function GetContacts($contacts, $webSite)
    {
        $botUser = $this->link->prepare("SELECT * FROM `contacts` WHERE `contacts` = ? OR `web_site` = ?");
        $botUser->execute(array($contacts, $webSite));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function AddContacts($contacts, $webSite)
    {
        $botUser = $this->link->prepare("INSERT INTO `contacts` (`contacts`, `web_site`) VALUES(?, ?)");
        $botUser->execute(array($contacts, $webSite));
    }
}