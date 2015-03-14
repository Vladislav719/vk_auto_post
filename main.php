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

$vk_config = array(
    'app_id'       => '4817820',
    'api_secret'   => 'DGtGK74oOwIRO589YlEd',
    'callback_url' => 'http://api.vk.com/blank.html',
    'api_settings' => 'wall,groups,offline',
    'access_token' => 'fe9ec3545fc85336de925db942c1986497d288e8bbb3d7fe29865dd7b97afb964986b994371bbc1b122e7'
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
echo 1;
$access_token = $vk->getAccessToken('3d2d41fbcebfe18bc5', $vk_config['callback_url']);
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

function check_wall($group_id, $vk_config) {
    $color = new Colors();
    $vk = new \VK\VK($vk_config['app_id'], $vk_config['api_secret'], $vk_config['access_token']);
    $obj_res = $vk -> api('wall.get', array(
        'owner_id' => $group_id,
        'count'    => 1,
        'filter'   => 'all'
    ));
    $response = $obj_res['response'];
    $items = $response['items'];
    $owner_id = $items['from_id'];
    echo $color-> getColoredString($owner_id, "purple", "yellow");
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

