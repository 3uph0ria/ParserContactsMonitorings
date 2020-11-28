<?php
/* Данный скрипт подойдет для мониторингов
 *  https://serverov.net
 */
spl_autoload_register(function ($className )
{
    require_once('../Class/' . $className . '.php');
});

$Database = new Database();
$Monitorings = new Monitorings();
$VK = new VK();

$monitoringLink = 'https://serverov.net';
$listing = $Monitorings->GetListing($monitoringLink);

$rows = explode('</tr>', $listing);
for($i = 900; $i < Count($rows); $i++)
{
    $columens = explode('</td>', $rows[$i]);
    $columensTmp = explode(">", $columens[2]);

    // Проверяем является ли столбец IP-адресом
    if($Monitorings->IsIp(trim(str_replace("&ensp;", "" , $columensTmp[1]))))
    {
        // Получаем информацию о контактах и веб-сайте со страницы сервера
        $serversContacts = $Monitorings->GetServerInfo($monitoringLink, trim(str_replace("&ensp;", "" , $columensTmp[1])));

        // Проверям чтобы один из контактов был со ссылкой на vk
        if(strpos($serversContacts['contact'], "vk.com") !== false || strpos($serversContacts['webSite'], "vk.com") !== false)
        {

            // Проверка уникальности контакта
            $check = $Database->GetContacts($serversContacts['contact'], $serversContacts['webSite']);
            if(!$check)
            {
                $clubVk = explode("https://",  $serversContacts['webSite']) ;
                $club = explode("https://vk.com/", $serversContacts['webSite']);
                $groupsGetById = $VK->request("groups.getById", ["group_ids" => $club[1]]);

                // Проверяем валидность группы
                if($groupsGetById[0]['id'])
                {
                    $Database->AddContacts($serversContacts['contact'], $clubVk[1]);

                    // Узнаем, где остановился скрипт в случае чего)
                    $fo = fopen('i.txt', 'w+');
                    fwrite($fo, $i);
                }
            }
        }
    }
}
