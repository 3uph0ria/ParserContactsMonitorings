<?php
class Monitorings
{
    public function GetListing($MonitoringLink)
    {
         $listing = file_get_contents($MonitoringLink . '/listing/');
         return preg_replace('/\s+/', ' ', strip_tags($listing, '<table><tr><td>'));
    }

    public function GetServerInfo($MonitoringLink, $ServerIp)
    {
        $serverInfo = preg_replace('/\s+/', ' ', strip_tags(file_get_contents($MonitoringLink . '/servers/' . $ServerIp . '/info/'), '<table><tr><td>'));
        $contacts = explode("Контакты:", $serverInfo);
        $contactsTmp = explode(" ", $contacts[1]);
        $contact['contact'] = str_replace("&ensp;", "", $contactsTmp[0]);

        $contacts = explode("WEB-сайт:", $serverInfo);
        $contactsTmp = explode(" ", $contacts[1]);
        $contact['webSite'] = str_replace("&ensp;", "", $contactsTmp[0]);
        return $contact;
    }

    public function IsIp($str)
    {
        if(strpos($str, ":") === false)
        {
            return false;
        }
        else
        {
            $tmp = explode(":", $str);
            for($i = 0; $i < count($tmp); $i++)
            {
                $startMessage = explode(" ", $tmp[$i]);
                $endMessage = explode(" ", $tmp[$i + 1]);

                $ip = $startMessage[Count($startMessage) - 1];
                $port = $endMessage[0];
                $octet = explode(".", $ip);
                $ipNumeric = "";

                if(count($octet) == 4)
                {
                    for($j = 0; $j < count($octet); $j++)
                    {
                        $ipNumeric .= $octet[$j];
                    }

                    if(is_numeric($ipNumeric) && is_numeric($port))
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
        }
    }
}