<?php
class VK
{
    public function __construct()
    {
        $this->data = json_decode(file_get_contents('php://input'), true);
        if($this->data['type'] == 'confirmation') exit($this->key);
    }

    public function request($method, $params = array())
    {
        $config = require_once 'config_vk.php';
        $url = 'https://api.vk.com/method/' . $method;
        $params['access_token'] = $config['access_token'];
        $params['v'] = $config['v'];
        if(function_exists('curl_init'))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $result = json_decode(curl_exec($ch), True);
            curl_close($ch);
        }
        else
        {
            $result = json_decode(file_get_contents($url, true, stream_context_create(array('http' => array('method' => 'POST', 'header' => "Content-type: application/x-www-form-urlencoded\r\n", 'content' => http_build_query($params))))), true);
        }
        if(isset($result['response'])) return $result['response'];
        else
            return $result;
    }
}
