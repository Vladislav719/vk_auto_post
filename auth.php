<?php
/**
 * Created by PhpStorm.
 * User: Владислав
 * Date: 14.03.2015
 * Time: 19:42
 */

require 'vk/VK.php';
require 'vk/VKException.php';

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
// */
//$authorize_url = $vk->getAuthorizeURL(
//    $vk_config['api_settings'], $vk_config['callback_url']);
//echo '<a href="' . $authorize_url . '">Sign in with VK</a>';
echo 1;
$access_token = $vk->getAccessToken('8b0a50390f5ba63c6e', $vk_config['callback_url']);
echo 'access token: ' . $access_token['access_token'];
