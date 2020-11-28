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

    public function GetAllContacts()
    {
        $contactsAll = $this->link->query("SELECT * FROM `contacts`");
        while ($contact = $contactsAll->fetch(PDO::FETCH_ASSOC))
        {
            $contacts[] = $contact;
        }
        return $contacts;
    }

    public function GetContacts($contacts, $webSite)
    {
        $contact = $this->link->prepare("SELECT * FROM `contacts` WHERE `contacts` = ? OR `web_site` = ?");
        $contact->execute(array($contacts, $webSite));
        return $contact->fetch(PDO::FETCH_ASSOC);
    }

    public function AddContacts($contacts, $webSite)
    {
        $contact = $this->link->prepare("INSERT INTO `contacts` (`contacts`, `web_site`) VALUES(?, ?)");
        $contact->execute(array($contacts, $webSite));
    }
}