<?php
/**
 * Created by PhpStorm.
 * User: Владислав
 * Date: 08.03.2015
 * Time: 15:23
 */

require 'vk/VK.php';
require 'vk/VKException.php';
require 'vk/Color.php';
error_reporting(E_ALL);

$colors = new Colors();

// Test some basic printing with Colors class
echo $colors->getColoredString("Testing Colors class, this is purple string on yellow background.", "purple", "yellow") . "\n";
echo $colors->getColoredString("Testing Colors class, this is blue string on light gray background.", "blue", "light_gray") . "\n";
echo $colors->getColoredString("Testing Colors class, this is red string on black background.", "red", "black") . "\n";
echo $colors->getColoredString("Testing Colors class, this is cyan string on green background.", "cyan", "green") . "\n";
echo $colors->getColoredString("Testing Colors class, this is cyan string on default background.", "cyan") . "\n";
echo $colors->getColoredString("Testing Colors class, this is default string on cyan background.", null, "cyan") . "\n";


$vk_config = array(
    'app_id'       => '4817820',
    'api_secret'   => 'DGtGK74oOwIRO589YlEd',
    'callback_url' => 'http://api.vk.com/blank.html',
    'api_settings' => 'wall,groups,offline',
    'access_token' => 'b7ffda95a585a8ec2a97f5e08e37bb329719764e244507da068f20246269d4155554c11c8b22ca47f1ca9'
);
//683897451fb9aafbc8
$vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret']);
    /**
     * If you need switch the application in test mode,
     * add another parameter "true". Default value "false".
     * Ex. $vk->getAuthorizeURL($api_settings, $callback_url, true);
     */
    $authorize_url = $vk->getAuthorizeURL(
        $vk_config['api_settings'], $vk_config['callback_url']);
    echo '<a href="' . $authorize_url . '">Sign in with VK</a>';
$access_token = $vk->getAccessToken('683897451fb9aafbc8', $vk_config['callback_url']);
echo 'access token: ' . $access_token['access_token']
    . '<br />expires: ' . $access_token['expires_in'] . ' sec.'
    . '<br />user id: ' . $access_token['user_id'] . '<br /><br />';


//while (true) {
//    send_group_list($vk_config);
//    sleep(10);
//}

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

