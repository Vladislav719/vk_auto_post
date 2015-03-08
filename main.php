<?php
/**
 * Created by PhpStorm.
 * User: Владислав
 * Date: 08.03.2015
 * Time: 15:23
 */

require 'vk/VK.php';
require 'vk/VKException.php';
error_reporting(E_ALL);

$vk_config = array(
    'app_id'       => '4817820',
    'api_secret'   => 'DGtGK74oOwIRO589YlEd',
    'callback_url' => 'http://api.vk.com/blank.html',
    'api_settings' => 'wall,groups,offline',
    'access_token' => 'ea951a16fd6d1e37604b400d5344ee5a186ba2727124c877c66e5dd37c335cf22639461dfc6e87881482e'
);

while (true) {
    send_group_list($vk_config);
    sleep(10);
}

function send_group_list($vk_config) {
    $fin = fopen('groups.dat', 'r');

    if (!$fin){
        echo 'error open file groups.dat\n';
        exit;
    }
    while ($line = fgets($fin)) {
        $line = chop($line); //удаляем пробелы из строки
        list($group_id, $message_text) = explode(":",$line);

        send_message($group_id, $message_text, $vk_config);
        sleep(1);
    }
}


function send_message($where_to, $message_text, $vk_config) {
    $vk = new \VK\VK($vk_config['app_id'], $vk_config['api_secret'], $vk_config['access_token']);
    $msg = $vk -> api('wall.post', array(
        'owner_id' => $where_to,
        'message'  => $message_text
    ));

    $msg = $msg['response'];
    $post_id = $msg['post_it'];

    echo "Message was sent to " . $where_to . " with post ID = " . $post_id;
}